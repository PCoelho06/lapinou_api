<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    private $allowedOrigins = [
        'https://lapinou.tech', // Production
        'https://blog.lapinou.tech', // Blog
        'https://secure.lapinou.tech', // Back-office
    ];
    public function before(RequestInterface $request, $arguments = null)
    {
        $origin = $request->header('Origin') ? $request->header('Origin')->getValue() : '';

        if (in_array($origin, $this->allowedOrigins)) {
            $response = service('response');
            $response->setHeader('Access-Control-Allow-Origin', $origin)
                ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
                ->setHeader('Access-Control-Allow-Credentials', 'true');

            if ($request->getMethod() === 'options') {
                $response->setStatusCode(200);
                return $response->send();
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
