<?php

namespace App\Http\Controllers\OpenApi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;

class FileController extends Controller
{
    #[OA\Post(
        path: '/upload',
        summary: "upload image",
        tags: ['file'],
    )]
    #[OA\RequestBody(
        description: "Upload images request body",
        required: true,
        content: [
            new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(
                            property: "file",
                            type: "string",
                            format: "binary"
                        ),
                    ],
                    type: "object",
                )
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "file_url",
                    description: "Url file",
                    type: "string",
                    default: 'http://localhost/images/examples.jpg'
                ),
            ],
            type: 'object'
        )
    )]
    public function upload(Request $request): string
    {
        $this->validate($request, [
            'file' => 'required|file|image',
        ]);

        $file = $request->file('file');

        $timestamp = now()->format('Y-m-d-H-i-s');
//        getClientOriginalName -  оригинальное имя
//        getClientOriginalExtension -  расширение
        $filename = "{$timestamp}-{$file->getClientOriginalName()}";

        Storage::disk('public')->putFileAs("uploads", $file, $filename);

        return Storage::disk('public')->url("uploads/{$filename}");
    }
}
