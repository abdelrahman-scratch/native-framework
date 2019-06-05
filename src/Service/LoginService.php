<?php

namespace App\Service;

use App\Contract\UserRepositoryInterface;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Framework\Session;
use App\Constant\UserConstant;

class LoginService
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
     * @return Validation
     */
    public function validate(Validator $validator, array $inputs): Validation
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        return $validator->validate($inputs, $rules);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmailWithRole(string $email)
    {
        return $this->userRepository->findByEmailWithRole($email);
    }

    /**
     * @param int $userId
     * @param string $roleName
     */
    public function setUserSessions(int $userId, string $roleName): void
    {
        Session::set(UserConstant::USER_ID_SESSION_KEY, $userId);
        Session::set(UserConstant::USER_ROLE_NAME_SESSION_KEY, $roleName);
        Session::set(UserConstant::IS_USER_LOGGED_IN_SESSION_KEY, true);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function isPasswordVerified(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }


}