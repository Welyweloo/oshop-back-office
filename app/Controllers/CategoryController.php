<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController {

    /**
     * Méthode s'occupant de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);

        //récupère toutes les catégories, sous forme d'instance de mon modèle Category
        $categories = Category::findAll();

        //on passe ce tableau de résultats à la vue
        $this->show('category/list', ["categories" => $categories]);
    }

    /*
    *Ancienne méthodes utilisées pour ajouter et mettre à jour une catégorie
    public function add()
    { 
        if(empty($_POST))
        {
            $this->show('category/add');
        }
        else 
        {
            $name = $this->sanitizeString($_POST['name']);
            $subtitle = $this->sanitizeString($_POST['subtitle']);
            $picture = $this->sanitizeImageUrl($_POST['picture']);

            $Category = new Category();
            $Category->setName($name);
            $Category->setSubtitle($subtitle);
            $Category->setPicture($picture);
            $Category->setCreated_at(date("Y-m-d H:i:s"));
        
            if($Category->insert())
            {
                header("Location: list");
            }
            else 
            {
                echo 'Il y a une erreur.'; // Mais en fait, sur quel genre d'erreur pourrais-tu tomber ma pov' Lucette?
            }

        }
     
    }
 

    public function update($params = [])
    { 
        if(empty($_POST))
        {
            $category = new Category;
        }
        else 
        {
            
            $name = $this->sanitizeString($_POST['name']);
            $subtitle = $this->sanitizeString($_POST['subtitle']);
            $picture = $this->sanitizeImageUrl($_POST['picture']);

            $category = new Category();
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);
        
            $category->change($params);
        }
        $this->show('category/update', ['category' => $category->find($params)]);

     
    }
    
    */

    public function add()
    { 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        if(empty($_POST))
        {
            $this->show('category/add');
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);

            $datas = [
                'name' => $validData['name'], 
                'subtitle' => $validData['subtitle'], 
                'picture' => $validData['picture'], 
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $category = new Category();
                $category->setName($datasToAdd['name']);
                $category->setSubtitle($datasToAdd['subtitle']);
                $category->setPicture($datasToAdd['picture']);
    
                if ($category->insert()) {
                    $_SESSION['alert'] = "Votre catégorie a bien été ajoutée !";
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

        $category = Category::find($params);

        if(empty($_POST))
        {
            $this->show('category/update', ['category' => $category]);
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);

            $datas = [
                'name' => $validData['name'], 
                'subtitle' => $validData['subtitle'], 
                'picture' => $validData['picture'], 
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $category->setName($datasToAdd['name']);
                $category->setSubtitle($datasToAdd['subtitle']);
                $category->setPicture($datasToAdd['picture']);
    
                if ($category->changeDatas()) 
                {
                    $_SESSION['alert'] = "Votre catégorie a bien été modifiée !";
                }

                $this->redirectToRoute("category-list");
            }
            else
            {
                $this->redirectToRoute("category-update", ['id' => $params]);
            }


        }
    }


    public function delete($params = [])
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);
        
        $category = Category::find($params);
        $category->deleteDatas($params);

        $this->redirectToRoute("category-list");

    }

}