<?php

namespace App;


class QueryBuilder {

    const FOUND_ROWS = 'FOUND_ROWS';

    /**
     * Main Model
     * @var Model
     */
    private $model;
    /**
     * @var array
     */
    private $columns = [];
    /**
     * @var array
     */
    private $joins = [];
    /**
     * @var array
     */
    private $whereAll = [];
    /**
     * @var string
     */
    private $order = '';
    /**
     * @var int
     */
    private $limitStart = 0;
    /**
     * @var int
     */
    private $limitCount = 0;
    /**
     * @var bool
     */
    private $found_rows = false;

    /**
     * Set Main Model
     * @param Model $model
     * @return QueryBuilder
     */
    static public function instance(Model $model = null) {
        return new self($model);
    }

    /**
     * QueryBuilder constructor.
     * @param Model $model
     */
    public function __construct(Model $model = null) {
        if ($model) $this->from($model);
    }

    /**
     * @param Model $model
     * @return $this
     */
    public function from(Model $model) {
        $this->model = $model;
        return $this;
    }

    /**
     * select builder, return string: table.column as prefix_column
     * @param $columns
     * @param Model $model
     * @return $this
     */
    public function select($columns, Model $model = null) {

        if (!$model) $model = $this->model;

        $table = $model::table();
        $prefix = $model::prefix();

        if (is_string($columns)) $columns = [$columns];

        $select = '';
        foreach ($columns as $column) {

            if ($column == self::FOUND_ROWS) {
                $this->found_rows = true;
                continue;
            }

            if ($select) $select .= ',';

            $select .= "$table.$column as ${prefix}_${column}";
        }

        $this->columns[] = $select;

        return $this;
    }

    /**
     * join database $model on $this->model
     * @param Model $model
     * @param $column_from
     * @param string $column_join
     * @return $this
     */
    public function join(Model $model, $column_from, $column_join = 'id') {

        $model_from = $this->model;
        $table_from = $model_from::table();
        $table_join = $model::table();

        $this->joins[] = " JOIN $table_join on $table_join.$column_join = $table_from.$column_from ";

        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @param Model|null $model
     * @return $this
     */
    public function where($column, $value, $operator = '=', Model $model = null) {

        if (!$model) $model = $this->model;

        $table = $model::table();
        $column = "$table.$column";

        $this->whereAll[] = " $column $operator $value ";

        return $this;
    }

    /**
     * Order By column direction
     * @param Model $model
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'ASC', Model $model = null) {

        if (!$model) $model = $this->model;
        $table = $model::table();
        $this->order = " ORDER BY  $table.$column $direction ";

        return $this;
    }

    /**
     * Limit $start $count
     * @param $start
     * @param int $count
     * @return $this
     */
    public function limit($start, $count = 10) {
        $this->limitStart = $start;
        $this->limitCount = $count;

        return $this;
    }

    /**
     * combine all query
     * @return string
     */
    public function builder() {

        $model_from = $this->model;
        $table_from = $model_from::table();

        $query = 'SELECT ';

        if ( $this->found_rows ) $query .= ' SQL_CALC_FOUND_ROWS ';

        if (count($this->columns)) {
            $query .= implode(',', $this->columns);
        }
        else {
            $query .= " * ";
        }

        $query .= " FROM $table_from ";

        if (count($this->whereAll)) $query .= " WHERE " . implode(' AND ', $this->whereAll);

        if (count($this->joins)) $query .= implode(' ', $this->joins);

        $query .= $this->order;

        if ($this->limitCount) {
            $query .= " LIMIT $this->limitStart, $this->limitCount ";
        }

        return $query;
    }
}