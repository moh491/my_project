<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyJob extends Model
{
    use HasFactory;
     protected $fillable=[
         'title',
         'position_id',
         'location_type',
         'employment_type',
         'level',
         'description',
         'requirements',
         'responsibilities',
         'min_salary',
         'max_salary',
         'company_id'
     ];

    protected $guarded=[];

    public function freelancers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Freelancer::class,'applications');
    }
    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }

}
