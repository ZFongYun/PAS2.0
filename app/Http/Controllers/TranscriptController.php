<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingTeam;
use App\Models\Student;
use App\Models\StudentScore;
use App\Models\StudentScoringMember;
use App\Models\StudentScoringPeer;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranscriptController extends Controller
{
    public function index(){
        return view('teacher_frontend.Transcript');
    }

    public function searchYear(Request $request){
        $year_arr = explode("-",$request->input('year'));
        $team = Team::where('year',$year_arr[0])->where('semester',$year_arr[1])->get()->toArray();
        return $team;
    }

    public function searchTeam(Request $request){
        $team = $request->input('team');
        $meeting_team = DB::table('meeting_team')
            ->where('team_id',$team)
            ->whereNull('meeting_team.deleted_at')
            ->join('meeting','meeting_team.meeting_id','=','meeting.id')
            ->select('meeting_team.*','meeting.name')
            ->get()->toArray();
        return $meeting_team;
    }

    public function search(Request $request){
        $meeting_id = $request->input('meeting');
        $team_id = $request->input('team');

        if ($meeting_id == '0'){
            $all_data_arr = array();  //全部資料
            $stu_score_arr = array();  //組員成績

            $team_member = DB::Table('team_member')
                ->join('student','team_member.student_id','student.id')
                ->where('team_member.team_id',$team_id)
                ->where('team_member.deleted_at',null)
                ->select('team_member.*','student.name')
                ->get();

            for ($i = 0; $i < count($team_member); $i++) {
                $stu_score = DB::Table('student_score')
                    ->join('student', 'student_score.student_id', '=', 'student.id')
                    ->where('student_score.student_id', $team_member[$i]->student_id)
                    ->sum('student_score.total');  //組員成績
                array_push($stu_score_arr, $stu_score);
            }

            $date_max = MeetingTeam::where('calc_status','=','1')->orderBy('updated_at', 'desc')->first('updated_at');
            $date_min = MeetingTeam::where('calc_status','=','1')->orderBy('updated_at', 'asc')->first('updated_at');

            $date_max = date('Y/m/d', strtotime($date_max['updated_at']));
            $date_min = date('Y/m/d', strtotime($date_min['updated_at']));

            array_push($all_data_arr,$stu_score_arr,$team_member,$date_max,$date_min,0);

            return $all_data_arr;

        }else{
            $all_data_arr = array();  //全部資料
            $stu_score_arr = array();  //組員成績
            $stu_peer_feedback_arr = array();  //同儕回饋
            $stu_member_feedback_arr = array();  //組員回饋

            $team_member = DB::Table('team_member')
                ->join('student','team_member.student_id','student.id')
                ->where('team_member.team_id',$team_id)
                ->where('team_member.deleted_at',null)
                ->select('team_member.*','student.name')
                ->get();

            for ($i = 0; $i < count($team_member); $i++){
                $stu_score = DB::Table('student_score')
                    ->join('student','student_score.student_id','=','student.id')
                    ->where('student_score.student_id',$team_member[$i]->student_id)
                    ->where('student_score.meeting_id',$meeting_id)
                    ->select('student_score.*','student.name','student.student_ID')
                    ->get();  //組員成績
                array_push($stu_score_arr,$stu_score);

                $stu_peer_feedback = DB::Table('studnet_scoring_peer')
                    ->join('student','studnet_scoring_peer.student_id','=','student.id')
                    ->where('studnet_scoring_peer.peer_id',$team_member[$i]->student_id)
                    ->where('studnet_scoring_peer.meeting_id',$meeting_id)
                    ->select('studnet_scoring_peer.*','student.name')
                    ->get();  //學生評分同儕回饋
                array_push($stu_peer_feedback_arr,$stu_peer_feedback);

                $stu_member_feedback = DB::Table('studnet_scoring_member')
                    ->join('student','studnet_scoring_member.student_id','=','student.id')
                    ->where('studnet_scoring_member.member_id',$team_member[$i]->student_id)
                    ->where('studnet_scoring_member.meeting_id',$meeting_id)
                    ->select('studnet_scoring_member.*','student.name')
                    ->get();  //學生評分同儕回饋
                array_push($stu_member_feedback_arr,$stu_member_feedback);
            }
            $meeting_date = Meeting::where('id',$meeting_id)->value('meeting_date');  //會議日期

            array_push($all_data_arr,$stu_score_arr,$stu_member_feedback_arr,$stu_peer_feedback_arr,$meeting_date,1);

            return json_encode($all_data_arr);
        }
    }

    public function StuTranscript_index(){
        return view('student_frontend.Transcript');
    }

    public function searchYearStu(Request $request){
        $year_arr = explode("-",$request->input('year'));

        $user_id = auth('student')->user()->id;

        // 尋找使用者加入的組別
        $user_team = DB::Table('team_member')
            ->join('team','team_member.team_id','team.id')
            ->where('team_member.student_id',$user_id)
            ->where('team.year',$year_arr[0])
            ->where('team.semester',$year_arr[1])
            ->where('team_member.deleted_at',null)
            ->select('team_member.*','team.name')
            ->get()->toArray();

        return $user_team;
    }

    public function StuTranscript_search(Request $request){
        $meeting_id = $request->input('meeting');
        $team_id = $request->input('team');
        $stu_id = auth('student')->user()->id;

        if ($meeting_id == '0'){
            $all_data_arr = array();  //全部資料
            $stu_score_arr = array();  //組員成績

            $team_member = DB::Table('team_member')
                ->join('student','team_member.student_id','student.id')
                ->where('team_member.team_id',$team_id)
                ->where('team_member.deleted_at',null)
                ->select('team_member.*','student.name')
                ->get();

            for ($i = 0; $i < count($team_member); $i++) {
                $stu_score = DB::Table('student_score')
                    ->join('student', 'student_score.student_id', '=', 'student.id')
                    ->where('student_score.student_id', $team_member[$i]->student_id)
                    ->sum('student_score.total');  //組員成績
                array_push($stu_score_arr, $stu_score);
            }

            $date_max = MeetingTeam::where('calc_status','=','1')->orderBy('updated_at', 'desc')->first('updated_at');
            $date_min = MeetingTeam::where('calc_status','=','1')->orderBy('updated_at', 'asc')->first('updated_at');

            $date_max = date('Y/m/d', strtotime($date_max['updated_at']));
            $date_min = date('Y/m/d', strtotime($date_min['updated_at']));

            array_push($all_data_arr,$stu_score_arr,$team_member,$date_max,$date_min,0);

            return $all_data_arr;

        }else{
            $all_data_arr = array();  //全部資料

            // 使用者分數
            $stu_score = DB::Table('student_score')
                ->join('student','student_score.student_id','=','student.id')
                ->where('student_score.student_id',$stu_id)
                ->where('student_score.meeting_id',$meeting_id)
                ->select('student_score.*','student.name','student.student_ID')
                ->get()->toArray();  //組員成績

            //同儕回饋
            $stu_peer_feedback = DB::Table('studnet_scoring_peer')
                ->join('student','studnet_scoring_peer.student_id','=','student.id')
                ->where('studnet_scoring_peer.peer_id',$stu_id)
                ->where('studnet_scoring_peer.meeting_id',$meeting_id)
                ->select('studnet_scoring_peer.*')
                ->get()->toArray();

            //組員回饋
            $stu_member_feedback = DB::Table('studnet_scoring_member')
                ->join('student','studnet_scoring_member.student_id','=','student.id')
                ->where('studnet_scoring_member.member_id',$stu_id)
                ->where('studnet_scoring_member.meeting_id',$meeting_id)
                ->select('studnet_scoring_member.*')
                ->get()->toArray();

            $meeting_date = Meeting::where('id',$meeting_id)->value('meeting_date');  //會議日期

            array_push($all_data_arr,$stu_score,$stu_peer_feedback,$stu_member_feedback,$meeting_date,1);

            return $all_data_arr;
        }
    }
}
