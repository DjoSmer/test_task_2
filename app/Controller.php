<?php

namespace App;

Use Exception;

abstract class Controller {

    /**
     * default action
     * @var string
     */
    protected $actionName = 'index';

    /**
     * @var Route
     */
    protected $route;

    /**
     * @param Route $route
     * @param string $path
     * @return mixed
     * @throws Exception
     */
    static public function factory(Route $route, $path = ''){

        $name = $path;
        $action = null;
        if (strpos($path, '/')) {
            list($name, $action) = explode('/', $path);
        }

        $class = __NAMESPACE__ . '\\Controllers\\'.ucfirst($name);

        if (!class_exists($class)) {
            throw new Exception('Контролер не найден.');
        }

        return new $class($route, $action);
    }

    /**
     * Controller constructor.
     * @param Route $route
     * @param null $action
     */
    public function __construct(Route $route, $action = null) {
        $this->route = $route;
        if ($action) $this->actionName = $action;
    }

    /**
     * Check controller action and run it.
     * @return mixed
     * @throws Exception
     */
    public function action() {

        $action = 'action' . ucfirst($this->actionName) ;
        $args = $this->route->getArgs();

        if (!method_exists($this, $action)) {
            throw new Exception("Контролер, запрос не верный");
        }
        $response = $this->{$action}($args);

        return $response;
    }


}