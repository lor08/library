<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'year' => $this->year,
            'authors' => $this->authors->implode('name', ', '),
            'image' => "https://covers.openlibrary.org/b/isbn/" . $this->isbn . ".jpg",
            'created_at' => (string) $this->created_at,
        ];
    }
}
