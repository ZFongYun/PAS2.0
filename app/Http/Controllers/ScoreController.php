<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingTeam;
use App\Models\Student;
use App\Models\StudentScore;
use App\Models\StudentScoringMember;
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
    public function grades_page($id){
        $meeting = Meeting::find($id) -> toArray();
        $meeting_team = DB::table('meeting_team')
            ->where('meeting_id',$id)->whereNull('meeting_team.deleted_at')
            ->join('meeting','meeting_team.meeting_id','=','meeting.id')
            ->join('team','meeting_team.team_id','=','team.id')
            ->select('team.id','team.name')
            ->get()->toArray();
        return view('teacher_frontend.grades',compact('meeting','meeting_team'));
    }

    public function search(Request $request){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $team = $request->input('team');
            if ($team == '請選擇'){
                $arr = ['null'];
                echo json_encode($arr);
            }else{
                $meeting_id = $request->input('meeting_id');
                $team_id = $team;

                $is_calc = MeetingTeam::where('meeting_id',$meeting_id)->where('team_id',$team_id)->get('calc_status')->toArray();

                if ($is_calc[0]['calc_status'] == 0){
                    $arr = ['未結算'];
                    echo json_encode($arr);

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
                    array_push($all_data_arr,$stu_score_arr,$stu_member_feedback_arr,$stu_peer_feedback_arr);

                    return json_encode($all_data_arr);
                }
            }
        }
    }

    public function score(Request $request){
        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $team_id = $request->input('team');
            $meeting_id = $request->input('meeting_id');

            $team_member = DB::Table('team_member')
                ->join('student','team_member.student_id','student.id')
                ->where('team_member.team_id',$team_id)
                ->where('team_member.deleted_at',null)
                ->select('team_member.*','student.name')
                ->get()->toArray();

            for ($j = 0; $j < count($team_member); $j++){
                //同儕評分
                $peer_count = StudentScoringPeer::where('meeting_id',$meeting_id)->where('peer_id',$team_member[$j]->student_id)->count();
                if ($peer_count == 0){
                    $EV = 0 ;
                }else{
                    $peer_score = StudentScoringPeer::where('meeting_id',$meeting_id)->where('peer_id',$team_member[$j]->student_id)->sum('EV');
                    $EV = ceil($peer_score / $peer_count);
                }

                //組員評分
                $member_count = StudentScoringMember::where('meeting_id',$meeting_id)->where('member_id',$team_member[$j]->student_id)->count();
                if ($member_count == 0){
                    $CV = 0 ;
                }else{
                    $member_score = StudentScoringMember::where('meeting_id',$meeting_id)->where('member_id',$team_member[$j]->student_id)->sum('CV');
                    $CV = ceil($member_score / $member_count);
                }

                $total = ceil($CV * $EV);
                $stu_score = new StudentScore;
                $stu_score->student_id = $team_member[$j]->student_id;
                $stu_score->meeting_id = $meeting_id;
                $stu_score->CV = $CV;
                $stu_score->EV = $EV;
                $stu_score->total = $total;
                $stu_score->save();

                $team = MeetingTeam::where('meeting_id',$meeting_id)->where('team_id',$team_id)->first();
                $team->calc_status = '1';
                $team->save();
            }
            return '結算成功';
        }
    }
}
