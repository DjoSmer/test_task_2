<?php

namespace App\Models;

Use App\Model;
Use App\DB;
use App\QueryBuilder;

class Tasks extends Model {

    static public function table() {
        return 'tasks';
    }

    static public function prefix() {
        return 'task';
    }

    public function getList(QueryBuilder $query = null) {

        if (!$query) {
            $query = QueryBuilder::instance($this)
                ->orderBy('create_at', 'desc')
                ->limit(0, 3);
        }

        $users = Users::instance();
        $statuses = Statuses::instance();

        $query->from($this)
            ->select([$query::FOUND_ROWS, 'id', 'text', 'create_at'])
            ->select(['name', 'email'], $users)
            ->select(['id', 'name'], $statuses)
            ->join($users, 'user_id')
            ->join($statuses, 'status_id');

        $tasks = DB::fetchAll($query->builder());

        $size = DB::foundRows();

        $data = [
            'size' => $size,
            'tasks' => $tasks,
        ];

        return $data;

    }

    /**
     * create new task
     * @param $user_id
     * @param $text
     * @param $status_id
     * @return int
     */
    public function create($user_id, $text, $status_id) {

        $task_id = $this->insert(
            [
                'user_id' => $user_id,
                'text' => $text,
                'status_id' => $status_id,
            ]
        );

        return $task_id;
    }

    /**
     * update task
     * @param $id
     * @param $text
     * @param $status_id
     */
    public function update($id, $text, $status_id) {

        $tasks_table = self::table();

        $sql_insert = "UPDATE $tasks_table set status_id = ?, text = ? WHERE id = ?";
        DB::query($sql_insert, [$status_id, $text, $id]);

    }

}