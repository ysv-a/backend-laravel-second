<?php

namespace App\Http\Controllers\OpenApi;

/**
 * @OA\Info(title="My API", version="1")


 * @OA\Server(
 *     url="http://127.0.0.1:8000/open-api",
 *     description="API server"
 * )
 *
 */

class HomeController
{
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Info"},
     *     @OA\Response(
     *         response="200",
     *         description="API version",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="name", type="string")
     *         ),
     *     )
     * )
     */
    public function home()
    {
        return [
            'name' => 'Test API',
        ];
    }
}
