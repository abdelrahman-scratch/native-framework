<?php

namespace App\Contract;


interface UserRepositoryInterface
{
    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email);

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmailWithRole(string $email);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

}