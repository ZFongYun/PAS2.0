<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StuIndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulletin = Bulletin::all()->toArray();
        $user_id = auth('student')->user()->id;

        // 尋找使用者的目前組別
        $user_team = DB::Table('team_member')
            ->join('team','team_member.team_id','team.id')
            ->whereNull('team_member.deleted_at')
            ->whereNull('team.deleted_at')
            ->where('team_member.student_id',$user_id)
            ->where('team.status',0)
            ->select('team_member.team_id','team.name')
            ->get()->toArray();

        if ($user_team == null){
            $message = '未加入組別';
            return view('student_frontend.index',compact('bulletin','message'));

        }else{
            // 符合最晚完成結算+使用者目前組別的會議
            $meeting = DB::table('meeting_team')
                ->join('meeting','meeting_team.meeting_id','=','meeting.id')
                ->join('team','meeting_team.team_id','=','team.id')
                ->whereNull('meeting_team.deleted_at')
                ->whereNull('meeting.deleted_at')
                ->whereNull('team.deleted_at')
                ->where('team.id',$user_team[0]->team_id)
                ->where('meeting_team.calc_status','1')
                ->orderBy('meeting_team.updated_at', 'desc')
                ->select('meeting_team.team_id','meeting_team.meeting_id','meeting_team.updated_at')
                ->get()->toArray();

            if ($meeting == null){
                $message = '未有分數紀錄';
                return view('student_frontend.index',compact('bulletin','message'));

            }else if(count($meeting) == 1){
                // 只有一個紀錄

                //小組成員
                $team_member = DB::Table('team_member')
                    ->join('student','team_member.student_id','student.id')
                    ->whereNull('team_member.deleted_at')
                    ->whereNull('student.deleted_at')
                    ->where('team_member.team_id',$user_team[0]->team_id)
                    ->select('team_member.student_id','student.name')
                    ->get()->toArray();

                $team_member_id = array();
                for ($i = 0; $i < count($team_member); $i++) {
                    array_push($team_member_id, $team_member[$i]->student_id);
                }
                $stu_score = DB::Table('student_score')
                    ->join('student', 'student_score.student_id', '=', 'student.id')
                    ->whereIn('student_score.student_id', $team_member_id)
                    ->where('student_score.meeting_id', $meeting[0]->meeting_id)
                    ->orderBy('student_score.total', 'desc')
                    ->select('student_score.*', 'student.name')
                    ->get()->toArray();

                $arr = null;
                $stu_score_nd = null;

                $user_team_name = $user_team[0]->name;
                $score_record_date = date('Y/m/d', strtotime($meeting[0]->updated_at));

                return view('student_frontend.index',compact('bulletin','user_team_name','score_record_date','stu_score','arr','stu_score_nd'));

            }else{
                // 有兩筆紀錄可以比較

                //小組成員
                $team_member = DB::Table('team_member')
                    ->join('student','team_member.student_id','student.id')
                    ->whereNull('team_member.deleted_at')
                    ->whereNull('student.deleted_at')
                    ->where('team_member.team_id',$user_team[0]->team_id)
                    ->select('team_member.student_id','student.name')
                    ->get()->toArray();

                $team_member_id = array();
                for ($i = 0; $i < count($team_member); $i++) {
                    array_push($team_member_id, $team_member[$i]->student_id);
                }
                $stu_score = DB::Table('student_score')
                    ->join('student', 'student_score.student_id', '=', 'student.id')
                    ->whereIn('student_score.student_id', $team_member_id)
                    ->where('student_score.meeting_id', $meeting[0]->meeting_id)
                    ->orderBy('student_score.total', 'desc')
                    ->select('student_score.*', 'student.name')
                    ->get()->toArray();

                $arr = array();
                $stu_score_st = DB::Table('student_score')
                    ->join('student', 'student_score.student_id', '=', 'student.id')
                    ->where('student_score.meeting_id', $meeting[0]->meeting_id)
                    ->where('student_score.student_id', $user_id)
                    ->select('student_score.total', 'student.name')
                    ->get()->toArray();

                $stu_score_nd = DB::Table('student_score')
                    ->join('student', 'student_score.student_id', '=', 'student.id')
                    ->where('student_score.meeting_id', $meeting[1]->meeting_id)
                    ->where('student_score.student_id', $user_id)
                    ->select('student_score.total', 'student.name')
                    ->get()->toArray();

                if ($stu_score_st != null && $stu_score_nd != null){
                    if ($stu_score_st[0]->total > $stu_score_nd[0]->total){
                        //進步
                        $diff = $stu_score_st[0]->total - $stu_score_nd[0]->total;
                        array_push($arr,0,$diff);
                    }else if ($stu_score_st[0]->total < $stu_score_nd[0]->total){
                        //退步
                        $diff = $stu_score_nd[0]->total - $stu_score_st[0]->total;
                        array_push($arr,1,$diff);
                    }else{
                        //維持
                        array_push($arr,2,0);
                    }
                }

                $user_team_name = $user_team[0]->name;
                $score_record_date = date('Y/m/d', strtotime($meeting[0]->updated_at));
                return view('student_frontend.index',compact('bulletin','user_team_name','score_record_date','stu_score','arr','stu_score_nd'));
            }
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
