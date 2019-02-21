<?php

namespace App\Controllers;

use App;
use App\Controller;
use App\Models\Users;
use App\Sessions;
use Exception;

class Auth extends Controller {

    /**
     * @return int
     */
    static public function is_admin() {
        return (Sessions::get('admin'));
    }

    /**
     * Check login and admin access
     * @param $requestData
     */
    public function actionLogin($requestData) {
        $data = $this->validator($requestData);

        $login = $data['login'];
        $password = $data['password'];


        $model_user = new Users();
        $user = $model_user->find($login, 'name');

        if (isset($user['password']) && $user['password'] == $password) {
            Sessions::set('admin', 1);
        }

        App::redirect();
    }

    /**
     * Logout
     */
    public function actionLogout() {
        Sessions::set('admin', 0);
        App::redirect();
    }

    /**
     * Check request data
     * @param $requestData
     * @return array
     * @throws Exception
     */
    private function validator($requestData) {
        $data = [];
        foreach ($requestData as $key => $value) {

            switch ($key) {
                case'login':
                    if (!preg_match('/^[a-z0-9\-_]{4,20}$/i', $value)) throw new Exception('Логин введен некорректно.');
                    break;
                case'password':
                    break;
                default:
                    continue;
            }

            if (!mb_strlen($value)) {
                throw new Exception('Ошибка в данных, проверьте все ли вы данные ввели.');
            };

            $data[$key] = $value;
        }

        if (!count($data)) {
            throw new Exception('Ошибка в данных, проверьте все ли вы данные ввели.');
        };

        return $data;
    }


}