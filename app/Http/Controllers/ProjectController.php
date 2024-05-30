<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request) {
        $projects = Project::whereHas("company", function ($q) use ($request) {
           $q->where("company_id", $request->session()->get("company")->id);
        })->get();
        return view("pages.layout.projects.index", ["projects" => $projects]);
    }

    public function add() {
        return view("pages.layout.projects.add");
    }
    public function detail(Project $project) {
        $data = [];

        return view("pages.layout.projects.detail", ["project" => $project, "data" => ($data)]);
    }
    public function addAction(Request $request) {
        $rules = [
            'name' => 'required|string|max:255',
            'url_prod' => 'url',
            'url_preprod' => 'url',
            'github' => 'url',
            'rate' => 'required|numeric',
            'cdc_file' => 'nullable|file|mimes:pdf|max:2048',
            'tasks' => 'array',
            'tasks.*.name' => 'string|max:255',
            'tasks.*.description' => 'string',
            'tasks.*.hours' => 'string|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

    }
//    public function detail(Project $project) {
//        $data = [
//            'labels' => [],
//            'datasets' => [
//                [
//                    'data' => [],
//                    'backgroundColor' => \UtilsHelper::$darkThemeColors,
//                ]
//            ],
//        ];
//        $totalTime = "00:00";
//        $totalTimeValue = 0;
//        $projectTimeExplode = explode(":", \UtilsHelper::convertDecimalToHoursMinutes($project->hours));
//        $projectValue = (int)$projectTimeExplode[0] * 60 + (int)$projectTimeExplode[1];
//        foreach ($project->tasks as $task) {
//            $time = explode(":", $task->progress_hours);
//            $timeNeeded = explode(":", $task->hours);
//            $timeValue = (int)$time[0] * 60 + (int)$time[1];
//            $timeNeededValue = (int)$timeNeeded[0] * 60 + (int)$timeNeeded[1];
//            $reportTask["time"] = $task->progress_hours;
//            $reportTask["value"] = $timeNeededValue - $timeValue;
//
//            $data["datasets"][0]["data"][] = $timeValue;
//            $label = $task->name ." \n";
//            $label .= __("projects.detail.remained").": " . \UtilsHelper::subtractTime($task->hours, $task->progress_hours) . "\n";
//            $label .= __("projects.detail.performed").": ". $task->progress_hours . "\n";
//            $label .= __("projects.detail.total").": ". $task->hours;
//            $data["labels"][] = $label;
//            $totalTime = \UtilsHelper::sumTimeStrings($totalTime, $task->progress_hours);
//            $totalTimeValue += $timeValue;
//        }
//        $data["datasets"][0]["data"][] = $projectValue - $totalTimeValue;
//        $data["labels"][] = __("projects.detail.hours-remained") ." \n ". \UtilsHelper::subtractTime(\UtilsHelper::convertDecimalToHoursMinutes($project->hours), $totalTime) . " / " . $project->hours;
//        return view("pages.layout.projects.detail", ["project" => $project, "data" => ($data)]);
//    }
}
