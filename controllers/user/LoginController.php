<?php

namespace app\controllers\user;
use dektrium\user\controllers\SecurityController as SecurityController;

class LoginController extends SecurityController
{

    public function actionLogin(){

        return parent::actionLogin();

    }

    public function actionLogout(){

        return parent::actionLogout();

    }

}
