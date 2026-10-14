<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    public const SOURCE_FORM = 'form';

    public const SOURCE_QUEUE_BACKLOG = 'queue_backlog';

    public const VIA_INDIVIDUAL = 'individual';

    public const VIA_BACKLOG_SUMMARY = 'backlog_summary';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'ip',
        'user_agent',
        'source',
        'emailed_at',
        'emailed_via',
    ];

    protected function casts(): array
    {
        return [
            'emailed_at' => 'datetime',
        ];
    }

    /**
     * Submissions that have not been emailed yet.
     */
    public function scopeUnsent(Builder $query): void
    {
        $query->whereNull('emailed_at');
    }
}
