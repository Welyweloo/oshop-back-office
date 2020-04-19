<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel {
    
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;
    
    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     * 
     * @param int $productId ID du produit
     * @return Product
     */
    public static function find($productId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $productId;

        $pdoStatement = $pdo->query($sql);

        $result = $pdoStatement->fetchObject('App\Models\Product');
        
        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     * 
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');
        
        return $results;
    }


    /**
     * Récupérer les 5 produits mises en avant sur la home du back-office
     * la méthode est static pour qu'on puisse l'appeler sans avoir à créer d'instance de Product ! 
     * 
     * @return Product[]
     */
    public static function findAllBackOfficeHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT id, name
            FROM product
            ORDER BY id DESC
            LIMIT 3
        ';
        $pdoStatement = $pdo->query($sql);
        $products = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $products;
    }

            /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `product` (name, description, picture, price, status, brand_id, category_id, type_id)
            VALUES (:name, :description, :picture, :price, :status, :brand_id, :category_id, :type_id)
        ";

        $stmt = $pdo->prepare($sql);

        $insertedRows = $stmt->execute([
            ":name" => $this->name,
            ":description" => $this->description,
            ":picture" => $this->picture,
            ":price" => $this->price,
            ":status" => $this->status,
            ":brand_id" => $this->brand_id,
            ":category_id" => $this->category_id,
            ":type_id" => $this->type_id
        ]);
        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();

            return true;
        }
        return false;
    }

    public function changeDatas()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            UPDATE `product` 
            SET name = :name,
            description = :description,
            picture = :picture,
            price = :price,
            status = :status,
            brand_id = :brand_id,
            category_id = :category_id,
            type_id = :type_id,
            updated_at = NOW()
            WHERE id = :id;
        ";

        $stmt = $pdo->prepare($sql);

        $updatedDatas = $stmt->execute([
            ":name" => $this->getName(),
            ":description" => $this->getDescription(),
            ":picture" => $this->getPicture(),
            ":price" => $this->getPrice(),
            ":status" => $this->getStatus(),
            ":brand_id" => $this->getBrandId(),
            ":category_id" => $this->getCategoryId(),
            ":type_id" => $this->getTypeId(),
            ":id" => $this->getId()
        ]);

        return $updatedDatas;
    }

    public function deleteDatas($id)
    {
        $pdo = Database::getPDO();

        $sql = "
            DELETE FROM `product` 
            WHERE id = :id;
        ";

        $stmt = $pdo->prepare($sql);

        $updatedDatas = $stmt->execute([
            ":id" => $id
        ]);

        return $updatedDatas;
    }

    //retourne une version raccourcie de la description
    //copyright maître Damien
    public function getShortDescription()
    {
        return mb_substr($this->description, 0, 45).'...';
    }


    /**
     * Get the value of description
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */ 
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */ 
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */ 
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */ 
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */ 
    public function getBrandId()
    {
        return $this->brand_id;
    }


    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */ 
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */ 
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */ 
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */ 
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */ 
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }


}
