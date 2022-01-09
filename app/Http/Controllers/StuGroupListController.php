<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StuGroupListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //找出使用者的id
        $studentId = auth('student')->user()->id;

        //判斷學生是否有在小組裡，並判斷組別的狀態
        $stu_team = DB::Table('team_member')
            ->join('team','team_member.team_id','team.id')
            ->where('team_member.student_id',$studentId)
            ->where('team.status',0)
            ->where('team_member.deleted_at',null)
            ->select('team_member.*','team.name','team.status','team.content')
            ->get()->toArray();

        if ($stu_team == null){
            $warning = '未加入組別';
            return view('student_frontend.GroupList',compact('warning'));
        }else{
            $team_id = $stu_team[0]->team_id;
            $team_member = TeamMember::with(array('student'=>function($query){
                $query->select('id','name','student_id');
            }))->with(array('team'=>function($query){
                $query->select('id','name');
            }))->whereHas('team',function ($q) use ($team_id) {
                $q->where('team_id',$team_id);
            })->get(['id','student_id','team_id','role','position'])->toArray();
            $team_member_length = count($team_member);

            return view('student_frontend.GroupList',compact('stu_team','team_member_length','team_member'));
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
        $team = Team::where('id',$id)->get()->toArray();

        $team_member = TeamMember::with(array('student'=>function($query){
            $query->select('id','name','student_id');
        }))->with(array('team'=>function($query){
            $query->select('id','name');
        }))->whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','student_id','team_id','role','position'])->toArray();
        $student_length = count($team_member);

        return view('student_frontend.GroupListEdit',compact('team','id','student_length','team_member'));
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
                $content = $request->input('content');

                $team = Team::find($id);
                $team -> name = $team_name;
                $team -> content = $content;
                $team -> save();

                foreach($_POST['hidden_id'] as $hiddenId){
                    $role = $request->input('role'.$hiddenId);
                    $position = $request->input('position'.$hiddenId);

                    $team_member = TeamMember::find($hiddenId);
                    $team_member -> role = $role;
                    $team_member -> position = $position;
                    $team_member -> save();
                }
                return redirect('APS_student/StuGroupList');
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
