<?php

namespace pdo_poo;

use Throwable;

class Database
{
    public static $db;

    // implementação do padrão de projetos singleton
    private function __construct(){}

    public static function getInstance() : \PDO
    {
        try {
            if (!isset(self::$db)) {
                self::$db = new \PDO('sqlite:database2');
                self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            }
            return self::$db;
        } catch (Throwable $th) {
            echo 'Erro: ' . $th->getMessage();
        }

    }

    public function closeInstance()
    {
        self::$db = null;
    }
}