<?php

namespace App\Contract;


interface ArticleRepositoryInterface
{

    public function getAllArticlesWithAuthorName(array $pagination = [], $attributes = ['*']);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function getArticleWithComments(int $id);

    public function count(): int;


}