<?php 
declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(private string $host,
                                private string $name,
                                private string $user,
                                private string $port,
                                private string $password)
    {
    }

    public function getConnection(): PDO
    {
        $dns = "mysql:host=$this->host;dbname=$this->name;port=$this->port;charset=utf8mb4";

        try {
            $pdo = new PDO($dns, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            return $pdo;

        } catch (PDOException $e) {
            $error = ['error' => 'Database connection failed: ' . $e->getMessage()];
            $response->getBody()->write(json_encode($error));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}