<?php

namespace App\Contract;


interface RoleRepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name);

    /**
     * @param array $pagination
     * @param array $attributes
     * @return array
     */
    public function getAll(array $pagination = [], $attributes = ['*']): array;
}