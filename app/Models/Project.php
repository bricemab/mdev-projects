<?php

namespace App\Models;

use App\BillingEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "projects";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        "url_prod",
        "url_preprod",
        "price",
        "rate",
        "file_id",
        "company_id",
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

    public function resolveRouteBinding($value, $field = null)
    {
        if (!session()->get('company')) {
            return redirect()->route("auth.login");
        }
        $companyId = session()->get('company')->id;
        return $this->where($field ?? 'id', $value)
            ->where('company_id', $companyId)
            ->first() ?? abort(404);
    }

    public function company() {
        return $this->belongsTo(Company::class, "company_id", "id");
    }
    public function file() {
        return $this->belongsTo(File::class, "file_id", "id");
    }
    public function billings() {
        return $this->hasMany(Billing::class, "project_id", "id");
    }
    public function reports() {
        return $this->hasMany(Report::class, "project_id", "id");
    }
    public function tasks() {
        return $this->hasMany(Task::class, "project_id", "id");
    }
}
