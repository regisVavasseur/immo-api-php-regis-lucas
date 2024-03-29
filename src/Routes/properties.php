<?php

namespace App\Routes;

use src\Controllers\PropertyController;
use src\Middlewares\PaginationMiddleware;
use src\Middlewares\RequestValidations\CreateProperty;
use src\Middlewares\RequestValidations\ListProperty;

$app->group('/property', function ($app) {
    $app->post('[/]', [PropertyController::class, 'create'])
        ->add(new CreateProperty());

    $app->get('[/]', [PropertyController::class, 'list'])
        ->add(new ListProperty())
        ->add(new PaginationMiddleware());

    $app->get('/{id}[/]', [PropertyController::class, 'get']);
    $app->put('/{id}/sell[/]', [PropertyController::class, 'sell']);
    $app->put('/{id}/unsell[/]', [PropertyController::class, 'unsell']);

    $app->post('/{id}[/]', [PropertyController::class, 'update'])
        ->add(new CreateProperty());

    $app->delete('/{id}[/]', [PropertyController::class, 'delete']);

    $app->post('/{id}/image[/]', [PropertyController::class, 'addImage']);
    $app->delete('/{id}/image/{image_id}[/]', [PropertyController::class, 'deleteImage']);
});
