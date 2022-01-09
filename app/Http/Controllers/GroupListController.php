<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $teamName = Team::all('name','year','semester')->toArray();
        $teamId = Team::all('id')->toArray();

        $team_length = count($teamId);

        $arr_leader = array();
        $arr_member = array();
        $arr_team = array($teamName);
        $arr_id = array($teamId);

        foreach ($teamId as $id){
            $team_member = TeamMember::with(array('student'=>function($query){
                $query->select('id','name');
            }))->whereHas('team',function ($q) use ($id) {
                $q->where('team_id',$id);
            })->get(['student_id','role'])->toArray();
            $student_length = count($team_member);
            $leader = "";
            $member = "";
            for ($i = 0; $i < $student_length; $i++){
                if ($team_member[$i]['role'] == 0){
                    $leader = $leader." ".$team_member[$i]['student']['name'];
                }else if($team_member[$i]['role'] == 1){
                    $member = $member." ".$team_member[$i]['student']['name'];
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
        if(isset($_POST['student'])){
            $leader = 0;
            $member = 0;

            //計算組長和組員的人數
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
                    $team_name = $request->input('name');
                    $year = $request->input('year');
                    $semester = $request->input('semester');
                    $content = $request->input('content');
                    $status = $request->input('status');

                    $team = new Team;
                    $team -> name = $team_name;
                    $team -> year = $year;
                    $team -> semester = $semester;
                    $team -> content = $content;
                    $team -> status = $status;
                    $team -> save();

                    $team_id = Team::where('name',$team_name)->value('id');

                    foreach($_POST['student'] as $studentId){
                        $role = $request->input('role'.$studentId);
                        $position = $request->input('position'.$studentId);

                        $team_member = new TeamMember;
                        $team_member -> student_id = $studentId;
                        $team_member -> team_id = $team_id;
                        $team_member -> role = $role;
                        $team_member -> position = $position;
                        $team_member -> save();
                    }
                    return redirect('APS_teacher/GroupList');
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
        $team = Team::where('id',$id)->get()->toArray();

        $team_member = TeamMember::with(array('student'=>function($query){
            $query->select('id','name','student_id');
        }))->with(array('team'=>function($query){
            $query->select('id','name');
        }))->whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','student_id','team_id','role','position'])->toArray();
        $team_member_length = count($team_member);

        return view('teacher_frontend.GroupListShow',compact('team','team_member_length','team_member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::where('id',$id)->get()->toArray();

        $team_member = TeamMember::with(array('student'=>function($query){
            $query->select('id','name','student_id');
        }))->with(array('team'=>function($query){
            $query->select('id','name');
        }))->whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','student_id','team_id','role','position'])->toArray();
        $team_member_length = count($team_member);

        return view('teacher_frontend.GroupListEdit',compact('team','id','team_member_length','team_member'));
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

        //計算組長和組員的人數
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
                // 完成條件 更新組別和組員資料
                $team_name = $request->input('name');
                $year = $request->input('year');
                $semester = $request->input('semester');
                $content = $request->input('content');
                $status = $request->input('status');

                $team = Team::find($id);
                $team -> name = $team_name;
                $team -> year = $year;
                $team -> semester = $semester;
                $team -> content = $content;
                $team -> status = $status;
                $team -> save();

                foreach($_POST['hidden_id'] as $hiddenId){
                    $role = $request->input('role'.$hiddenId);
                    $position = $request->input('position'.$hiddenId);

                    $team_member = TeamMember::find($hiddenId);
                    $team_member -> role = $role;
                    $team_member -> position = $position;
                    $team_member -> save();
                }

                return redirect('APS_teacher/GroupList');
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
        $team_member = TeamMember::where('team_id',$id)->delete();

        $team = Team::find($id);
        $team -> delete();

        return redirect('APS_teacher/GroupList');

    }

    public function plus_page($id)
    {
        $team_name = Team::where('id',$id)->value('name');
        $team_member = TeamMember::where('team_id',$id)->get();

        $student_id = array();
        for ($i = 0; $i < count($team_member); $i++){
            array_push($student_id,$team_member[$i]['student_id']);
        }

        //找出未加入該組別的學生
        $student = DB::table('student')
            ->whereNull('deleted_at')
            ->whereNotIn('id', $student_id)
            ->get();

        return view('teacher_frontend.GroupListPlus',compact('id','team_name','student'));
    }

    public function plus(Request $request,$id)
    {
        if(isset($_POST['student'])){
            foreach($_POST['student'] as $studentId){
                $position = $request->input('position'.$studentId);

                $team_member = new TeamMember;
                $team_member -> student_id = $studentId;
                $team_member -> team_id = $id;
                $team_member -> role = '1';
                $team_member -> position = $position;
                $team_member -> save();
            }
            return redirect('APS_teacher/GroupList');
        }else{
            return back()->with('warning','請選擇組員');
        }
    }

    public function destroy_member(Request $request, $id)
    {
        $team_id = $request->input('team_id');
        $team_member = TeamMember::where('student_id',$id)->where('team_id',$team_id)->first();
        $team_member -> delete();
        return back();
    }
}
