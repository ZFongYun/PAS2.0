<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\StudentScoringTeam;
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
            $student_score = StudentScoringTeam::where('meeting_id',$id)->where('object_team_id',$team_id)->sum('point');  //學生評分組別的分數加總
            $teacher = $teacher_score*$TS;
            $student = ($student_score / $student_count)*$PA;
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
        $meeting = Meeting::find($id)->first();
        $meeting->is_End = 1;
        $meeting->save();
        return '結算成功';
    }
}
