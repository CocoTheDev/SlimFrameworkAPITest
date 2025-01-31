<?php

use App\Database;
use Slim\Views\PhpRenderer;

return [
    Database::class => function(){
        return new Database(host: $_ENV['DB_HOST'],
                            port: $_ENV['DB_PORT'],
                            name: $_ENV['DB_NAME'],
                            user: $_ENV['DB_USER'],
                            password: $_ENV['DB_PASSWORD']);
    },

    PhpRenderer::class => function() {
        $renderer = new PhpRenderer(__DIR__ . '/../views');
        $renderer->setLayout('layout.php');
        return $renderer;
    },
];