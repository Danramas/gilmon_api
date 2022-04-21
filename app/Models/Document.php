<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'document_uuid',
        'from',
        'subject',
        'message',
    ];

    public static function findByDocumentUuid(string $document_uuid)
    {
        return Document::where('document_uuid', '=', $document_uuid)->firstOrFail();
    }


}
