<?php

namespace App\Controller;

use Jenssegers\Blade\Blade;

class BaseController
{

    /**
     * @var Blade
     */
    protected $blade;


    public function __construct()
    {
        $this->blade = new Blade('../view', '../storage/cache');
    }

    /**
     * @param mixed $response
     */
    public function toJson($response)
    {
        echo json_encode($response);
    }

}