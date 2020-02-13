<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('America/Argentina/Mendoza');
final class MySQLDB
{
    private static $instance;
    protected $connection = null;
    protected function __construct()
    {
        $this->connection = mysqli_connect("localhost", "root", "", "mendumy"); //projectdb
        mysqli_set_charset($this->connection, "utf8");
        if (mysqli_connect_errno()) {
            die("Fallo la conexión a MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
        }
    }
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function query($q)
    {
        return $this->connection->query(trim($q)); //default: MYSQLI_STORE_RESULT
    }
    public function error()
    {
        return $this->connection->error;
    }
    public function lastId()
    {
        return $this->connection->insert_id;
    }
    public function escapeString($str)
    {
        return $this->connection->real_escape_string($str);
    }
    public function affectedRows()
    {
        return $this->connection->affected_rows;
    }
    //only for 5.6.5 onwards
    public function startTransaction($flags = MYSQLI_TRANS_START_READ_WRITE)
    {
        $this->connection->begin_transaction($flags);
    }
    public function commit()
    {
        return $this->connection->commit();
    }
    public function rollback()
    {
        return $this->connection->rollback();
    }
    public function autoCommit(bool $mode)
    {
        return $this->connection->autocommit($mode);
    }
}
