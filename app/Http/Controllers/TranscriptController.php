<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingTeam;
use App\Models\Student;
use App\Models\StudentScore;
use App\Models\StudentScoringPeer;
use App\Models\StudentScoringTeam;
use App\Models\TeacherScoringStudent;
use App\Models\TeacherScoringTeam;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamScore;
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
            echo 'test';
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

            array_push($all_data_arr,$stu_score_arr,$stu_member_feedback_arr,$stu_peer_feedback_arr,$meeting_date);

            return json_encode($all_data_arr);
        }
    }

    public function StuTranscript_index(){
        $meeting = Meeting::all()->toArray();
        return view('student_frontend.Transcript',compact('meeting'));
    }

    public function StuTranscript_search(Request $request){
        $meeting_id = $request->input('meeting');
        $choose = $request->input('choose');
        $all_data_arr = array();  //全部資料
        $meeting_date = Meeting::where('id',$meeting_id)->value('meeting_date');  //會議日期

        if ($choose == 0){
            $title = '小組得分結果';
            $stu_team_id = auth('student')->user()->team_id;
            $team_score = TeamScore::where('team_id',$stu_team_id)->where('meeting_id',$meeting_id)->get()->toArray();  //組別成績
            $teacher_team_feedback = TeacherScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$stu_team_id)->get(['point','feedback'])->toArray();  //老師評分組別回饋
            $stu_peer_feedback = StudentScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$stu_team_id)->get(['point','feedback'])->toArray();  //學生評分同儕回饋

            array_push($all_data_arr,$meeting_date,$team_score,$teacher_team_feedback,$stu_peer_feedback,$title);
            return $all_data_arr;

        }else{
            $title = '個人得分結果';
            $stu_id = auth('student')->user()->id;
            $stu_score = StudentScore::where('student_id',$stu_id)->where('meeting_id',$meeting_id)->get()->toArray();  //組別成績
            $teacher_stu_feedback = TeacherScoringStudent::where('meeting_id',$meeting_id)->where('object_student_id',$stu_id)->get()->toArray();  //老師評分組員回饋
            $stu_peer_feedback = StudentScoringPeer::where('meeting_id',$meeting_id)->where('object_student_id',$stu_id)->get()->toArray();  //老師評分組員回饋

            array_push($all_data_arr,$meeting_date,$stu_score,$teacher_stu_feedback,$stu_peer_feedback,$title);
            return $all_data_arr;
        }
    }
}
