<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = "billings";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'date',
        'recurrence',
        'company_id',
        'project_id',
        'file_id',
        'create_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'create_at' => 'datetime',
        ];
    }

    public function company() {
        return $this->belongsTo(Company::class, "company_id", "id");
    }

    public function project() {
        return $this->belongsTo(Project::class, "project_id", "id");
    }

    public function file() {
        return $this->belongsTo(File::class, "file_id", "id");
    }
}
