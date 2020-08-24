<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Team;
use Illuminate\Http\Request;

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
        $content = $request->input('content');
        $meeting_date = $request->input('meeting_date');
        $meeting_start = $request->input('meeting_start');
        $meeting_end = $request->input('meeting_end');
        $upload_date = $request->input('upload_date');
        $upload_time = $request->input('upload_time');
        $team = $request->input('team');
        $TS = $request->input('TS');
        $PA = $request->input('PA');
        $team_limit = $request->input('team_limit');
        $team_bonus = $request->input('team_bonus');
        $member_limit = $request->input('member_limit');
        $member_bonus = $request->input('member_bonus');

        $team_length = count($team);
        $team_chk = "";
        for($i=0; $i<$team_length; $i++){
            $team_chk = $team[$i].','.$team_chk;
        }

        $meeting = new Meeting;
        $meeting -> name = $name;
        $meeting -> meeting_date = $meeting_date;
        $meeting -> meeting_start = $meeting_start;
        $meeting -> meeting_end = $meeting_end;
        $meeting -> content = $content;
        $meeting -> upload_date = $upload_date;
        $meeting -> upload_time = $upload_time;
        $meeting -> report_team = $team_chk;
        $meeting -> PA = $PA;
        $meeting -> TS = $TS;
        $meeting -> team_limit = $team_limit;
        $meeting -> team_bonus = $team_bonus;
        $meeting -> member_limit = $member_limit;
        $meeting -> member_bonus = $member_bonus;
        $meeting -> save();

        return view('teacher_frontend.meeting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = Meeting::find($id);
        $meeting -> delete();
        return redirect('meeting');
    }
}
