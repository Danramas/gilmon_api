<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'document' => [
                'id' => $this->uuid,
                'status' => $this->status,
                'payload' => $this->payload,
                'createAt' => $this->created_at,
                'modifyAt' => $this->updated_at,
            ],
        ];
    }
}
