<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['email', 'password'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $beforeUpdate   = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->passwordHash($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->passwordHash($data);
    }

    private function passwordHash(array $data): array
    {
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        return $data;
    }

    public function findUserByEmailAddress(string $email)
    {
        $user = $this->where('email', $email)->first();

        if (!$user)
            throw new \Exception('User does not exist for provided email address');

        return $user;
    }
}
