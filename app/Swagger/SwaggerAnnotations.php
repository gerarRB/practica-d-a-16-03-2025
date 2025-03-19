<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Swagger Application",
 *     version="1.0.0",
 *     description="API documentation for My Application",
 *     @OA\Contact(
 *         email="administrator@innovacion.gob.sv"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your JWT token in the format Bearer {token}"
 * )
 */
class SwaggerAnnotations
{
    // This class is used solely to hold the @OA\Info annotation
}
