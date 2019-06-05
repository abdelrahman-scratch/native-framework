<?php

namespace App\Controller;

use App\Repository\{PdoRoleRepository, PdoUserRepository};
use Framework\{Input, Redirect, MysqlConnection};

class HomeController extends BaseController
{
    public function index()
    {
//        $connection = (new MysqlConnection())->getDatabaseConnection();
//        $repository = new PdoUserRepository($connection);
////        $this->roleRepository->getAll();
//        $all = $repository->findByEmail("abdelrahmanbadr.it@gmail.com");
//        var_dump($all);
//        die;
        return $this->blade->make('home');
    }
}

