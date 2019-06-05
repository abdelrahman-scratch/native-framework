<?php

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Constant\UserConstant;
use App\Service\LoginService;
use Framework\{Input, Redirect, Session, MysqlConnection};
use App\Repository\PdoUserRepository;
use Rakit\Validation\Validator;

class LoginController extends BaseController
{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct()
    {
        Parent::__construct();
        if (Session::get(UserConstant::IS_USER_LOGGED_IN_SESSION_KEY)) {
            Redirect::to("/");
        }
        $connection = (new MysqlConnection())->getDatabaseConnection();
        $repository = new PdoUserRepository($connection);
        $this->loginService = new LoginService($repository);
    }

    /**
     * show login form if not logged in
     */
    public function index()
    {
        return $this->blade->make('auth.login');
    }

    public function login()
    {
        $validation = $this->loginService->validate(new Validator(), $_POST + $_FILES);

        if ($validation->fails()) {
            Redirect::backWithErrors($validation->errors()->firstOfAll());
        }
        $email = Input::get("email");
        $password = Input::get("password");

        $userEntity = $this->loginService->findByEmailWithRole($email);
        if (empty($userEntity)) {
            Redirect::backWithErrors([UserConstant::LOGIN_FAILED]);
        }

        $isPasswordVerified = $this->loginService->isPasswordVerified($password, $userEntity->password);

        if (!$isPasswordVerified) {
            Redirect::backWithErrors([UserConstant::LOGIN_FAILED]);
        }

        $roleName = $userEntity->role_name;
        $this->loginService->setUserSessions($userEntity->id, $roleName);

        Session::flash("successful_action", UserConstant::USER_LOGINED_SUCCESSFULLY);
        Redirect::to("/");
    }

}