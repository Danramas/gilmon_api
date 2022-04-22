<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'from' => $this->whenNotNull($this->from),
            'subject' => $this-> whenNotNull($this->subject),
            'message' => $this-> whenNotNull($this->message),
        ];
    }
}
