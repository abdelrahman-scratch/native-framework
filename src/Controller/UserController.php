<?php

namespace App\Controller;

use App\Repository\{PdoRoleRepository, PdoUserRepository};
use App\Constant\UserConstant;
use App\Service\UserService;
use Framework\{Input, Redirect, MysqlConnection, Session};
use Rakit\Validation\Validator;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var PdoRoleRepository
     */
    private $roleRepository;


    public function __construct()
    {
        Parent::__construct();
        $connection = (new MysqlConnection())->getDatabaseConnection();
        $repository = new PdoUserRepository($connection);
        $this->userService = new UserService($repository);
        $this->roleRepository = new PdoRoleRepository($connection);
    }

    public function create()
    {
        $roles = $this->roleRepository->getAll();
        return $this->blade->make('users.create', ["roles" => $roles]);
    }

    public function store()
    {
        $roles = $this->roleRepository->getAll([], ["id"]);
        $rolesIds = $this->extractIds($roles);

        $validation = $this->userService->validate(new Validator(), $_POST + $_FILES, $rolesIds);

        if ($validation->fails()) {
            Redirect::backWithErrors($validation->errors()->firstOfAll());
        }

        $email = Input::get("email");
        $isEmailExisted = $this->userService->isEmailExisted($email);
        if ($isEmailExisted) {
            Redirect::backWithErrors([UserConstant::EMAIL_ALREADY_EXISTS]);
        }
        $this->userService->create(Input::get("name"), $email,
            Input::get("password"), Input::get("roleId"));
        //if it used for register u need to setup session here too
        Session::flash("successful_action", UserConstant::USER_CREATED_SUCCESSFULLY);
        Redirect::to("/");

    }

    //@todo move this function to helpers
    private function extractIds($rows): string
    {
        $ids = [];
        foreach ($rows as $rowsItem) {
            $ids[] = $rowsItem->id;
        }
        return implode(",", $ids);
    }

}