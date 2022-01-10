<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingReport;
use App\Models\MeetingTeam;
use App\Models\Student;
use App\Models\StudentScoringPeer;
use App\Models\StudentScoringMember;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StuMeetingController extends Controller
{
    public function index()
    {
        $meeting = Meeting::all()->toArray();
        $user_id = auth('student')->user()->id;

        $team = TeamMember::where('student_id',$user_id)->get()->toArray();

        for ($j = 0; $j < count($meeting); $j++){
            for($i = 0; $i < count($team); $i++){
                $meeting_team = MeetingTeam::where('meeting_id',$meeting[$j]['id'])
                    ->where('team_id',$team[$i]['team_id'])->get()->toArray();
                if ($meeting_team == null){
                    array_push($meeting[$j], 'needless');
                }else{
                    $report = MeetingReport::where('meeting_id',$meeting[$j]['id'])
                        ->where('team_id', $team[$i]['team_id'])->get()->toArray();
                    if ($report == null){
                        array_push($meeting[$j], 'not upload');
                    }else{
                        array_push($meeting[$j], 'uploaded');
                    }
                }
            }
        }

        return view('student_frontend.meeting',compact('meeting'));
    }

    public function show($id)
    {
        $meeting = Meeting::find($id) -> toArray();
        $meeting_team = DB::table('meeting_team')
            ->where('meeting_id',$id)->whereNull('meeting_team.deleted_at')
            ->join('meeting','meeting_team.meeting_id','=','meeting.id')
            ->join('team','meeting_team.team_id','=','team.id')
            ->select('team.name')
            ->get()->toArray();
        return view('student_frontend.meetingShow',compact('meeting','meeting_team'));
    }

    public function report($id)
    {
        $meeting = Meeting::find($id)->toArray();

        if (strtotime(date("Y-m-d H:i:s")) < strtotime($meeting['upload_date'].' '.$meeting['upload_time'])){
            $user_id = auth('student')->user()->id;

            // 尋找使用者的目前組別
            $team = DB::Table('team_member')
                ->join('team','team_member.team_id','team.id')
                ->where('team_member.student_id',$user_id)
                ->where('team.status',0)
                ->where('team_member.deleted_at',null)
                ->select('team_member.*','team.*')
                ->get()->toArray();

            $team_id = $team[0]->team_id;

            $report = MeetingReport::where('meeting_id',$id)->where('team_id',$team_id)->get()->toArray();

            return view('student_frontend.meetingReport',compact('meeting','team_id','report'));
        }else{
            echo "<script>alert('已截止繳交報告。')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0.5;url=/APS_student/meeting>';
        }
    }

    public function upload(Request $request,$id)
    {
        $validator = validator($request->all(),
            ['file' => 'required|mimes:pptx,rar,zip|max:100000'],
            [
                'file.required'=>'請選擇檔案',
                'file.mimes'=>'上傳格式錯誤',
                'file.max'=>'上傳檔案大小過大',
            ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $team_id = $request->input('team_id');
        $file = $request->file('file');

        if($request->file('file')){
            $name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public/',$name);
            $report = new MeetingReport();
            $report->meeting_id = $id;
            $report->team_id = $team_id;
            $report->file_name = $name;
            $report->save();
            return back()->with('success','上傳成功！');
        }
    }

    public function report_edit(Request $request,$id){
        $validator = validator($request->all(),
            ['file' => 'required|mimes:pptx,rar,zip,ppt|max:100000'],
            [
                'file.required'=>'請選擇檔案',
                'file.mimes'=>'上傳格式錯誤',
                'file.max'=>'上傳檔案大小過大',
            ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $team_id = $request->input('team_id');
        $file = $request->file('file');

        if($request->file('file')){
            $report = MeetingReport::where('meeting_id',$id)->where('team_id',$team_id)->first();
            File::delete(public_path('storage/'.$report['file_name']));
            $name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public',$name);
            $report->file_name = $name;
            $report->save();
            return back()->with('success','上傳成功！');
        }
    }

    public function download($id){
        $report = MeetingReport::where('id',$id)->value('file_name');
        $file = public_path('storage/'.$report);
        return  response()->download($file);
    }

    public function scoring_page($id){
        $meeting = Meeting::find($id)->toArray();
        if (strtotime(date("Y-m-d H:i:s")) > strtotime($meeting['meeting_date'].' '.$meeting['meeting_start']) && strtotime(date("Y-m-d H:i:s")) < strtotime($meeting['meeting_date'].' '.$meeting['meeting_end'])){
            $report_team = $meeting['report_team'];
            $report_team_arr = explode(' ',$report_team);
            $report_team_show = array();
            for ($i = 1; $i < count($report_team_arr); $i++){
                $team_name = Team::where('id',$report_team_arr[$i])->get()->toArray();
                array_push($report_team_show, $team_name);
            }
            return view('student_frontend.meetingScoring',compact('meeting','report_team_show'));
        }else{
            echo "<script>alert('會議尚未開始。')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0.5;url=/StuMeeting>';
        }

    }

    public function score(Request $request){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $team = $request->input('team');
            if ($team == '請選擇'){
                $arr = ['null'];
                echo json_encode($arr);
            }else{
                $raters_student_id = auth('student')->user()->id;
                $meeting_id = $request->input('meeting_id');
                $team_id = $team;
                $team_name = Team::where('id',$team_id)->value('name');
                $stu_id = DB::Table('team_member')
                    ->join('student','team_member.student_id','student.id')
                    ->where('team_member.team_id',$team_id)
                    ->where('team_member.deleted_at',null)
                    ->select('team_member.*','student.id','student.student_id','student.name')
                    ->get();
                $stu_id_length = count($stu_id);
                $arr = [];

                $scoring_team = StudentScoringTeam::whereHas('meeting',function ($q) use ($meeting_id,$raters_student_id,$team_id){
                    $q->where('meeting_id',$meeting_id)->where('raters_student_id',$raters_student_id)->where('object_team_id',$team_id);
                })->get(['point','feedback'])->toArray();

                if ($scoring_team == null){
                    array_push($arr,$team_name,'0');

                }else{
                    array_push($arr,$team_name,$scoring_team);
                }

                for ($i=0; $i<$stu_id_length; $i++){
                    $scoring_student = StudentScoringPeer::wherehas('meeting',function ($q)use($meeting_id,$stu_id,$i,$raters_student_id){
                        $q->where('meeting_id',$meeting_id)->where('raters_student_id',$raters_student_id)->where('object_student_id',$stu_id[$i]->id);

                    })->get(['point','feedback'])->toArray();
                    if ($scoring_student == null){
                        array_push($arr,$stu_id[$i],'0');
                    }
                    else{
                        array_push($arr,$stu_id[$i],$scoring_student);
                    }
                }
                echo json_encode($arr);
            }
        }
    }

    public function scoring_team(Request $request){
        $meeting_id = $request->input('meeting_id');
        $team_id = $request->input('team');
        $raters_student_id = auth('student')->user()->id;
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $student_scoring_team = new StudentScoringTeam;
        $student_scoring_team->meeting_id = $meeting_id;
        $student_scoring_team->raters_student_id = $raters_student_id;
        $student_scoring_team->object_team_id = $team_id;
        $student_scoring_team->point = $score;
        $student_scoring_team->feedback = $feedback;
        $student_scoring_team->save();

        $arr = ['完成評分'];
        echo json_encode($arr);
    }

    public function edit_team(Request $request){
        $meeting_id = $request->input('meeting_id');
        $team_id = $request->input('team');
        $raters_student_id = auth('student')->user()->id;
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $student_scoring_team = StudentScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->where('raters_student_id',$raters_student_id)->first();
        $student_scoring_team->point = $score;
        $student_scoring_team->feedback = $feedback;
        $student_scoring_team->save();

        $arr = ['完成編輯'];
        echo json_encode($arr);
    }

    public function scoring_stu(Request $request){
        $meeting_id = $request->input('meeting_id');
        $raters_student_id = auth('student')->user()->id;
        $id = $request->input('id');
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $student_scoring_peer = new StudentScoringPeer;
        $student_scoring_peer->meeting_id = $meeting_id;
        $student_scoring_peer->raters_student_id  = $raters_student_id;
        $student_scoring_peer->object_student_id = $id;
        $student_scoring_peer->point = $score;
        $student_scoring_peer->feedback = $feedback;
        $student_scoring_peer->save();

        $arr = ['完成評分'];
        echo json_encode($arr);
    }

    public function edit_stu(Request $request){
        $meeting_id = $request->input('meeting_id');
        $raters_student_id = auth('student')->user()->id;
        $id = $request->input('id');
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $student_scoring_peer = StudentScoringPeer::where('meeting_id',$meeting_id)->where('object_student_id',$id)->where('raters_student_id',$raters_student_id)->first();
        $student_scoring_peer->point = $score;
        $student_scoring_peer->feedback = $feedback;
        $student_scoring_peer->save();

        $arr = ['完成編輯'];

        echo json_encode($arr);
    }
}
