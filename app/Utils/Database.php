<?php

namespace App\Utils;

use PDO;

// Design Pattern : Singleton
class Database {
    /**
     * Objet PDO représentant la connexion à la base de données
     * 
     * @var PDO
     */
    private $dbh;
    /**
     * Propriété statique (liée à la classe) stockant l'unique instance objet
     * 
     * @var Database
     */
    private static $_instance;


    private function __construct() {
        $configData = parse_ini_file(__DIR__.'/../config.ini');
        
        try {
            $this->dbh = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
            );
        }

        catch(\Exception $exception) {
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage().'<br>';
            echo '<pre>';
            echo $exception->getTraceAsString();
            echo '</pre>';
            exit;
        }
    }

    /**
     * Méthode permettant de retourner, dans tous les cas,
     * la propriété dbh (objet PDO) de l'unique instance de Database
     *
     * @return PDO
     */
    public static function getPDO() {

        if (empty(self::$_instance)) {

            self::$_instance = new Database();
        }

        return self::$_instance->dbh;
    }
}