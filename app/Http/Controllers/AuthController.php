<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Models\Company;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\table;

class AuthController extends Controller
{
    public function login() {
        return view("pages.no-layout.login");
    }

    public function loginAction(EmailRequest $request) {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('company', \auth()->user()->company);
            $companies = [];
            foreach (Company::orderBy("name")->get() as $company) {
                $companies[$company->id] = $company;
            }
            $request->session()->put('companies', $companies);
            return redirect()->intended(route("projects.index"));
        }

        return to_route("auth.login")->withErrors([
            "email" => __("login.errors.email"),
            "password" => __("login.errors.password"),
        ])->onlyInput(["email", "password"]);
    }

    public function logoutAction(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route("auth.login");
    }
}
