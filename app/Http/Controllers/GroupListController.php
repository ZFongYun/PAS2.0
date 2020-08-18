<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Team;
use Illuminate\Http\Request;

class GroupListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher_frontend.GroupList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = Student::all()->toArray();
        return view('teacher_frontend.GroupListCreate',compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team_name = $request->input('name');
        $team = new Team;
        $team -> name = $team_name;
        $team -> save();

        $team_id = Team::where('name',$team_name)->value('id');

        foreach($_POST['student'] as $studentid){
            $role = $request->input('role'.$studentid);
            $position = $request->input('position'.$studentid);

            $student = Student::find($studentid);
            $student -> role = $role;
            $student -> position = $position;
            $student -> team_id = $team_id;
            $student -> save();
        }



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
