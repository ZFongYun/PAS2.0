<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Student;
use App\Models\StudentScoringTeam;
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
        $arr = array();
        $arr_name = array();

        $meeting_date = Meeting::where('id',$meeting_id)->value('meeting_date');
        $team_score = TeamScore::where('team_id',$team_id)->where('meeting_id',$meeting_id)->get()->toArray();
        $team_name = Team::where('id',$team_score[0]['team_id'])->value('name');
        $teacher_feedback = TeacherScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->get()->toArray();
        $student_feedback = StudentScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->get()->toArray();
        for ($i = 0; $i < count($student_feedback); $i++){
            $stu_name = Student::where('id',$student_feedback[$i]['raters_student_id'])->get('name');
            array_push($arr_name,$stu_name);
        }
        $student_feedback_length = count($student_feedback);
        array_push($arr,$meeting_date,$team_name,$team_score,$teacher_feedback,$student_feedback,$student_feedback_length,$arr_name);
        return $arr;
    }
}
