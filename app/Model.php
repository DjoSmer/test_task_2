<?php

namespace App;

abstract class Model {

    static public function instance() {
        return new static();
    }

    /**
     * Return database table name
     * @return string
     */
    static public function table() {
        return false;
    }

    /**
     * return prefix for select
     * @return bool
     */
    static public function prefix() {
        return false;
    }

    /**
     * find in database and return one record
     * @param $value
     * @param string $column
     * @return null
     */
    public function find($value, $column = 'id') {
        $data = $this->findAll($value, $column);
        return (isset($data[0])) ? $data[0] : null;
    }

    /**
     * find in database and return all record
     * @param $value
     * @param string $column
     * @return array
     */
    public function findAll($value, $column = 'id') {

        $query = QueryBuilder::instance()
            ->from($this)
            ->where($column, '?');

        $data = DB::fetchAll($query->builder(), [ $value ] );

        return $data;
    }

    /**
     * insert row to database
     * @param $data
     * @return string
     */
    public function insert($data) {

        $insert = '';
        $values = '';
        $args = [];

        foreach ($data as $key => $value) {
            if ($insert) {
                $insert .= ',';
                $values .= ',';
            }

            $insert .= $key;
            $values .= '?';
            $args[] = $value;
        }

        $table = $this::table();
        $sql = "INSERT $table($insert) VALUES($values);";
        DB::query($sql, $args);

        return DB::id('id');
    }

}