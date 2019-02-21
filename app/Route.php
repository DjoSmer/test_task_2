<?php

namespace App;

use Exception;

class Route {

    /**
     * array routes for access web app
     * @var array
     */
    static $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * current method request
     * @var string
     */
    protected $method = '';

    /**
     * array request data
     * @var array
     */
    protected $args = [];

    /**
     * callback action, if route found
     * @var string
     */
    protected $callback = '';

    /**
     * current request uri
     * @var string
     */
    protected $path;

    /**
     * separator for route
     * @var string
     */
    private $separator = '/';

    /**
     * @param $method
     * @param $route_path
     * @param mixed $callback
     */
    static private function _add($method, $route_path, $callback = null) {
        self::$routes[$method][$route_path] = $callback;
    }

    /**
     * add GET route path
     * @param $route_path
     * @param mixed $callback
     */
    static public function get($route_path, $callback = null) {
        self::_add('GET', $route_path, $callback);
    }

    /**
     * add POST route path
     * @param $route_path
     * @param mixed $callback
     */
    static public function post($route_path, $callback = null) {
        self::_add('POST', $route_path, $callback);
    }

    /**
     * explode uri, check a method of request and exists path.
     * @param $request
     * @throws Exception
     */
    public function __construct($request) {

        $separator = $this->separator;
        $path = trim($request, $separator);
        if (!$path) $path = $separator;

        $this->method = $_SERVER['REQUEST_METHOD'];

        switch($this->method) {
            case 'POST':
                $this->args = $this->trimRequest($_POST);
                break;
            case 'GET':
                $this->args = $this->trimRequest($_GET);
                break;
            default:
                throw new Exception('Недопустимый метод');
                break;
        }

        if (!array_key_exists($path, self::$routes[$this->method])) {
            throw new Exception('Такого запроса нету');
        }

        $this->path = $path;
        $this->callback = self::$routes[$this->method][$path];
    }

    /**
     *
     * @return mixed
     * @throws Exception
     */
    public function callback() {

        $callback = $this->callback;
        if (is_string($callback) || is_null($callback)) {
            $path = is_null($callback) ? $this->path : $callback;
            $controller = Controller::factory($this, $path);
            return $controller->action();
        }
        else {
            throw new Exception('Неизвестный callback');
        }
    }

    /**
     * @return array
     */
    public function getArgs() {
        return $this->args;
    }

    /**
     * @param $data
     * @return array|string
     */
    private function trimRequest($data) {
        $args = [];
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $args[$k] = $this->trimRequest($v);
            }
        } else {
            $args = trim($data);
        }
        return $args;
    }

}