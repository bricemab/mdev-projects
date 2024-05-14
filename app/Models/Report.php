<?php

    namespace App\Models;

    use App\BillingEnum;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Report extends Model
    {
        use HasFactory;

        public $timestamps = false;
        protected $table = "reports";

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'description',
            "time",
            "user_id",
            "task_id",
            "project_id",
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [];

        /**
         * Get the attributes that should be cast.
         *
         * @return array<string, string>
         */
        protected function casts(): array
        {
            return [
                'created_at' => 'datetime',
            ];
        }

        public function user() {
            return $this->belongsTo(User::class, "user_id", "id");
        }
        public function task() {
            return $this->belongsTo(Task::class, "task_id", "id");
        }
        public function project() {
            return $this->belongsTo(Project::class, "project_id", "id");
        }
    }
