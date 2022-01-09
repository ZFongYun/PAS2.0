<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingTeam;
use App\Models\Student;
use App\Models\TeacherScoringStudent;
use App\Models\TeacherScoringTeam;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meeting = Meeting::all()->toArray();
        return view('teacher_frontend.meeting',compact('meeting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $team = Team::all()->toArray();
        return view('teacher_frontend.meetingCreate',compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $year = $request->input('year');
        $semester = $request->input('semester');
        $meeting_date = $request->input('meeting_date');
        $meeting_start = $request->input('meeting_start');
        $meeting_end = $request->input('meeting_end');
        $content = $request->input('content');
        $upload_date = $request->input('upload_date');
        $upload_time = $request->input('upload_time');
        $team = $request->input('teamId');

        $meeting = new Meeting;
        $meeting -> name = $name;
        $meeting -> year = $year;
        $meeting -> semester = $semester;
        $meeting -> meeting_date = $meeting_date;
        $meeting -> meeting_start = $meeting_start;
        $meeting -> meeting_end = $meeting_end;
        $meeting -> content = $content;
        $meeting -> upload_date = $upload_date;
        $meeting -> upload_time = $upload_time;
        $meeting -> save();

        $cut_id = explode(",",$team);
        $meeting_id = Meeting::where('name',$name)->value('id');

        if ($cut_id != null){
            foreach ($cut_id as $row)
            {
                $meeting_team = new MeetingTeam;
                $meeting_team -> meeting_id = $meeting_id;
                $meeting_team -> team_id = $row;
                $meeting_team -> calc_status = 0;
                $meeting_team -> save();
            }
        }
        return redirect('APS_teacher/meeting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting = Meeting::find($id) -> toArray();
        $meeting_team = DB::table('meeting_team')
            ->where('meeting_id',$id)->whereNull('meeting_team.deleted_at')
            ->join('meeting','meeting_team.meeting_id','=','meeting.id')
            ->join('team','meeting_team.team_id','=','team.id')
            ->select('team.name')
            ->get()->toArray();
        return view('teacher_frontend.meetingShow',compact('meeting','meeting_team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meeting = Meeting::find($id) -> toArray();
        $team = Team::all()->toArray();
        $meeting_team = MeetingTeam::where('meeting_id',$id)->get('team_id');
        return view('teacher_frontend.meetingEdit',compact('meeting','team','meeting_team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        $year = $request->input('year');
        $semester = $request->input('semester');
        $meeting_date = $request->input('meeting_date');
        $meeting_start = $request->input('meeting_start');
        $meeting_end = $request->input('meeting_end');
        $content = $request->input('content');
        $upload_date = $request->input('upload_date');
        $upload_time = $request->input('upload_time');
        $team = $request->input('teamId');

        $meeting = Meeting::where('id','=',$id)->first();
        $meeting -> name = $name;
        $meeting -> year = $year;
        $meeting -> semester = $semester;
        $meeting -> meeting_date = $meeting_date;
        $meeting -> meeting_start = $meeting_start;
        $meeting -> meeting_end = $meeting_end;
        $meeting -> content = $content;
        $meeting -> upload_date = $upload_date;
        $meeting -> upload_time = $upload_time;
        $meeting -> save();

        $teamToDelete = MeetingTeam::where('meeting_id',$id)->delete(); //把舊有的報告組別刪除

        $cut_id = explode(",",$team);
        if ($cut_id != null){
            foreach ($cut_id as $row)
            {
                $meeting_team = new MeetingTeam;
                $meeting_team -> meeting_id = $id;
                $meeting_team -> team_id = $row;
                $meeting_team -> calc_status = 0;
                $meeting_team -> save();
            }
        }
        return redirect('APS_teacher/meeting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting_team = MeetingTeam::where('meeting_id',$id)->delete();

        $meeting = Meeting::find($id);
        $meeting -> delete();

        return redirect('APS_teacher/meeting');
    }
}
