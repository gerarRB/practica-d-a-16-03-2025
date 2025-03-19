<?php

namespace App\Swagger\Annotations;
use OpenApi\Attributes as OA;

class AuthDocSwagger {
    #[OA\Post(
        path: '/api/auth/login',
        tags: ['Auth'],
        summary: "Iniciar sesion",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email','password'],
                properties: [
                    new OA\Property(
                        type: 'String',
                        property: 'email',
                        example: "administrador@innovacion.gob.sv"
                    ),
                    new OA\Property(
                        type: 'String',
                        property: 'password',
                        example: 'Admin123$',
                    )
                   
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: '201',
                description: 'Se inicio sesión',
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
    public function login() {}

    #[OA\Post(
        path: '/api/auth/logout',
        tags: ['Auth'],
        summary: "Cerrar sesión",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
       
        responses: [
            new OA\Response(
                response: '201',
                description: 'Sesion cerrada',
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
    public function logout() {}
    
}