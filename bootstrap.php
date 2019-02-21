<?php

use App\DB;

define('CONTENT_ROOT', __DIR__);

function appRequire($class_path) {
    require CONTENT_ROOT . DIRECTORY_SEPARATOR . $class_path;
}

appRequire('app/App.php');
appRequire('app/Route.php');
appRequire('app/DB.php');
appRequire('app/QueryBuilder.php');
appRequire('app/Sessions.php');

appRequire('app/Controller.php');
appRequire('app/Controllers/App.php');
appRequire('app/Controllers/Task.php');
appRequire('app/Controllers/Auth.php');

appRequire('app/Model.php');
appRequire('app/Models/Tasks.php');
appRequire('app/Models/Users.php');
appRequire('app/Models/Statuses.php');

appRequire('app/View.php');

DB::instance([
    'database_name' => 'db_task',
    'server' => 'localhost',
    'username' => 'taskuser',
    'password' => 'taskpassword',
]);