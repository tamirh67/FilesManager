<?php

namespace tamirh67\FilesManager;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use tamirh67\FilesManager;
use tamirh67\FilesManager\Media;
//use App\Media;


class FilesController extends Controller
{

    public function createThumbnail($sourcefilepath, $outputDirPath, $originalfilename, $sizex, $sizey) {

        $final_width_of_image   = $sizex;
        $final_height_of_image  = $sizey;

        $path_to_thumbs_directory   = public_path().'/img/thumbs/';
        //$storagePath                = storage_path().'/app/uploads/'.$sourcefilename;
        $thumbPath                  = public_path().'/'.$outputDirPath;

        if(preg_match('/[.](jpg|JPG|jpeg|JPEG)$/', $originalfilename)) {
            $im = imagecreatefromjpeg($sourcefilepath);
        } else if (preg_match('/[.](gif)$/', $originalfilename)) {
            $im = imagecreatefromgif($sourcefilepath);
        } else if (preg_match('/[.](png)$/', $originalfilename)) {
            $im = imagecreatefrompng($sourcefilepath);
        }

        $ox = imagesx($im);
        $oy = imagesy($im);

        if ($oy < $ox) // landscape
        {
            $nx = $final_width_of_image;
            $ny = floor($oy * ($final_width_of_image / $ox));
        }
        else // portrait
        {
            $ny =  $final_height_of_image;
            $nx =  floor($ox * ($final_height_of_image / $oy));
        }

        $nm = imagecreatetruecolor($nx, $ny);

        imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
        //dd($outputDirPath.'/'.$originalfilename);
        if(!file_exists($thumbPath)) {
            if(!mkdir($thumbPath)) {
                return false; //die("There was a problem. Please try again!");
            }
        }

        imagejpeg($nm, $thumbPath.'/'.$originalfilename);

        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \tamirh67\FilesManager\FilesManager::hello() . ' from controller.';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * validate a single upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function isImage($upload)
    {
        $rules = array(
            'file' => 'image'
        );
        $validator = \Validator::make(array('file'=> $upload), $rules);

        return $validator->passes();

    }

    /**
     * validate a single upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validate_upload($upload)
    {
        // VALIDATION RULES
        $rules = array(
            'file' => 'required|mimes:png,gif,jpeg,jpg,bmp,txt,pdf,doc,rtf,xls,xlsx|max:5000000'
        );
        $validator = \Validator::make(array('file'=> $upload), $rules);

        if ( $validator->passes() == FALSE )
            return FALSE;

        // CHECK THE FILE
        switch ($upload->guessClientExtension())
        {
            case 'jpg':
            case 'jpeg':
            case 'svg':
            case 'png' :
            case 'gif' :
                if ( $upload->isValid() == FALSE )
                    return false;
                break;
            default:

                break;

        }

        return true;
    }

    /**
     * move one file
     *
     * @param  uploaded file file
     * @return boolean
     */
    public function move_one_file($file)
    {
        \Log::info('file extension is '.$file->guessClientExtension());

        $ext            = $file->guessClientExtension(); // (Based on mime type)
        $filename       = $file->getClientOriginalName();
        $size           = $file->getClientSize();
        $targetDir      = storage_path('app/uploads/');

        // Make a random new file name
        $weirdFilename  = $this->generateKeyname($file);

        // move file
        try {
            if ($this->isImage($file))
            {
                //$file()->move($targetDir, $weirdFilename);
                $img = \Image::make($file)->orientate()->save($targetDir.'/'.$weirdFilename);
                $img->destroy();
            }
            else
                $file()->move($targetDir, $weirdFilename);
        } catch (Exception $e) {
            return false;
        }

        // CREATE THE THUMBNAIL IN THE IMG DIRECTORY
        switch ($ext)
        {
            case 'jpg':
            case 'jpeg':
            case 'png' :
            case 'gif' :
                $thumbDirURL = '/img/thumbs/'.str_random(8);
                $thumbPath   = public_path().$thumbDirURL;
                //$this->createThumbnail($finalURL, $thumbDirURL, $filename, 250, 250);
                if(!file_exists($thumbPath)) {
                    if(!mkdir($thumbPath)) {
                        $thumbDirURL="";
                        break;//return false;
                    }
                }
                $img = \Image::make($targetDir.'/'.$weirdFilename)->fit(250)->orientate()->save($thumbPath.'/'.$filename);
                $img->destroy();
                $thumbnailURL = $thumbDirURL.'/'.$filename;
                break;
            default:
                $thumbnailURL = '/img/48px/'.$ext.'.png';
                break;

        }

        // FIRST LET"S CREATE THE FILE DATA RECORD
        //$customer_id = \Auth::user()->customer_id;
        $newFile= new Media;
        //$newFile->owner_id        = $customer_id;
        $newFile->mediaable_id      = \Input::get('mediaable_id');
        $newFile->mediaable_type    = \Input::get('mediaable_type'); // table
        $newFile->displayname       = $filename;
        $newFile->actualname        = $weirdFilename;
        $newFile->url               = $targetDir;
        $newFile->filetype          = $ext;
        $newFile->description       = \Input::get('description');
        $newFile->caption           = \Input::get('caption');
        $newFile->filesize          = $size;
        $newFile->thumbsURL         = $thumbnailURL;
        $newFile->scanned           = 0;
        $newFile->save();

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $returnURL  = \Request::server('HTTP_REFERER');

        if (\Input::hasFile('file'))
        {
            $all_uploads = \Input::file('file');

            if (!is_array($all_uploads))
            {
                $all_uploads = array($all_uploads);
            }

            foreach ($all_uploads as $upload)
            {
                if ($this->validate_upload($upload))
                {
                    if ($this->move_one_file($upload)==false)
                        return redirect($returnURL)->with('message', 'some files could not be uploaded' )->with('type','alert-danger')->with('activePane','documents');
                } else
                {
                    //Does not pass validation
                    return redirect($returnURL)->with('message', 'upload unsuccesful' )->with('type','alert-danger')->with('activePane','documents');
                }
            }
        }
        else
        {
            return redirect($returnURL)->with('message', 'no file' )->with('type','alert-danger')->with('activePane','documents');
        }
        return redirect($returnURL)->with('message', 'files uploaded successfully')->with('type','alert-success')->with('activePane','documents');
    }

    public function generateKeyname($upload)
    {
        $ext = $upload->guessClientExtension();
        $weirdFilename  = str_random(16).'.'.$ext;
        $finalURL       = storage_path().'app/uploads/'.$weirdFilename;
        // check if it exists, if not create another
        if ( file_exists ( $finalURL ) )
        {
            $weirdFilename = str_random(16).'.'.$ext;
            $finalURL = storage_path().'app/uploads/'.$weirdFilename;
        }

        return $weirdFilename;
    }


    public function store_ajax(){

        $input  = \Input::all();
        $file   = \Input::file('file');

        if ($this->validate_upload($file)==false)
        {
            return \Response::json('error', 400);
        }

        if ($this->move_one_file($file))
        {
            return \Response::json('success', 200);
        }

        return \Response::json('error', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnURL          = \Request::server('HTTP_REFERER');
        $documentID         = $id;
        //$customer_id        = \Auth::user()->customer_id;
        $theDocument        = Media::find($documentID);
        $theEntityType      = $theDocument->mediaable_type;
        $theEntityID        = $theDocument->mediaable_id;

        // GET THE ENTITY, SEE IF IT MATCHES THE CUSTOMER

        if ($theDocument)
        {

            $docURL = $theDocument->url.$theDocument->actualname;
            //dd($docURL);
            // remove thumbnail only if file is an image
            switch ($theDocument->filetype)
            {
                case 'jpg':
                case 'jpeg':
                    if (file_exists($docURL)) {
                        // read the file into a string
                        $content = file_get_contents($docURL);
                        // create a Laravel Response using the content string, an http response code of 200(OK),
                        //  and an array of html headers including the pdf content type
                        return \Response::make($content, 200, array('content-type'=>'image/jpg'));
                    }
                    break;
                case 'bmp':
                case 'png':
                    // header to the image content
                    //dd($theDocument->filetype);
                    if (file_exists($docURL)) {
                        // read the file into a string
                        $content = file_get_contents($docURL);
                        // create a Laravel Response using the content string, an http response code of 200(OK),
                        //  and an array of html headers including the pdf content type
                        return \Response::make($content, 200, array('content-type'=>'image/png'));
                    }
                    break;

                case 'pdf':
                    // header to the PDF content
                    if (file_exists($docURL)) {
                        // read the file into a string
                        $content = file_get_contents($docURL);
                        // create a Laravel Response using the content string, an http response code of 200(OK),
                        //  and an array of html headers including the pdf content type
                        return \Response::make($content, 200, array('content-type'=>'application/pdf'));
                    }
                    break;
                default:
                    // download request
                    //dd(1);
                    return \Response::download($docURL);
                    break;
            }

            return redirect($returnURL)->with('message', 'Could not find a proper component to present file' )->with('type','alert-success')->with('activePane','documents');
        }
        else
        {
            return redirect($returnURL)->with('error', 'Document record not found' )->with('type','alert-danger')->with('activePane','documents');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

        $returnURL          = \Request::server('HTTP_REFERER');
        $theEntityID        = \Input::get('mediaable_id');
        $theEntityType      = \Input::get('mediaable_type');
        $documentID         = \Input::get('id');
        //$customer_id        = \Auth::user()->customer_id;

        // GET THE ENTITY, SEE IF IT MATCHES THE CUSTOMER
        //$theEntity          = \DB::table($theEntityType)->find($theEntityID );
        //if ($theEntity->customer_id <> $customer_id)
        //     return redirect($returnURL)->with('message', 'File / customer mismatch, document not deleted' )->with('type','alert-danger')->with('activePane','documents');

        // Get the file
        $theDocument = Media::find($documentID);

        if ($theDocument)
        {

            $docURL = $theDocument->url.$theDocument->actualname;
            // delete the physical file
            if ( file_exists($docURL) )
                if ( unlink($docURL) == FALSE )
                {

                }

            // REMOVE THE THUMBNAIL
            $fullThumbsURL = public_path().$theDocument->thumbsUrl;
            // remove thumbnail only if file is an image
            switch ($theDocument->filetype)
            {
                case 'jpg':
                case 'jpeg':
                case 'bmp':
                case 'png':
                    if ( file_exists($fullThumbsURL) )
                        if (unlink($fullThumbsURL) == FALSE ) {
                        }
                    // remove the thumbnail folder
                    if ( file_exists(dirname($fullThumbsURL)) )
                        if (rmdir(dirname($fullThumbsURL)) == FALSE )
                        {
                        }
                    break;
            }


            // delete the record
            $theDocument->delete();

            return redirect($returnURL)->with('message', 'Document deleted successfully' )->with('type','alert-success')->with('activePane','documents');
        }
        else
        {
            return redirect($returnURL)->with('error', 'Document record not found' )->with('type','alert-danger')->with('activePane','documents');
        }
    }
}
