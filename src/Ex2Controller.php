<?php

namespace tamirh67\MediaManager;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use tamirh67\MediaManager\exObj2;

class Ex2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$ex2objects = exObj2::all();
        $ex2list = \DB::table('example_object2')
            ->leftJoin('media', 'example_object2.avatarID', '=', 'media.id')
            ->select('example_object2.*', 'media.thumbsURL as thumbsURL', 'media.filetype')
            ->orderBy('id', 'asc')
            ->get();


        return view('MediaManager::ex2_list')
            ->with('ex2objects', $ex2list)
            ;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ex2 = exObj2::where('id','=',$id)->first();

        $theDocuments   = $ex2->mymedia()->get();

        return view('MediaManager::ex2_edit')
            ->with('theObject', $ex2)
            ->with('theDocuments', $theDocuments)
            ;
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
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function makeAvatar()
    {
        $returnURL          = \Request::server('HTTP_REFERER');
        $theEntityID        = \Input::get('mediaable_id');
        $theEntityType      = \Input::get('mediaable_type');
        $objectID           = \Input::get('object_id');
        $documentID         = \Input::get('doc_id');

        $ex2 = exObj2::where('id','=',$objectID)->first();

        $ex2->avatarID = $documentID;

        $ex2->save();

        return redirect($returnURL)->with('message', 'Avatar Saved' )->with('type','alert-success');

    }
}
