<?php

namespace App\Models;

Use App\Model;
Use App\DB;
Use PDO;

class Statuses extends Model {

    static public function table() {
        return 'statuses';
    }

    static public function prefix() {
        return 'status';
    }

}