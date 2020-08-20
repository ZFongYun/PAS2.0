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
        $student = Student::where('team_id',null)->get();
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
        if(isset($_POST['student'])){
            $team_name = $request->input('name');
            $team = new Team;
            $team -> name = $team_name;
            $team -> save();

            $team_id = Team::where('name',$team_name)->value('id');

            $leader = 0;
            $member = 0;

            foreach($_POST['student'] as $studentId){
                $role = $request->input('role'.$studentId);
                if($role==0){
                    $leader++;
                }else{
                    $member++;
                }
            }
            if($leader != 0){
                if($leader >=2){
                    // 組長重複
                    return back()->with('error','組長已重複，請重新選擇');
                }else{
                    // 完成條件
                    foreach($_POST['student'] as $studentId){
                        $role = $request->input('role'.$studentId);
                        $position = $request->input('position'.$studentId);

                        $student = Student::find($studentId);
                        $student -> role = $role;
                        $student -> position = $position;
                        $student -> team_id = $team_id;
                        $student -> save();
                    }
                    return redirect('GroupList');
                }
            }else{
                // 未選擇組長
                return back()->with('repeat','請選擇組長');
            }
        }else{
            return back()->with('warning','請選擇組員');
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
