<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'document_uuid',
    ];

    public static function findByDocumentUuid(string $document_uuid)
    {
        return Document::where('document_uuid', '=', $document_uuid)->firstOrFail();
    }

    public function mail() {
        return $this->hasOne(Mail::class);
    }

}
