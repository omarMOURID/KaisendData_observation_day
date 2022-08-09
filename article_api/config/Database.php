<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $db_name = "article_api";
    private $username = "root";
    private $password = "";
    public $connexion;

    public function getConnexion()
    {
        $this->connexion = null;

        try {
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->exec("set names utf8"); // pour ne pas avoir des problèmes avec les caractères accentuer
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }
}