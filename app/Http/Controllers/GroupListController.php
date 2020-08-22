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
        $teamName = Team::all('name')->toArray();
        $teamId = Team::all('id')->toArray();

        $team_length = count($teamId);

        $student = Student::whereHas('team',function ($q){
            $q->where('team_id','1');
        })->get('name');
        $arr_leader = array();
        $arr_member = array();
        $arr_team = array($teamName);
        $arr_id = array($teamId);

        foreach ($teamId as $id){
            $student = Student::whereHas('team',function ($q) use ($id) {
                $q->where('team_id',$id);
            })->get(['name','role'])->toArray();
            $student_length = count($student);
            $leader = "";
            $member = "";

            for ($i = 0; $i < $student_length; $i++){
                if ($student[$i]['role'] == 0){
                    $leader = $leader." ".$student[$i]['name'];
                }else if($student[$i]['role'] == 1){
                    $member = $member." ".$student[$i]['name'];
                }

            }
            array_push($arr_leader,$leader);
            array_push($arr_member,$member);

        }

        return view('teacher_frontend.GroupList',compact('arr_id','arr_team','arr_leader','arr_member','team_length'));
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

                        $team -> name = $team_name;
                        $team -> save();

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
        $team_name = Team::where('id',$id)->value('name');
        $student = Student::whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','name','student_id','role','position'])->toArray();
        $student_length = count($student);

        return view('teacher_frontend.GroupListShow',compact('team_name','student_length','student'));
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

    public function plus()
    {
        return 'hi';
    }

    public function destroy_member($id)
    {
        $student = Student::find($id);
        $student -> team_id = null;
        $student -> role = null;
        $student -> position = null;
        $student -> save();

        return back();
    }
}
