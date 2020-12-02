<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class StuGroupListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $studentID = auth('student')->user()->student_ID;
//        $stu_team = Student::where('student_ID',$studentID)->value('team_id');
//        $stu_role = Student::where('student_ID',$studentID)->value('role');
//        if ($stu_team == null){
//            $warning = '未加入組別';
//            return view('student_frontend.GroupList',compact('warning'));
//        }else{
//            $team_name = Team::where('id',$stu_team)->value('name');
//            $team_member = Student::where('team_id',$stu_team)->get(['student_ID','name','role','position'])->toArray();
//            $team_member_length = count($team_member);
//            return view('student_frontend.GroupList',compact('team_name','team_member','team_member_length','stu_role','stu_team'));
//        }
        $studentId = auth('student')->user()->id;
        $stu_team = TeamMember::where('student_id',$studentId)->value('team_id');
        $stu_role = TeamMember::where('student_ID',$studentId)->value('role');
        if ($stu_team == null){
            $warning = '未加入組別';
            return view('student_frontend.GroupList',compact('warning'));
        }else{
            $team_name = Team::where('id',$stu_team)->value('name');
            $team_member = TeamMember::with(array('student'=>function($query){
                $query->select('id','name','student_id');
            }))->with(array('team'=>function($query){
                $query->select('id','name');
            }))->whereHas('team',function ($q) use ($stu_team) {
                $q->where('team_id',$stu_team);
            })->get(['id','student_id','team_id','role','position'])->toArray();
            $team_member_length = count($team_member);

            return view('student_frontend.GroupList',compact('team_name','team_member_length','team_member','stu_role','stu_team'));

        }
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
        $team_name = Team::where('id',$id)->value('name');
        $team_id = Team::where('id',$id)->value('id');
//        $student = Student::whereHas('team',function ($q) use ($id) {
//            $q->where('team_id',$id);
//        })->get(['id','name','student_id','role','position'])->toArray();
//        $student_length = count($student);

        $team_member = TeamMember::with(array('student'=>function($query){
            $query->select('id','name','student_id');
        }))->with(array('team'=>function($query){
            $query->select('id','name');
        }))->whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','student_id','team_id','role','position'])->toArray();
        $student_length = count($team_member);

        return view('student_frontend.GroupListEdit',compact('team_name','team_id','student_length','team_member'));
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
        $leader = 0;
        $member = 0;
        foreach($_POST['hidden_id'] as $hiddenId){
            $role = $request->input('role'.$hiddenId);
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
                // 完成條件 更新資料
                foreach($_POST['hidden_id'] as $hiddenId){
                    $role = $request->input('role'.$hiddenId);
                    $position = $request->input('position'.$hiddenId);
                    $team_name = $request->input('name');

                    $team = Team::find($id);
                    $team -> name = $team_name;
                    $team -> save();

//                    $student = Student::find($hiddenId);
//                    $student -> role = $role;
//                    $student -> position = $position;
//                    $student -> save();
                    $team_member = TeamMember::find($hiddenId);
                    $team_member -> role = $role;
                    $team_member -> position = $position;
                    $team_member -> save();
                }
                return redirect('StuGroupList');
            }
        }else{
            // 未選擇組長
            return back()->with('repeat','請選擇組長');
        }
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
