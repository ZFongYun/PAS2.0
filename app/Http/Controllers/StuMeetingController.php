<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function report($id)
    {
        $upload_team = auth('student')->user()->team_id;
        $report = Report::where('meeting_id',$id)->where('team_id',$upload_team)->get()->toArray();

        $meeting = Meeting::find($id) -> toArray();
        return view('student_frontend.meetingReport',compact('meeting','report'));
    }

    public function upload(Request $request,$id)
    {
        $validator = validator($request->all(),
            ['file' => 'required|mimes:pptx,rar,zip|max:100000'],
            [
                'file.required'=>'請選擇檔案',
                'file.mimes'=>'上傳格式為pptx、zip、rar',
                'file.max'=>'上傳檔案大小過大',
            ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $upload_team = auth('student')->user()->team_id;
        $file = $request->file('file');
        if($request->file('file')){

            $name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public',$name);
            $report = new Report;
            $report->meeting_id = $id;
            $report->team_id = $upload_team;
            $report->file_name = $name;
            $report->save();
            return back()->with('success','上傳成功！');
        }
    }

    public function report_edit(Request $request,$id){
        $validator = validator($request->all(),
            ['file' => 'required|mimes:pptx,rar,zip|max:100000'],
            [
                'file.required'=>'請選擇檔案',
                'file.mimes'=>'上傳格式為pptx、zip、rar',
                'file.max'=>'上傳檔案大小過大',
            ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $file = $request->file('file');
        if($request->file('file')){
            $upload_team = auth('student')->user()->team_id;
            $report = Report::where('meeting_id',$id)->where('team_id',$upload_team)->first();
            File::delete(public_path().'/storage/'.$report['file_name']);
            dd(public_path().''.$report['file_name']);
            $name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public',$name);
            $report->file_name = $name;
            $report->save();
            return back()->with('success','上傳成功！');
        }
    }
}
