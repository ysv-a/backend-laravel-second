<?php

namespace App\Http\Resources\Book;

use App\Models\Book;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }

    public function with($request)
    {
        $count = Book::count();
        return [
            'meta' => [
                'totalCount' => $count
            ]
        ];
    }
}
