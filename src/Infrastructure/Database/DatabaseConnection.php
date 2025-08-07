<?php

class DatabaseConnection implements DatabaseConnectionInterface
{
    private $connection;
    private $host;
    private $database;
    private $username;
    private $password;

    public function __construct($host = "localhost", $database = "gestion_ventas", $username = "root", $password = "")
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    public function commit()
    {
        return $this->connection->commit();
    }

    public function rollback()
    {
        return $this->connection->rollBack();
    }

    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }
}