<?php

namespace tamirh67\MediaManager;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use tamirh67\MediaManager\models\exObj1;
//use tamirh67\MediaManager\models\Media;
use App\exObj1;
use App\Media;

class Ex1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ex1list= exObj1::all();

        $ex1objects = \DB::table('example_object1')
            ->leftJoin('media', function ($join) {
                $join->on('example_object1.id', '=', 'media.mediaable_id')
                    ->where('media.mediaable_type', '=', 'App\exObj1');
            })
            ->select('example_object1.*', 'media.thumbsURL as thumbsURL', 'media.id as MID')
            ->orderBy('id', 'asc')
            ->get();

        return view('media-manager::ex1_list', compact('ex1objects'), compact('ex1list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $ex1 = exObj1::where('id','=',$id)->first();

        $theDocuments   = $ex1->mymedia()->get();

        return view('media-manager::ex1_edit')
            ->with('theObject', $ex1)
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
}
