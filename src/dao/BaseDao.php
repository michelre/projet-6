<?php

namespace Projet6\Dao;

class BaseDao
{
    protected function dbConnect()
    {
        $dbInfo = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $server = $dbInfo["host"] ?? 'localhost';
        $username = $dbInfo["user"] ?? 'root';
        $password = $dbInfo["pass"] ?? '';
        $db = $dbInfo["path"] ? substr($dbInfo["path"], 1) : 'projet6';
        return new \PDO('mysql:host=' . $server . ';dbname=' . $db . ';charset=utf8', $username, $password);
    }

    protected function Q($data)
    {
        return "'" . $data . "'";
    }
}
