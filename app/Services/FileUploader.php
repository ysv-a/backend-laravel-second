<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\Factory;

class FileUploader
{
    const BASE_FOLDER = 'storage';
    const FOLDER_NAME = 'uploads';

    public function __construct(
        public readonly Factory $storage,
        private readonly FileDecode $decode,
        public readonly string $disk = 'public'
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $timestamp = now()->format('Y-m-d-H-i-s');
        $filename = "{$timestamp}-{$file->getClientOriginalName()}";

        $this->storage->disk($this->disk)->putFileAs(self::FOLDER_NAME, $file, $filename);

        return self::FOLDER_NAME . '/' . $filename;
    }

    public function uploadBase64(string $base64): string
    {
        $rawData = $this->decode->imageDecode($base64);

        $filename = sha1(time()) . '.' . $rawData['type'];

        $this->storage->disk($this->disk)->put(self::FOLDER_NAME . '/' . $filename, $rawData['raw']);

        return self::FOLDER_NAME . '/' . $filename;
    }

    public function remove(string $path): void
    {
        $this->storage->disk($this->disk)->delete($path);
    }
}
