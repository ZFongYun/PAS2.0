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
use App\Models\TeamScore;
use Illuminate\Http\Request;

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
        $stu_name_arr = array();  //學生評分組別回饋的姓名
        $stu_score_arr = array();  //組員成績
        $teacher_stu_feedback_arr = array();  //老師評分組員回饋
        $stu_peer_feedback_arr = array();  //學生評分組員回饋
        $peer_name_arr = array();

        $meeting_date = Meeting::where('id',$meeting_id)->value('meeting_date');  //會議日期
        $team_score = TeamScore::where('team_id',$team_id)->where('meeting_id',$meeting_id)->get()->toArray();  //組別成績
        $team_name = Team::where('id',$team_score[0]['team_id'])->value('name');  //組別名稱
        $teacher_team_feedback = TeacherScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->get(['point','feedback'])->toArray();  //老師評分組別回饋
        $student_team_feedback = StudentScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->get()->toArray();  //學生評分組別回饋
        for ($i = 0; $i < count($student_team_feedback); $i++){
            $stu_name = Student::where('id',$student_team_feedback[$i]['raters_student_id'])->get('name');
            array_push($stu_name_arr,$stu_name);
        }

        $stu_team = Student::where('team_id',$team_id)->get()->toArray();
        for ($i = 0; $i < count($stu_team); $i++){
            $stu_score = StudentScore::where('student_id',$stu_team[$i]['id'])->where('meeting_id',$meeting_id)->get()->toArray();
            array_push($stu_score_arr,$stu_score);
            $teacher_stu_feedback = TeacherScoringStudent::where('meeting_id',$meeting_id)->where('object_student_id',$stu_team[$i]['id'])->get()->toArray();  //老師評分組員回饋
            array_push($teacher_stu_feedback_arr,$teacher_stu_feedback);
            $stu_peer_feedback = StudentScoringPeer::where('meeting_id',$meeting_id)->where('object_student_id',$stu_team[$i]['id'])->get()->toArray();  //學生評分組員回饋
            array_push($stu_peer_feedback_arr,$stu_peer_feedback);
            for ($j = 0; $j<count($stu_peer_feedback); $j++){
                $peer_name = Student::where('id',$stu_peer_feedback[$j]['raters_student_id'])->get('name');
                array_push($peer_name_arr,$peer_name);
            }
        }

        array_push($all_data_arr,$meeting_date,$team_name,$team_score,$teacher_team_feedback,$student_team_feedback,$stu_name_arr,$stu_team,$stu_score_arr,$teacher_stu_feedback_arr,$stu_peer_feedback_arr,$peer_name_arr);

        return $all_data_arr;
//        return $stu_peer_feedback_arr;
    }
}
