<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Statuses;
use App\View;

class App extends Controller {

    /**
     * Output main page
     */
    public function actionIndex() {

/*        $model_statuses = new Statuses();
        $statuses = $model_statuses->findAll('task', 'type');

        $view_task = new View('task', [
            'admin' => Auth::is_admin(),
            'statuses' => $statuses,
        ]);*/

        $view = new View('vue', [
            'admin' => Auth::is_admin(),
        ]);

        return $view->render();
    }

}