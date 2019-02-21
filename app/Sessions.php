<?php

namespace App;


class Sessions {

    /**
     * Run session start
     */
    static public function start() {
        session_start();
    }

    /**
     * @param $key
     * @param int $default
     * @return int
     */
    static public function get($key, $default = 0) {
        return (array_key_exists($key, $_SESSION)) ? $_SESSION[$key] : $default;
    }

    /**
     * @param $key
     * @param int $value
     */
    static public function set($key, $value = 0) {
        $_SESSION[$key] = $value;
    }

}