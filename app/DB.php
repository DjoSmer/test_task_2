<?php

namespace App;

Use PDO;
Use Exception;
use PDOStatement;

class DB {
    private static $instance = null;

    /**
     * @var PDO
     */
    private $pdoMysql;

    /**
     * @param array $db_setting
     * @return DB
     */
    static public function instance($db_setting = []) {

        if (self::$instance == null) {
            self::$instance = new self($db_setting);
        }

        return self::$instance;
    }

    /**
     * execute query
     * @param $sql
     * @param array $args
     * @return PDOStatement
     */
    static public function query($sql, $args = []) {
        $pdo = self::instance()->pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    static public function fetch($query, $args = [], $fetch_style = PDO::FETCH_ASSOC) {
        $stmt = self::query($query, $args);
        return $stmt->fetch($fetch_style);
    }

    static public function fetchAll($query, $args = [], $fetch_style = PDO::FETCH_ASSOC) {
        $stmt = self::query($query, $args);
        return $stmt->fetchAll($fetch_style);
    }

    /**
     * Return count found rows in database
     */
    static public function foundRows() {
        $sql = 'SELECT FOUND_ROWS() as size;';
        $stmt = DB::query($sql);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['size'];
    }

    /**
     * return insert id
     * @param string $name
     * @return string
     */
    static public function id($name = null) {
        $pdo = self::instance()->pdo();
        return $pdo->lastInsertId($name);
    }

    /**
     * DB constructor.
     * @param array $db_setting
     * @throws Exception
     */
    private function __construct(array $db_setting) {

        $server = isset($db_setting['server']) ? $db_setting['server'] : 'localhost';
        $database_name = isset($db_setting['database_name']) ? $db_setting['database_name'] : null;
        $username = isset($db_setting['username']) ? $db_setting['username'] : null;
        $password = isset($db_setting['password']) ? $db_setting['password'] : null;

        if (!$database_name || !$username) {
            throw new Exception('MySql настройки, не заданы.');
        }
        $this->pdoMysql = new PDO(
            sprintf('mysql:host=%s;dbname=%s', $server, $database_name),
            $username,
            $password,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );

    }

    /**
     * @return PDO
     */
    public function pdo() {
        return $this->pdoMysql;
    }


    private function __clone() {}
    private function __wakeup() {}


}