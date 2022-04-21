<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'document' => [
                'id' => $this->document_uuid,
                'status' => $this->when($this->is_published == true, 'published', 'draft'),
                'payload' => [
                    'from' => $this->whenNotNull($this->from),
                    'subject' => $this->whenNotNull($this->subject),
                    'message' => $this->whenNotNull($this->message),
                ],
                'createAt' => $this->created_at,
                'modifyAt' => $this->updated_at,
                ],


        ];
    }
}