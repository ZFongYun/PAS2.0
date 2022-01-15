<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingReport;
use App\Models\Report;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class ReportListController extends Controller
{
    public function index(){
        $meeting = Meeting::all(['id','name','upload_date','upload_time'])->toArray();
        $meeting_id = Meeting::all('id')->toArray();
        $meeting_length = count($meeting);
        $report_list = array();
        foreach ($meeting_id as $id){
            $report = MeetingReport::where('meeting_id',$id)->count();
            array_push($report_list,$report);
        }
        return view('teacher_frontend.ReportList',compact('meeting_length','meeting','report_list'));
    }

    public function show($id){
        $meeting_id = $id;
        $report = DB::table('meeting_report')
            ->join('team','meeting_report.team_id','=','team.id')
            ->where('meeting_id',$id)
            ->where('team.deleted_at',null)
            ->where('meeting_report.deleted_at',null)
            ->select('meeting_report.*','team.name')
            ->get()->toArray();
        return view('teacher_frontend.ReportListShow',compact('meeting_id','report'));

    }

    public function download($id){
        $report = MeetingReport::where('id',$id)->value('file_name');
        $file = public_path().'/storage/'.$report;
        return  response()->download($file);
    }

    public function downloadALL($id){
        $report = MeetingReport::where('meeting_id',$id)->get('file_name')->toArray();
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
