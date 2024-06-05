<?php

namespace App\Http\Controllers;

use App\FilePathEnum;
use App\Models\Company;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\ProjectStateEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request) {
        $projects = Project::whereHas("company", function ($q) use ($request) {
           $q->where("company_id", $request->session()->get("company")->id);

        })->orderBy("start_date")->orderBy("name")
            ->get();
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
            'url_prod' => 'nullable|url',
            'url_preprod' => 'nullable|url',
            'github' => 'nullable|url',
            'rate' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'cdc_file' => 'nullable',
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
        [
            "name" => $name,
            "url_prod" => $urlProd,
            "url_preprod" => $urlPreprod,
            "github" => $github,
            "rate" => $rate,
            "start_date" => $startDate,
            "end_date" => $endDate,
            "tasks" => $tasks,
        ] = $request->post();
        $companyId = $request->session()->get("company")->id;
        $project = new Project();
        $project->name = $name;
        $project->url_prod = $urlProd;
        $project->url_preprod = $urlPreprod;
        $project->github = $github;
        $project->rate = $rate;
        $project->price = 0;
        $project->hours = 0;
        $project->start_date = $startDate;
        $project->end_date = $endDate;
        $project->state = ProjectStateEnum::VALIDATED->value;
        $project->company_id = $companyId;
        $project->save();
        if ($request->file("cdc_file") !== null) {
            $fileUpload = $request->file("cdc_file");
            $extArray = explode(".", $fileUpload->getClientOriginalName());
            $ext = sizeof($extArray) - 1 >= 0 ? $extArray[sizeof($extArray) - 1] : "";
            $file = new File();
            $file->name = $fileUpload->getClientOriginalName();
            $file->unique_name = Str::random(12);
            $file->path = FilePathEnum::PROJECT_PATH->value;
            $file->extension = $ext;
            $file->size = $fileUpload->getSize();
            $file->company_id = $companyId;
            $file->save();
            $filename = $file->path.$file->unique_name;
            $path = "public/app/" . $filename;
            Storage::putFile($path, $fileUpload);
            $project->file_id = $file->id;
        }
        $totalHours = "00:00";
        foreach ($tasks as $taskObject) {
            $task = new Task();
            $task->name = $taskObject["name"];
            $task->description = $taskObject["description"];
            $task->hours = $taskObject["hours"];
            $task->progress_hours = "00:00";
            $task->is_finished = false;
            $task->project_id = $project->id;
            $task->save();
            $totalHours = \UtilsHelper::sumTimeStrings($totalHours, $task["hours"]);
        }
        $project->hours = \UtilsHelper::timeToDecimal($totalHours);
        $project->price = $rate * \UtilsHelper::timeToDecimal($totalHours);
        $project->save();
        return response()->json([
            'success' => true,
        ]);
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
