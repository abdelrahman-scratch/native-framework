<?php

namespace App\Repository;

use App\Constant\DatabaseConstant;
use App\Contract\ArticleRepositoryInterface;


class PdoArticleRepository extends AbstractPdoRepository implements ArticleRepositoryInterface
{

    protected $tableName = "articles";


    public function getAllArticlesWithAuthorName(array $pagination = [], $attributes = ['*'])
    {
        $this->joinsQuery = "Left Join " . DatabaseConstant::USERS_TABLE . " on user_id = " . DatabaseConstant::USERS_TABLE . ".id";
        return $this->getAll($pagination, $attributes);
    }

    public function getArticleWithComments(int $id)
    {

    }


}