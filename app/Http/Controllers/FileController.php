<?php

    namespace App\Http\Controllers;

    use App\Models\File;
    use App\RoleEnum;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function show(File $file)
    {
//        auth()->user()->role !== RoleEnum::ROLE_ADMIN->value
        if (auth()->user()->company_id !== $file->company->id) {
            abort(401);
        }
        $filename = $file->path.$file->unique_name;
        $path = "public/app/" . $filename;
        if (!Storage::exists($path)) {
            abort(401);
        }
        $content = Storage::get($path);
        $type = Storage::mimeType($path);
        return Response::make($content, 200)->header("Content-Type", $type);
    }
}
