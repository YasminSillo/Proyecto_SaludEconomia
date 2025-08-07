<?php

interface DatabaseConnectionInterface
{
    public function getConnection();
    public function beginTransaction();
    public function commit();
    public function rollback();
    public function prepare($sql);
    public function execute($sql, $params = []);
}