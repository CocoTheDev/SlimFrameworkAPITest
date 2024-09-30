<?php 

declare(strict_types=1);

namespace App\Middleware;

use App\Repositories\UserRepository;
use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class RequireAPIKey
{
    public function __construct(private ResponseFactory $factory,
                                private UserRepository $repository
                                )
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // $params = $request->getQueryParams();

        // if ( ! array_key_exists('api-key', $params ) )
        if ( ! $request->hasHeader('X-API-Key') )
        {
            $response = $this->factory->createResponse();
            $response->getBody()
                    ->write(json_encode('api-key is missing from request'));
            return $response->withStatus(400);
        }

        $api_key = $request->getHeaderLine('X-API-Key');
        $api_key_hash = hash_hmac('sha256', $api_key, $_ENV['HASH_SECRET_KEY']);

        $user = $this->repository->find('api_key_hash', $api_key_hash);

        if ( ! $user )
        {
            $response = $this->factory->createResponse();
            $response->getBody()
                    ->write(json_encode('invalid API key'));
            return $response->withStatus(401);
        }

        $response = $handler->handle($request);
        
        return $response;
    }
}