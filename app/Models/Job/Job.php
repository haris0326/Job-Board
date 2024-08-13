<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'id',
        'job_title', 
        'job_region',
        'category',
        'company',
        'gender',
        'job_type',
        'vacancy',
        'experience',
        'salary', 
        'application_deadline',
        'jobdescription',
        'responsibilities',
        'education_experience',
        'otherbenifits',
        'image',

    ];

    public $timestamp = true;
}
