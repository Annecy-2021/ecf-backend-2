<?php

abstract class Connect
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO('mysql:dbname=ecf_backend_2;host:127.0.0.1;port:3306;charset:utf-8', 'root', '', [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (Exception $e) {
            echo 'PDO Erreur : ' . $e->getMessage();
            die();
        }
    }
}
