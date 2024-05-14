<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Notifications\Notifiable;

    class File extends Model
    {
        use HasFactory, Notifiable;

        public $timestamps = false;
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'name',
            'unique_name',
            'path',
            'extension',
            'size',
            'company_id',
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
        public function company() {
            return $this->belongsTo(Company::class, "company_id", "id");
        }
    }
