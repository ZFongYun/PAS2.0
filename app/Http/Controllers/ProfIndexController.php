<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use Illuminate\Http\Request;

class ProfIndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $bulletin = Bulletin::all()->toArray();
        return view('teacher_frontend.index',compact('bulletin'));
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
        $title = $request->input("title");
        $content = $request->input("content");
        $meeting_bulletin = new Bulletin;
        $meeting_bulletin->title = $title;
        $meeting_bulletin->content = $content;
        $meeting_bulletin->save();
        return redirect('/APS_teacher');
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
        $title = $request->input("title");
        $content = $request->input("content");
        $bulletin = Bulletin::where('id','=',$id)->first();
        $bulletin->title = $title;
        $bulletin->content = $content;
        $bulletin->save();
        return redirect('/APS_teacher');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bulletin = Bulletin::find($id);
        $bulletin -> delete();
        return redirect('/APS_teacher');
    }
}
