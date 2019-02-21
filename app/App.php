<?php

Use App\Sessions;
Use App\Route;

class App {

    static public function redirect($path = '/') {
        header('Location: ' . $path);
        exit;
    }

    /**
     * start web app
     */
    public function run() {

        appRequire('route.php');
        Sessions::start();

        $route_path = isset($_REQUEST['request']) ? $_REQUEST['request'] : $_SERVER['REQUEST_URI'];

        try {
            $route = new Route($route_path);
            $response = $route->callback();
        }
        catch (Exception $e) {
            $response = $e->getMessage();
        }

        $this->response($response);
    }


    /**
     * send response client
     * @param $response
     */
    public function response($response) {

        $ajax = false;

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
            $ajax = true;
        }

        if ($ajax) {
            $this->responseJSON($response);
        }
        else if (is_string($response)) {
            echo $response;
        }

    }


    /**
     * send response client format JSON
     * @param $response
     */
    public function responseJSON($response) {

        header('Access-Control-Allow-Orgin: *');
        header('Access-Control-Allow-Methods: *');
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');

        $json = [
            'success' => false,
        ];

        if (is_string($response)) {
            $json['success'] = false;
            $json['error'] = $response;
        }
        else if (is_array($response)) {
            $json = $response;
            $json['success'] = true;
        }

        echo json_encode($json);
    }

}