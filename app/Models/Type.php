<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


class Type extends CoreModel
{
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table
    
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    private $footer_order;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Type en fonction d'un id donné
     *
     * @param int $typeId ID du type
     * @return Type
     */
    public static function find($typeId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `type` WHERE `id` =' . $typeId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $type = $pdoStatement->fetchObject('App\Models\Type');

        // retourner le résultat
        return $type;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table type
     *
     * @return Type[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `type`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');
        
        return $results;
    }

    /**
     * Récupérer les 5 types mis en avant dans le footer
     *
     * @return Type[]
     */
    public function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM type
            WHERE footer_order > 0
            ORDER BY footer_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $types = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Type');
        
        return $types;
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
            INSERT INTO `type` (name)
            VALUES (:name)
        ";

        //on envoie notre requête au serveur MySQL, sans l'exécuter
        $stmt = $pdo->prepare($sql);

        //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
        //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
        //c'est l'un ou l'autre ! 
        $insertedRows = $stmt->execute([
            ":name" => $this->name,
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
            UPDATE `type` 
            SET name = :name,
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
            DELETE FROM `type` 
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