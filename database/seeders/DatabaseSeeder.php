<?php

    namespace Database\Seeders;

    use App\Models\Company;
    use App\Models\File;
    use App\Models\Project;
    use App\Models\Report;
    use App\Models\Task;
    use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use App\RoleEnum;
    use Database\Factories\TaskFactory;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;
    use \Illuminate\Support\Str;

    class DatabaseSeeder extends Seeder
    {
        /**
         * Seed the application's database.
         */
        public function run(): void
        {
            $company = Company::factory()->create([
                "name" => "MDevelopment",
            ]);
            $file = File::factory()->create([
                "name" => "Logo MDEV",
                "unique_name" => "1qay2wsx3edc",
                'path' => "files/companies/",
                'extension' => "png",
                'size' => 132,
                "company_id" => $company->id
            ]);
            $company->file_id = $file->id;
            $company->save();
            $file = File::factory()->create([
                "name" => "Fichier de test",
                "unique_name" => Str::random(12),
                'path' => "files/projects/",
                'extension' => "pdf",
                'size' => 132,
            ]);
            $project = Project::factory()->create([
                'name' => "Développement du système de gestion de projets",
                "url_prod" => "https://mdevelopment.ch/",
                "url_preprod" => "https://preprod.mdevelopment.ch/",
                "price" => 500*65,
                "hours" => 500,
                "rate" => 65,
                "file_id" => $file->id,
                "start_date" => "2024-03-01",
                "end_date" => "2024-12-31",
                "company_id" => $company->id,
            ]);
            User::factory()->create([
                "email" => "bricemabi@gmail.com",
                "password" => Hash::make("admin"),
                "lastname" => "Mabillard",
                "firstname" => "Brice",
                "company_id" => $company->id,
                "role" => RoleEnum::ROLE_ADMIN->value
            ]);
            Task::factory(10)->create();
            Report::factory(10)->create();
            $reports = [];
            $timeProject = "00:00";
            foreach (Task::all() as $task) {
                $timeProject = \UtilsHelper::sumTimeStrings($task->hours, $timeProject);
            }
            $project->hours = \UtilsHelper::convertHoursMinutesToDecimal($timeProject);
            $project->save();
            foreach (Report::all() as $report) {
                if (!array_key_exists($report->task_id, $reports)) {
                    $reports[$report->task_id] = "00:00";
                }
                $reports[$report->task_id] = \UtilsHelper::sumTimeStrings($report->time, $reports[$report->task_id]);
            }
            foreach ($reports as $key => $value) {
                $task = Task::find($key);
                $task->progress_hours = $value;
                $task->save();
            }
            File::factory()->create([
                "name" => "Logo Campo SA",
                "unique_name" => "45Gz80F3wm",
                'path' => "files/companies/",
                'extension' => "jpeg",
                'size' => 132,
            ]);
        }
    }
