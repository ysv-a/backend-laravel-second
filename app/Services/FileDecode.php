<?php

namespace App\Services;

class FileDecode
{
    public function imageDecode(string $base64Image)
    {
        preg_match('/^data:image\/(\w+);base64,/', $base64Image, $rawtype);

        $type = $rawtype[1];
        if (empty($type)) {
            throw new \Exception("Did not match data URI with image data");
        }

        $data = substr($base64Image, strpos($base64Image, ',') + 1);

        if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
            throw new \Exception("Invalid Image Type");
        }

        $data = base64_decode($data);

        if ($data === false) {
            throw new \Exception("base64_decode Failed");
        }

        return ['raw' => $data, 'type' => $type];
    }
}
