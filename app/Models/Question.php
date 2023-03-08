<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'question',
        'answers',
        'have_other_option',
        'other_option_name',
        'order',
        'is_required',
        'options',
    ];

    protected $casts = [
        'answers' => 'array',
        'options' => 'array',
    ];
}
