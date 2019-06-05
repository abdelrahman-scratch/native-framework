<?php

namespace App\Controller;

use App\Constant\{ArticleConstant, DatabaseConstant};
use App\Contract\ArticleRepositoryInterface;
use App\Helper\UserHelper;
use App\Repository\PdoArticleRepository;
use App\Service\ArticleService;
use Framework\{Input, Redirect, Session, MysqlConnection};
use Rakit\Validation\Validator;

class ArticleController extends BaseController
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct()
    {
        Parent::__construct();
        $connection = (new MysqlConnection())->getDatabaseConnection();
        $this->articleRepository = new PdoArticleRepository($connection);
        $this->articleService = new ArticleService($this->articleRepository);
    }

    public function index($pageNumber = 1)
    {
        $articles = $this->articleRepository->getAllArticlesWithAuthorName(["pageNumber" => $pageNumber]);
        $pagesCount = $this->articleRepository->count() / DatabaseConstant::PAGINATION_PER_PAGE;
        return $this->blade->make("articles.index", ["articles" => $articles, "pagesCount" => ceil($pagesCount)]);
    }

    public function create()
    {
        return $this->blade->make('articles.create');
    }

    public function store()
    {
        $validation = $this->articleService->validate(new Validator(), $_POST + $_FILES);

        if ($validation->fails()) {
            Redirect::backWithErrors($validation->errors()->firstOfAll());
        }
        $userId = UserHelper::getUserId();
        $this->articleService->create($userId, Input::get("title"), Input::get("content"));

        Session::flash("successful_action", ArticleConstant::ARTICLE_CREATED_SUCCESSFULLY);
        Redirect::to("/");
    }
}