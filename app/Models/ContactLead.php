<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'program',
        'subject',
        'message',
        'locale',
        'contacted_at',
    ];

    protected function casts(): array
    {
        return [
            'contacted_at' => 'datetime',
        ];
    }
}
