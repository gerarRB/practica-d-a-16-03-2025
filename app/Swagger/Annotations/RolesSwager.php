<?php

namespace App\Swagger\Annotations;
use OpenApi\Attributes as OA;

class RolesSwager {
    #[OA\Post(
        path: '/api/users/role',
        tags: ['Roles'],
        summary: "Crea nuevos roles",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['role', 'permissions'],
                properties: [
                    new OA\Property(
                        type: 'String',
                        property: 'role',
                        example: "Role name"
                    ),
                    new OA\Property(
                        type: 'Array',
                        property: 'permissions',
                        example: ['permiso1', 'permiso2']
                    ),
                   
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: '201',
                description: 'Permisos creados con éxito',
            ),
            new OA\Response(
                response: '400',
                description: 'Datos inválidos o petición incorrecta',
            ),
            new OA\Response(
                response: '401',
                description: 'No autorizado, se requiere token',
            ),
            new OA\Response(
                response: '500',
                description: 'Error interno del servidor',
            )
        ]
    )]
    public function createRole() {}
}