<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $casts = [
        'payload' => 'array'
    ];

    protected $fillable = [
        'uuid',
        'status',
        'payload'
    ];

    public static function findByUuid(string $uuid): Document
    {
        return Document::where('uuid', '=', $uuid)->firstOrFail();
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

}
