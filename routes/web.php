<?php

    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Route;
    use \App\Http\Controllers\AuthController;
    use \App\Http\Controllers\ProjectController;
    use \Illuminate\Auth\Middleware\Authenticate;
    use \App\Http\Controllers\BillingController;
    use \App\Http\Controllers\FileController;
    use \App\Http\Controllers\ApplicationController;

    Route::get('/', function () {
        return view('layouts.mdev');
    })->name("mdev");
    Route::get("login", [AuthController::class, "login"])->name("auth.login");
    Route::post("login", [AuthController::class, "loginAction"])->name("auth.login");
    Route::get("logout", [AuthController::class, "logoutAction"])->name("auth.logout");

    Route::prefix("/application")->name("application.")->controller(ApplicationController::class)->group(function () {
        Route::post("/change-company", "changeCompany")->name("change-company");
    });

    Route::prefix("/files")->name("files.")->controller(FileController::class)->group(function () {
        Route::get('{file:unique_name}', "show")->name("show");
        Route::get('/download/{file:unique_name}', "download")->name("download");
    });

    Route::prefix("/projects")->name("projects.")->controller(ProjectController::class)->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("/add", "add")->name("add");
        Route::post("/add", "addAction")->name("add-action");
        Route::get("/detail/{project}", "detail")->name("detail");
    });

    Route::prefix("/billings")->name("billings.")->controller(BillingController::class)->group(function () {
        Route::get("/", "index")->name("index");
    });

    Route::get("/lang/{locale}", function (string $locale) {
        if (!in_array($locale, ['en', 'fr'])) {
            abort(400);
        }
        App::setLocale($locale);
    });
