<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Housewife v1 OpenApi Documentation",
     *      description="Housewife v1 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="admin@housewife.io"
     *      )
     * )
     *
     * @OA\Server(
     *     description="Housewife API Server",
     *     url="{host}"
     * )
     * @OA\Get(
     *     path="/",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
