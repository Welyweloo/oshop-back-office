<?php

namespace App\Controllers;

use App\Models\AppUser;


class UserController extends CoreController 
{

    /**
     * Méthode s'occupant de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $this->checkAuthorization(["admin"]);

        //récupère toutes les catégories, sous forme d'instance de mon modèle Product
        $users = AppUser::findAll();

        //on passe ce tableau de résultats à la vue
        $this->show('user/list', ["users" => $users]);
    }

   
    public function add()
    { 
        $this->checkAuthorization(["admin"]);

        if(empty($_POST))
        {

            $this->show('user/add');
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);
            $datas = [
                'email' => $validData['email'], 
                'password' => $validData['password'], 
                'firstname' => $validData['firstname'], 
                'lastname' => $validData['lastname'], 
                'role' => $validData['role'],
                'statusUser' => $validData['statusUser'],  
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $user = new AppUser();
                $user->setEmail($datasToAdd['email']);
                $user->setPassword($datasToAdd['password']);
                $user->setFirstname($datasToAdd['firstname']);
                $user->setLastname($datasToAdd['lastname']);
                $user->setStatus($datasToAdd['statusUser']);
                $user->setRole($datasToAdd['role']);
    
                if ($user->insert()) {
                    $_SESSION['alert'] = "Votre utilisateur a bien été ajouté !";
                }

                $this->redirectToRoute("user-list");
            }
            else
            {
                $this->redirectToRoute("user-add");
            }
            
        }
     
    }


    public function update($params = [])
    { 
        $this->checkAuthorization(["admin"]);

        $user = AppUser::find($params);

        if(empty($_POST))
        {

            $this->show('user/update', ['user' => $user]);
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);
            $datas = [
                'email' => $validData['email'], 
                'password' => $validData['password'], 
                'firstname' => $validData['firstname'], 
                'lastname' => $validData['lastname'], 
                'role' => $validData['role'],
                'statusUser' => $validData['statusUser'],  
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $user->setEmail($datasToAdd['email']);
                $user->setPassword($datasToAdd['password']);
                $user->setFirstname($datasToAdd['firstname']);
                $user->setLastname($datasToAdd['lastname']);
                $user->setStatus($datasToAdd['statusUser']);
                $user->setRole($datasToAdd['role']);
    
                if ($user->changeDatas()) {
                    $_SESSION['alert'] = "Votre utilisateur a bien été modifié !";
                }

                $this->redirectToRoute("user-list");
            }
            else
            {
                $this->redirectToRoute("user-add", ['id' => $params]);
            }
            
            


        }
     
    }
    
    public function delete($params = [])
    {
        $this->checkAuthorization(["admin"]);
        
        $user = AppUser::find($params);
        $user->deleteDatas($params);

        $this->redirectToRoute("user-list");

    }
}