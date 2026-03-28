<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'location',
        'services',
        'message',
        'ip_address',
    ];

    protected $casts = [
        'services' => 'array',
    ];
}
