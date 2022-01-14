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

        //小組成員
        $team_member = DB::Table('team_member')
            ->join('student','team_member.student_id','student.id')
            ->whereNull('team_member.deleted_at')
            ->whereNull('student.deleted_at')
            ->where('team_member.team_id',$user_team[0]->team_id)
            ->select('team_member.*','student.name')
            ->get()->toArray();

        $stu_score_arr = array();
        for ($i = 0; $i < count($team_member); $i++) {
            $stu_score = DB::Table('student_score')
                ->join('student', 'student_score.student_id', '=', 'student.id')
                ->where('student_score.student_id', $team_member[$i]->student_id)
                ->where('student_score.meeting_id', $meeting[0]->meeting_id)
                ->select('student_score.*', 'student.name')
                ->get()->toArray();  //組員成績
            array_push($stu_score_arr, $stu_score);
        }

//        $tmp = 0;
//        $stu_score_arr = array();
//        for ($i=0; $i < count($stu_score_tmp); $i++){
//            if ($stu_score_tmp[$i][0]->total < $tmp){
//                array_push($stu_score_arr,$stu_score_tmp[$i][0]);
//
//            }else{
//                $tmp = $stu_score_tmp[$i][0]->total;
//
//            }
//        }
        $user_team_name = $user_team[0]->name;
        $score_record_date = date('Y/m/d', strtotime($meeting[0]->updated_at));

//        dd($stu_score_arr);

        return view('student_frontend.index',compact('bulletin','user_team_name','score_record_date','stu_score_arr'));
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
