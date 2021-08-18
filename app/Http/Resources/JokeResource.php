<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JokeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'          => $this->type,
            'setup'         => $this->setup,
            'punchline'     => $this->punchline
        ];
    }
}
