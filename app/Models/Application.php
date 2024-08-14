<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\Jobs\Job;

class Application extends Model
{

    protected $fillable=[
        'status',
        'job_id',
        'freelancer_id',
        'budget',
        'experience_year',
        'file',
    ];

    use HasFactory;

    public function job()
    {
        return $this->belongsTo(CompanyJob::class, 'job_id');
    }

    // Define the relationship with the Freelancer model
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
