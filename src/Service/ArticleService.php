<?php

namespace App\Service;


use App\Contract\ArticleRepositoryInterface;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class ArticleService
{
    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param Validator $validator
     * @param array $inputs
     * @return Validation
     */
    public function validate(Validator $validator, array $inputs): Validation
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
        ];

        return $validator->validate($inputs, $rules);
    }

    public function create(int $userId, string $title, string $content)
    {
        $this->articleRepository->create([
            "title" => $title,
            "content" => $content,
            "user_id" => $userId,
        ]);
    }


}