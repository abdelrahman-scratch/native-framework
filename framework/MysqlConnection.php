<?php

namespace Framework;

use PDO;

class MysqlConnection implements DatabaseConnection
{
    /**
     * @var PDO
     */
    public $databaseConnection;

    /**
     * @return PDO
     */
    public function getDatabaseConnection(): PDO
    {
        if ($this->databaseConnection == null) {
            $this->setDatabaseConnection();
        }
        return $this->databaseConnection;
    }

    private function setDatabaseConnection()
    {
        $databaseName = Config::get("mysql.dbname");
        $userName = Config::get("mysql.username");
        $password = Config::get("mysql.password");
        $host = Config::get("mysql.host");

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $this->databaseConnection = new PDO(
            "mysql:host=" . $host . ";dbname=" . $databaseName . "",
            $userName,
            $password,
            $options
        );
    }

    //Note: PHP will automatically close the connection when your script ends.
    public function __destruct()
    {
        $this->databaseConnection = null;
    }
}
