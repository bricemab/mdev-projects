<?php

    namespace App\Models;

    use App\BillingEnum;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Task extends Model
    {
        use HasFactory;

        public $timestamps = false;
        protected $table = "tasks";
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            "name",
            "description",
            "hours",
            "progress_hours",
            "is_finished",
            "project_id",
            'created_at',
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

        public function project() {
            return $this->belongsTo(Project::class, "project_id", "id");
        }
        public function reports() {
            return $this->hasMany(Report::class, "task_id", "id");
        }
    }
