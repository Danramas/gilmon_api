<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table = 'mails';

    protected $fillable = [
        'document_id',
        'from',
        'subject',
        'message',
    ];

    public function document() {
        return $this->belongsTo(Document::class);
    }
}
