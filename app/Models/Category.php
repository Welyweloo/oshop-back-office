<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel {

    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     * 
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        $pdoStatement = $pdo->query($sql);

        $category = $pdoStatement->fetchObject('App\Models\Category');
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     * 
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     * 
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $categories;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home du back-office
     * la méthode est static pour qu'on puisse l'appeler sans avoir à créer d'instance de Category ! 
     * 
     * @return Category[]
     */
    public static function findAllBackOfficeHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT id, name
            FROM category
            ORDER BY updated_at DESC
            LIMIT 3
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $categories;
    }

        /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     * 
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            INSERT INTO `category` (name, subtitle, picture)
            VALUES (:name, :subtitle, :picture)
        ";

        //on envoie notre requête au serveur MySQL, sans l'exécuter
        $stmt = $pdo->prepare($sql);

        //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
        //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
        //c'est l'un ou l'autre ! 
        $insertedRows = $stmt->execute([
            ":name" => $this->name,
            ":subtitle" => $this->subtitle,
            ":picture" => $this->picture,
        ]);

        // Si au moins une ligne ajoutée
        if ($insertedRows > 0) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    public function changeDatas()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            UPDATE `category` 
            SET name = :name,
            subtitle = :subtitle,
            picture = :picture,
            updated_at = NOW()
            WHERE id = :id;
        ";

        //on envoie notre requête au serveur MySQL, sans l'exécuter
        $stmt = $pdo->prepare($sql);

        //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
        //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
        //c'est l'un ou l'autre ! 
        $updatedDatas = $stmt->execute([
            ":name" => $this->getName(),
            ":subtitle" => $this->getSubtitle(),
            ":picture" => $this->getPicture(),
            ":id" => $this->getId(),
        ]);

        return $updatedDatas;
    }

    public function deleteDatas($id)
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            DELETE FROM `category` 
            WHERE id = :id;
        ";

        //on envoie notre requête au serveur MySQL, sans l'exécuter
        $stmt = $pdo->prepare($sql);

        //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
        //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
        //c'est l'un ou l'autre ! 
        $updatedDatas = $stmt->execute([
            ":id" => $id
        ]);

        return $updatedDatas;
    }
    

    /**
     * Get the value of subtitle
     */ 
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */ 
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */ 
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */ 
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }


}
