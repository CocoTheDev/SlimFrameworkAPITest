<?php
declare(strict_types=1);

namespace App\Controllers;

use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Profile 
{

    public function __construct(private PhpRenderer $view,
                                )
    {
    }
    
    public function show(Request $request, Response $response): Response
    {
        $user = $request->getAttribute('user');

        $encryption_key = Key::loadFromAsciiSafeString($_ENV['ENCRYPTION_KEY']);

        $api_key = Crypto::decrypt($user['api_key'], $encryption_key);

        return $this->view->render($response, 'profile.php', [
            'api_key' => $api_key
        ]);
    }



}