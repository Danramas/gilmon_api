<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class DocumentController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return DocumentResource::collection(Document::paginate());
    }

    public function store(): DocumentResource
    {
        return new DocumentResource(Document::create(['uuid' => Uuid::uuid4()]));
    }

    public function show(string $uuid): DocumentResource
    {
        return new DocumentResource(Document::findByUuid($uuid));
    }

    public function update(DocumentUpdateRequest $request, $uuid): Response|DocumentResource
    {
        $document = Document::findByUuid($uuid);

        if (!$document->isPublished()) {
            if ($request->filled('payload')) {
                $document->update($request->validated());
                return new DocumentResource($document);
            } else {
                return new Response([
                    'error' => 'You dont send payload data'
                ], 400);
            }
        } else {
            return new Response([
                'error' => 'This document is already published and cannot be changed'
            ], 400);
        }
    }

    public function publish($uuid): DocumentResource
    {
        $document = Document::findByUuid($uuid);

        $document->update(['status' => 'published']);

        return new DocumentResource($document);
    }
}
