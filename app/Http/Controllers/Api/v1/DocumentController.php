<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UuidStringGeneratorHelper;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentController extends Controller
{

    public function index()
    {
        return DocumentResource::collection(Document::paginate());
    }

    public function store(Request $request)
    {
        $create_document = Document::create(['document_uuid' => UuidStringGeneratorHelper::generateUuidString()]);
        Mail::create(['document_id' => $create_document['id']]);

        return new DocumentResource($create_document);
    }

    public function show(string $document_uuid)
    {
        return new DocumentResource(Document::findByDocumentUuid($document_uuid));
    }

    public function update(DocumentUpdateRequest $request, $document_uuid)
    {
        $document = Document::findByDocumentUuid($document_uuid);
        $mail = Mail::where('document_id', '=', $document['id'])->firstOrFail();

        if($document['is_published'] == false) {
//            if($request['payload']) {
                $mail->update($request->validated());

                return new DocumentResource($document);
//            }
//            else {
//                return new Response([
//                    'error' => 'You dont send payload data'
//                ], 400);
//            }
        }
        else {
            return new Response([
                'error' => 'This document is already published and cannot be changed'
            ], 400);
        }

    }

    public function publish($document_uuid)
    {
        $document = Document::findByDocumentUuid($document_uuid);

        $document['is_published'] = true;

        $document->update($document->toArray());

        return new DocumentResource($document);
    }
}
