<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function register()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[user.email]',
            'password' => 'required|min_length[8]'
        ];

        $input = $this->request->getJSON(true);
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if ($this->model->insert($input)) {
            return $this->getJWTForUser($input['email'], ResponseInterface::HTTP_CREATED);
        }

        return $this->fail($this->model->errors());
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]|validateUser[email,password]',
        ];

        $input = $this->request->getJSON(true);

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        return $this->getJWTForUser($input['email']);
    }

    private function getJWTForUser(string $email, int $responseCode = ResponseInterface::HTTP_OK)
    {
        try {
            $user = $this->model->findUserByEmailAddress($email);
            unset($user['password']);

            helper('jwt');

            $response = [
                'message' => 'User authenticated successfully',
                'user' => $user,
                'access_token' => getSignedJWTForUser($email)
            ];

            if ($responseCode === ResponseInterface::HTTP_CREATED) {
                return $this->respondCreated($response);
            }

            return $this->respond($response);
        } catch (\Exception $exception) {
            return $this->fail(
                ['error' => $exception->getMessage()],
                $responseCode
            );
        }
    }
}
