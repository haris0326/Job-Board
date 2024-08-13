<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    // The 'id' field is not needed in $fillable
    protected $fillable = [
        'keyword',
    ];
}
