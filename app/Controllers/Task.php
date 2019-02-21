<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Statuses;
use App\QueryBuilder;
use App\View;
use App\Models\Users;
use App\Models\Tasks;
use Exception;

class Task extends Controller {

    /**
     * return task for edit
     * @param $requestData
     * @return array
     * @throws Exception
     */
    public function actionGet($requestData) {

        $data = $this->validator($requestData);

        $id = $data['id'];

        $model_tasks = new Tasks();
        $task = $model_tasks->find($id);

        if (!isset($task['id'])) {
            throw new Exception('Задача не найдена.');
        }

        $model_users = new Users();
        $user = $model_users->find($task['user_id']);
        unset($user['password']);

        return [
            'task' => $task,
            'user' => $user,
        ];
    }

    /**
     * Create or Update task
     * @param $requestData
     * @return array
     * @throws Exception
     */
    public function actionSend($requestData) {

        $data = $this->validator($requestData);

        if (isset($data['id']) && $data['id']) {
            return $this->update($data);
        }

        $name = $data['name'];
        $email = $data['email'];
        $text = $data['text'];
        $status_id = 1;

        $model_users = new Users();
        $user = $model_users->find($email, 'email');

        if (isset($user['id'])) {
            $user_id = $user['id'];

            if ($user['name'] != $name) {
                throw new Exception('Этот емаил использует другой пользователь.');
            }
        }
        else {
            $user_id = $model_users->create($name, $email);
        }

        if (Auth::is_admin()) {
            $status_id = isset($data['status']) ? $data['status'] : 1;
        }

        $model_tasks = new Tasks();
        $model_tasks->create($user_id, $text, $status_id);

        $tasks = $model_tasks->getList();
        $tasks['admin'] = Auth::is_admin();

        $view_task_list = new View('task_list_view', $tasks);
        $task_list_view = $view_task_list->render();

        return [
            'msg' => 'Ваш задача успешно добавлена.',
            'page' => 1,
            'totalCount' => $tasks['size'],
            'taskListView' => $task_list_view,
        ];

    }

    /**
     * Retrun Task list
     * @param $requestData
     * @return array
     */
    public function actionList($requestData) {

        $data = $this->validator($requestData);

        $column = $data['column'];
        $direction = $data['direction'];

        $limit = 3;
        $page = $data['page'];

        $offset = 0;
        if ($page > 1) $offset = $limit * ($page - 1);

        $model_tasks = Tasks::instance();

        $query = QueryBuilder::instance($model_tasks)
            ->limit($offset, $limit);

        if ($column == 'name' || $column == 'email') {
            $query->orderBy($column, $direction, Users::instance());
        }
        else if ($column == 'status') {
            $query->orderBy('id', $direction, Statuses::instance());
        }
        else {
            $query->orderBy('create_at', $direction);
        }

        $tasks = $model_tasks->getList($query);
        $tasks['admin'] = Auth::is_admin();

        $view_task_list = new View('task_list_view', $tasks);
        $task_list_view = $view_task_list->render();

        return [
            'page' => $page,
            'pageSize' => $limit,
            'totalCount' => $tasks['size'],
            'taskListView' => $task_list_view,
        ];
    }

    /**
     * Update task
     * @param $data
     * @return array
     * @throws Exception
     */
    public function update($data) {

        if (!Auth::is_admin()) {
            throw new Exception('Доступ только для персонала.');
        }

        $id = $data['id'];
        $text = $data['text'];
        $status_id = $data['status'];

        $model_tasks = new Tasks();
        $model_tasks->update($id, $text, $status_id);

        return [
            'msg' => 'Задача изменена.',
            'taskUpdate' => true,
        ];

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
                case'name':
                    if (!preg_match('/^[a-z0-9\-_]{4,20}$/i', $value)) throw new Exception('Имя введено некорректно.');
                    break;
                case'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) throw new Exception('Email введен некорректно.');
                    break;
                case'text':
                    $value = htmlspecialchars($value);
                    break;
                case'id':
                case'status':
                    $value = $value / 1;
                    if (!is_numeric($value)) throw new Exception('Данные указаны некорректно.');
                    break;
                case'column':
                    if (!preg_match('/^[a-z0-9_]{3,20}$/i', $value)) throw new Exception('Ошибка в данных сортировки', 1100);
                    break;
                case'direction':
                    if (!in_array($value, ['asc', 'desc'])) throw new Exception('Ошибка в данных сортировки',1101);
                    break;
                case'page':
                    $value = $value / 1;
                    if (!is_numeric($value)) throw new Exception('Ошибка в данных сортировки', 1102);
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