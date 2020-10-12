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

    public function grades_page($id){
        $meeting = Meeting::find($id) -> toArray();
        $report_team = $meeting['report_team'];
        $report_team_arr = explode(' ',$report_team);
        return view('teacher_frontend.grades',compact('meeting','report_team','report_team_arr'));
    }

    public function search(Request $request){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $team = $request->input('team');
            if ($team == '請選擇'){
                $arr = ['null'];
                echo json_encode($arr);
            }else{
                $meeting_id = $request->input('meeting_id');
                $team_id = Team::withTrashed()->where('name',$team)->value('id');
                $all_data_arr = array();  //全部資料
                $stu_score_arr = array();  //組員成績
                $teacher_stu_feedback_arr = array();  //老師評分組員回饋
                $stu_peer_feedback_arr = array();  //學生評分組員回饋

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
                        ->where('student_score.student_id',$stu_team[$i]['student_id'])->where('meeting_id',12)
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
                array_push($all_data_arr,$team_score,$teacher_team_feedback,$student_team_feedback,$stu_score_arr,$teacher_stu_feedback_arr,$stu_peer_feedback_arr);

                return $all_data_arr;
            }
        }

    }
}
