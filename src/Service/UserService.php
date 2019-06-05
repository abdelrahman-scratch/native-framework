<?php

namespace App\Service;


use App\Contract\UserRepositoryInterface;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class UserService
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Validator $validator
     * @param array $inputs
     * @param string $roles
     * @return Validation
     */
    public function validate(Validator $validator, array $inputs, string $roles): Validation
    {
        $rules = [
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'role_id' => 'in:' . $roles,
        ];

        return $validator->validate($inputs, $rules);
    }


    public function isEmailExisted(string $email): bool
    {
        if (empty($this->userRepository->findByEmail($email))) {
            return false;
        }
        return true;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param int $roleId
     * @return int
     */
    public function create(string $name, string $email, string $password, int $roleId): int
    {
        return $this->userRepository->create(
            [
                'name' => $name,
                'email' => $email,
                'password' => $this->hashPassword($password),
                'role_id' => $roleId
            ]
        );
    }

    /**
     * @param string $password
     * @param int $algorithm
     * @param null $options
     * @return string
     */
    protected function hashPassword(string $password, $algorithm = PASSWORD_DEFAULT, $options = null): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }


}