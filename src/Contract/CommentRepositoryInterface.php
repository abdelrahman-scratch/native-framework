<?php

namespace App\Contract;


interface CommentRepositoryInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
}