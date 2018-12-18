<?php

namespace app\controllers;

use app\models\AppModel;
use app\models\Personal;
use fw\base\Controller;


/**
 *
 * Description of App
 *
 */

class AuthController extends AppController
{

    public function __construct($route)
    {
        parent::__construct($route);
        if (!$this->is_auth) {
            if ($this->isAjax()) {
                $data = array(
                    'redirect' => '/personal/login'
                );
                echo json_encode($data);
                die();
            } else {
                redirect('/personal/login');
            }
        }
    }
}