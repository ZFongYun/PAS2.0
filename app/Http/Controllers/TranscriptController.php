<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
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
        $meeting = Meeting::all()->toArray();
        $team = Team::all()->toArray();
        return view('teacher_frontend.Transcript',compact('meeting','team'));
    }

    public function search(Request $request){
        $meeting_id = $request->input('meeting');
        $team_id = $request->input('team');
        $all_data_arr = array();  //全部資料
        $stu_score_arr = array();  //組員成績
        $teacher_stu_feedback_arr = array();  //老師評分組員回饋
        $stu_peer_feedback_arr = array();  //學生評分組員回饋

        $meeting_date = Meeting::where('id',$meeting_id)->value('meeting_date');  //會議日期
        $team_score = DB::table('team_score')
            ->join('team','team_score.team_id','=','team.id')
            ->where('team_id',$team_id)->where('meeting_id',$meeting_id)
            ->select('team_score.*','team.name')
            ->get();  //組別成績

        $teacher_team_feedback = TeacherScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->get(['point','feedback'])->toArray();  //老師評分組別回饋
        $student_team_feedback = DB::Table('student_scoring_team')
            ->join('student','student_scoring_team.raters_student_id','=','student.id')
            ->where('meeting_id',$meeting_id)->where('object_team_id',$team_id)
            ->select('student_scoring_team.*','student.name')
            ->get();  //學生評分組別回饋

        $stu_team = TeamMember::withTrashed()->where('team_id',$team_id)->get()->toArray();
        for ($i = 0; $i < count($stu_team); $i++){
            $stu_score = DB::Table('student_score')
                ->join('student','student_score.student_id','=','student.id')
                ->where('student_score.student_id',$stu_team[$i]['student_id'])->where('meeting_id',$meeting_id)
                ->select('student_score.*','student.name','student.student_ID')
                ->get();  //組員成績
            array_push($stu_score_arr,$stu_score);

            $teacher_stu_feedback = TeacherScoringStudent::where('meeting_id',$meeting_id)->where('object_student_id',$stu_team[$i]['id'])->get()->toArray();  //老師評分組員回饋
            array_push($teacher_stu_feedback_arr,$teacher_stu_feedback);

            $stu_peer_feedback = DB::Table('student_scoring_peer')
                ->join('student','student_scoring_peer.raters_student_id','=','student.id')
                ->where('meeting_id',$meeting_id)->where('object_student_id',$stu_team[$i]['id'])
                ->select('student_scoring_peer.*','student.name')
                ->get();  //學生評分同儕回饋
            array_push($stu_peer_feedback_arr,$stu_peer_feedback);
        }
        array_push($all_data_arr,$meeting_date,$team_score,$teacher_team_feedback,$student_team_feedback,$stu_score_arr,$teacher_stu_feedback_arr,$stu_peer_feedback_arr);

        return $all_data_arr;
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

    public function searchTeam(Request $request){
        $meeting_id = $request->input('meeting');
        $meeting = Meeting::find($meeting_id)->toArray();
        $team = $meeting['report_team'];
        $team_arr = explode(" ",$team);
        $report_team_show = array();
        for ($i = 1; $i < count($team_arr); $i++){
            $team_name = Team::withTrashed()->where('id',$team_arr[$i])->get()->toArray();
            array_push($report_team_show, $team_name);
        }
        return $report_team_show;
    }
}
