<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Report;
use App\Models\Team;
use Illuminate\Http\Request;
use ZipArchive;

class ReportListController extends Controller
{
    public function index(){
        $meeting = Meeting::all(['id','name','upload_date','upload_time'])->toArray();
        $meeting_id = Meeting::all('id')->toArray();
        $meeting_length = count($meeting);
        $report_list = array();
        foreach ($meeting_id as $id){
            $report = Report::where('meeting_id',$id)->count();
            array_push($report_list,$report);
        }
        return view('teacher_frontend.ReportList',compact('meeting_length','meeting','report_list'));
    }

    public function show($id){
        $meeting_id = $id;
        $report = Report::where('meeting_id',$id)->get()->toArray();
        $report_id = Report::all('team_id')->toArray();
        $report_length = count($report);
        $team_list = array();
        foreach ($report_id as $id){
            $team = Team::where('id',$id)->get('name')->toArray();
            array_push($team_list,$team);
        }
        return view('teacher_frontend.ReportListShow',compact('meeting_id','report_length','report','team_list'));
    }

    public function download($id){
        $report = Report::where('id',$id)->value('file_name');
        $file = public_path().'/storage/'.$report;
        return  response()->download($file);
    }

    public function downloadALL($id){
        $report = Report::where('meeting_id',$id)->get('file_name')->toArray();
        $report_length = count($report);
        $zip_file = 'ALLReport.zip';
        $zip = new ZipArchive();
        $zip->open(public_path().'/'.$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($report==null){
            return back()->with('warning','沒有檔案可以下載。');
        }else{
            for ($i = 0; $i < $report_length; $i++){
                $zip->addFile(public_path('/storage/'.$report[$i]['file_name']), $report[$i]['file_name']);
            }
            $zip->close();
            return response()->download($zip_file);
        }




    }
}
