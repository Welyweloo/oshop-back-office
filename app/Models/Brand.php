<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Brand extends CoreModel {
    
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    private $footer_order;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Brand en fonction d'un id donné
     * 
     * @param int $brandId ID de la marque
     * @return Brand
     */
    public static function find($brandId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM brand
            WHERE id = ' . $brandId;

        $pdoStatement = $pdo->query($sql);

        $brand = $pdoStatement->fetchObject('App\Models\Brand');
        
        return $brand;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table brand
     * 
     * @return Brand[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `brand`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');
        
        return $results;
    }

    /**
     * Récupérer les 5 marques mises en avant dans le footer
     * 
     * @return Brand[]
     */
    public function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM brand
            WHERE footer_order > 0
            ORDER BY footer_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $brands = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');
        
        return $brands;
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
            INSERT INTO `brand` (name)
            VALUES (:name)
        ";

        $stmt = $pdo->prepare($sql);

        $insertedRows = $stmt->execute([
            ":name" => $this->name,
        ]);

        if ($insertedRows > 0) {
            $this->id = $pdo->lastInsertId();

            return true;
        }
        
        return false;
    }

    public function changeDatas()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE `brand` 
            SET name = :name,
            updated_at = NOW()
            WHERE id = :id;
        ";

        $stmt = $pdo->prepare($sql);

        $updatedDatas = $stmt->execute([
            ":name" => $this->getName(),
            ":id" => $this->getId(),
        ]);

        return $updatedDatas;
    }

    public function deleteDatas($id)
    {
        $pdo = Database::getPDO();

        $sql = "
            DELETE FROM `brand` 
            WHERE id = :id;
        ";

        $stmt = $pdo->prepare($sql);

        $updatedDatas = $stmt->execute([
            ":id" => $id
        ]);

        return $updatedDatas;
    }


    /**
     * Get the value of footer_order
     *
     * @return  int
     */ 
    public function getFooterOrder()
    {
        return $this->footer_order;
    }

    /**
     * Set the value of footer_order
     *
     * @param  int  $footer_order
     */ 
    public function setFooterOrder(int $footer_order)
    {
        $this->footer_order = $footer_order;
    }
}
