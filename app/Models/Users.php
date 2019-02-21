<?php

namespace App\Models;

use App\Model;

class Users extends Model {

    static public function table() {
        return 'users';
    }

    static public function prefix() {
        return 'user';
    }

    /**
     * Create new user
     * @param $name
     * @param $email
     * @return string
     */
    public function create($name, $email) {

        $user_id = $this->insert([
            'name' => $name,
            'email' => $email,
        ]);

        return $user_id;
    }

}