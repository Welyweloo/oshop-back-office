<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController 
{

    /**
     * Méthode s'occupant de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);

        //récupère toutes les catégories, sous forme d'instance de mon modèle Category
        $types = Type::findAll();

        //on passe ce tableau de résultats à la vue
        $this->show('type/list', ["types" => $types]);
    }

    public function add()
    { 
        if(empty($_POST))
        {
            $this->show('type/add');
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);

            $datas = [
                'name' => $validData['name'], 
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $type = new Type();
                $type->setName($datasToAdd['name']);
    
                if ($type->insert()) {
                    $_SESSION['alert'] = "Votre type bien été ajouté !";
                }


                //on redirige vers la liste des produits -> une autre méthode de redirection est proposée dans la méthode update() ci-dessous
                header("Location: list");
                die();
            }
            else
            {
                //on redirige vers la liste des produits
                header("Location: add");
            }


        }
     
    }

    public function update($params = [])
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);

        $type = Type::find($params);

        if(empty($_POST))
        {
            $this->show('type/update', ['type' => $type]);
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);

            $datas = [
                'name' => $validData['name'], 
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $type->setName($datasToAdd['name']);

                if ($type->changeDatas()) 
                {
                    $_SESSION['alert'] = "Votre type a bien été modifié !";
                }

                $this->redirectToRoute("type-list");
            }
            else
            {
                $this->redirectToRoute("type-update", ['id' => $params]);
            }


        }
    }


    public function delete($params = [])
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);
        
        $type = Type::find($params);
        $type->deleteDatas($params);

        $this->redirectToRoute("type-list");

    }

}