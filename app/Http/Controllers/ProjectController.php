<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        return view("pages.layout.projects.detail", ["project" => $project]);
    }
}
