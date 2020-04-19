<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController {

    /**
     * Méthode s'occupant de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        //on autorise uniquement les admin et les catalog manager à accéder à cette page ! 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        //récupère toutes les catégories, sous forme d'instance de mon modèle Category
        $brand = Brand::findAll();

        //on passe ce tableau de résultats à la vue
        $this->show('brand/list', ["brand" => $brand]);
    }

    public function add()
    { 
        //on autorise uniquement les admin et les catalog manager à accéder à cette page ! 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        if(empty($_POST))
        {
            $this->show('brand/add');
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
                $brand = new Brand();
                $brand->setName($datasToAdd['name']);
    
                if ($brand->insert()) {
                    $_SESSION['alert'] = "Votre marque a bien été ajoutée !";
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
        //on autorise uniquement les admin et les catalog manager à accéder à cette page ! 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        $brand = Brand::find($params);

        if(empty($_POST))
        {
            $this->show('brand/update', ['brand' => $brand]);
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
                $brand->setName($datasToAdd['name']);

                if ($brand->changeDatas()) 
                {
                    $_SESSION['alert'] = "Votre marque a bien été modifiée !";
                }

                $this->redirectToRoute("brand-list");
            }
            else
            {
                $this->redirectToRoute("brand-update", ['id' => $params]);
            }


        }
    }


    public function delete($params = [])
    {
        //on autorise uniquement les admin et les catalog manager à accéder à cette page ! 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        $brand = Brand::find($params);
        $brand->deleteDatas($params);

        $this->redirectToRoute("brand-list");

    }

}