<?php 
declare(strict_types=1);

use App\Controllers\Home;
use App\Controllers\Login;
use App\Controllers\Signup;
use App\Controllers\Profile;
use App\Controllers\Products;
use App\Middleware\GetProduct;
use App\Middleware\RequireLogin;
use App\Controllers\ProductIndex;
use App\Middleware\RequireAPIKey;
use App\Middleware\ActivateSession;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\AddJsonResponseHeader;



$app->group('', function(RouteCollectorProxy $group) {

    $group->get('/', Home::class);

    $group->get('/signup', [Signup::class, 'new']);

    $group->post('/signup', [Signup::class, 'create']);
    
    $group->get('/signup/success', [Signup::class, 'success']);

    $group->get('/login', [Login::class, 'new']);

    $group->post('/login', [Login::class, 'create']);

    $group->get('/logout', [Login::class, 'destroy']);

    $group->get('/profile', [Profile::class, 'show'])
            ->add(RequireLogin::class);

})->add(ActivateSession::class);


$app->group('/api', function(RouteCollectorProxy $group) {

    $group->get('/products', ProductIndex::class);
    
    $group->post('/products', [Products::class, 'create']);

    $group->group('', function(RouteCollectorProxy $group) {

        $group->get('/products/{id:[0-9]+}', Products::class . ':show');

        $group->patch('/products/{id:[0-9]+}', [Products::class, 'update']);

        $group->delete('/products/{id:[0-9]+}', [Products::class, 'delete']);
        
    })->add(GetProduct::class);   

})->add(RequireAPIKey::class)
    ->add(addJsonResponseHeader::class);
