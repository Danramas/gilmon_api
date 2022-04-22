<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UuidStringGeneratorHelper;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;

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
        return new DocumentResource(Document::create(['document_uuid' => UuidStringGeneratorHelper::generateUuidString()]));
    }

    public function show(string $document_uuid)
    {
        return new DocumentResource(Document::findByDocumentUuid($document_uuid));
    }

    public function update(DocumentUpdateRequest $request, $document_uuid)
    {
        $document = Document::findByDocumentUuid($document_uuid);

        if($document['is_published'] == false) {
            $document->update($request->validated());

            return new DocumentResource($document);
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
