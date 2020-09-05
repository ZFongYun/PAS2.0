<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class StuMeetingController extends Controller
{
    public function index()
    {
        $meeting = Meeting::all()->toArray();
        return view('student_frontend.meeting',compact('meeting'));
    }

    public function show($id)
    {
        $meeting = Meeting::find($id) -> toArray();
        return view('student_frontend.meetingShow',compact('meeting'));
    }
}
