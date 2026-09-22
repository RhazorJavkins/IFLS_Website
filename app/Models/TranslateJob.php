<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslateJob extends Model
{
    public const STATUSES = [
        'incoming' => 'Masuk',
        'in_progress' => 'Dikerjakan',
        'review' => 'Review',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    public const SERVICES = [
        'document' => 'Dokumen',
        'sworn' => 'Tersumpah',
        'interpretation' => 'Interpreting',
    ];

    public const LANGUAGES = [
        'id' => 'Indonesia',
        'en' => 'Inggris',
        'zh' => 'Mandarin',
    ];

    protected $fillable = [
        'title', 'client_name', 'client_phone', 'source_lang', 'target_lang',
        'service', 'deadline', 'status', 'assigned_to', 'price', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
