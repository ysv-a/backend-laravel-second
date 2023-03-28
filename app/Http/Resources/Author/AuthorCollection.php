<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorCollection extends ResourceCollection
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

    // public function with($request)
    // {
    //     $count = Book::count();
    //     return [
    //         'meta' => [
    //             'totalCount' => $count
    //         ]
    //     ];
    // }
}
