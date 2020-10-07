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

class ScoreController extends Controller
{
    public function scoring(Request $request){
        $id = $request->input('id');
        $meeting = Meeting::find($id)->toArray();
        $PA = $meeting['PA']*0.01;
        $TS = $meeting['TS']*0.01;
        $report_team = $meeting['report_team'];
        $report_team_arr = explode(' ',$report_team);
        for ($i = 1; $i < count($report_team_arr); $i++){
            $team_id = Team::where('name',$report_team_arr[$i])->value('id');
            $teacher_score = TeacherScoringTeam::where('meeting_id',$id)->where('object_team_id',$team_id)->value('point');  //教師評分組別的分數
            $student_count = StudentScoringTeam::where('meeting_id',$id)->where('object_team_id',$team_id)->count();  //學生評分組別的次數
            $teacher = $teacher_score*$TS;
            if ($student_count == 0){
                $student = 0;
            }else{
                $student_score = StudentScoringTeam::where('meeting_id',$id)->where('object_team_id',$team_id)->sum('point');  //學生評分組別的分數加總
                $student = ($student_score / $student_count)*$PA;
            }
            $total = $teacher+$student;
            $team_score = new TeamScore;
            $team_score->team_id = $team_id;
            $team_score->meeting_id = $id;
            $team_score->score = $total;
            $team_score->bonus = 0;
            $team_score->total = 0;
            $team_score->count = 0;
            $team_score->save();
        }

        for ($i = 1; $i < count($report_team_arr); $i++){
            $team_id = Team::where('name',$report_team_arr[$i])->value('id');
            $student = Student::where('team_id',$team_id)->get('id')->toArray();
            for ($j = 0; $j < count($student); $j++){
                $teacher_score_stu = TeacherScoringStudent::where('meeting_id',$id)->where('object_student_id',$student[$j])->value('point');
                $peer_count = StudentScoringPeer::where('meeting_id',$id)->where('object_student_id',$student[$j])->count();
                $teacher_peer = $teacher_score_stu*$TS;
                if ($peer_count == 0){
                    $student_peer = 0 ;
                }else{
                    $peer_score = StudentScoringPeer::where('meeting_id',$id)->where('object_student_id',$student[$j])->sum('point');
                    $student_peer = ($peer_score / $peer_count)*$PA;
                }
                $total_peer = $teacher_peer+$student_peer;
                $stu_score = new StudentScore;
                $stu_score->student_id = $student[$j]['id'];
                $stu_score->meeting_id = $id;
                $stu_score->score = $total_peer;
                $stu_score->bonus = 0;
                $stu_score->total = 0;
                $stu_score->count = 0;
                $stu_score->save();
            }
        }
        $meeting = Meeting::where('id','=',$id)->first();
        $meeting->is_End = 1;
        $meeting->save();
        return '結算成功';

    }
}
