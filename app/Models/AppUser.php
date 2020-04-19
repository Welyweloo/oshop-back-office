<?php 
namespace App\Models;
use App\Utils\Database;
use PDO;

class AppUser extends CoreModel 
{
    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $role;
    private $status;
    private $last_login;

    //créer tous les getters et setters ! 

    public static function findByEmail($email)
    {
        //récupère notre objet pdo
        $pdo = Database::getPDO();

        //notre requête sql de recherche, avec des paramètres nommés 
        $sql = "SELECT * 
                FROM app_user 
                WHERE `email` = :email";

        //envoie la requête chez mysql
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetchObject(self::class);

        return $user;
    }

    public static function find($appUserId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `app_user` WHERE `id` =' . $appUserId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $user = $pdoStatement->fetchObject('App\Models\AppUser');

        // retourner le résultat
        return $user;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     * 
     * @return User[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');
        
        return $results;
    }

    public function insert()
    {
                // Récupération de l'objet PDO représentant la connexion à la DB
                $pdo = Database::getPDO();

                // Ecriture de la requête INSERT INTO
                $sql = "
                    INSERT INTO `app_user` (email, password, firstname, lastname, role, status)
                    VALUES (:email, :password, :firstname, :lastname, :role, :status)
                ";
        
                //on envoie notre requête au serveur MySQL, sans l'exécuter
                $stmt = $pdo->prepare($sql);
        
                //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
                //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
                //c'est l'un ou l'autre ! 
                $insertedRows = $stmt->execute([
                    ":email" => $this->email,
                    ":password" => $this->password,
                    ":firstname" => $this->firstname,
                    ":lastname" => $this->lastname,
                    ":status" => $this->status,
                    ":role" => $this->role
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
            UPDATE `app_user` 
            SET email = :email,
            password = :password,
            firstname = :firstname,
            lastname = :lastname,
            status = :status,
            role = :role,
            updated_at = NOW()
            WHERE id = :id;
        ";

        //on envoie notre requête au serveur MySQL, sans l'exécuter
        $stmt = $pdo->prepare($sql);

        //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
        //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
        //c'est l'un ou l'autre ! 
        $updatedDatas = $stmt->execute([
            ":email" => $this->getEmail(),
            ":password" => $this->getPassword(),
            ":firstname" => $this->getFirstname(),
            ":lastname" => $this->getLastname(),
            ":status" => $this->getStatus(),
            ":role" => $this->getRole(),
            ":id" => $this->getId()
        ]);

        return $updatedDatas;
    }

    public function lastlogin()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            UPDATE `app_user` 
            SET last_login = NOW()
            WHERE id = :id;
        ";

        //on envoie notre requête au serveur MySQL, sans l'exécuter
        $stmt = $pdo->prepare($sql);

        //on exécute la requête, en remplacant les paramètres de la requête par ces valeurs
        //si on indique les valeurs remplacant les paramètres de la requête ici, on ne fait pas les bindValue()
        //c'est l'un ou l'autre ! 
        $updatedDatas = $stmt->execute([
            ":email" => $this->getEmail(),
            ":password" => $this->getPassword(),
            ":firstname" => $this->getFirstname(),
            ":lastname" => $this->getLastname(),
            ":status" => $this->getStatus(),
            ":role" => $this->getRole(),
            ":id" => $this->getId()
        ]);

        return $updatedDatas;
    }

    public function deleteDatas($id)
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            DELETE FROM `app_user` 
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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

        /**
     * Get the last login date
     */ 
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * Set the last login date()
     *
     * @return  self
     */ 
    public function setLastLogin($lastlogin)
    {
        $this->last_login = $lastlogin;

        return $this;
    }


}