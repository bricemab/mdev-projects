<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function changeCompany(ChangeCompanyRequest $request) {
        $company = Company::findOrFail($request->get("company"));
        $request->session()->put("company", $company);
        return redirect()->back();
    }
}
