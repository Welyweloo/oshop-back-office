<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use App\Models\Brand;

class ProductController extends CoreController 
{

    /**
     * Méthode s'occupant de la liste des catégories
     *
     * @return void
     */
    public function list()
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);

        //récupère toutes les catégories, sous forme d'instance de mon modèle Product
        $products = Product::findAll();

        //on passe ce tableau de résultats à la vue
        $this->show('product/list', ["products" => $products]);
    }

   
    public function add()
    { 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        if(empty($_POST))
        {
            $categories = Category::findAll();
            $brands = Brand::findAll();
            $types = Type::findAll();

            $this->show('product/add', [
                "categories" => $categories, 
                "brands" => $brands, 
                "types" => $types
                ]);
        }
        else 
        {
            $validData = $this->checkDatasValidity($_POST);
            $datas = [
                'name' => $validData['name'], 
                'description' => $validData['description'], 
                'picture' => $validData['picture'], 
                'price' => $validData['price'], 
                'status' => $validData['status'],
                'brand_id' => $validData['brand_id'],  
                'category_id' => $validData['category_id'],
                'type_id' => $validData['type_id']
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $product = new Product();
                $product->setName($datasToAdd['name']);
                $product->setDescription($datasToAdd['description']);
                $product->setPicture($datasToAdd['picture']);
                $product->setPrice($datasToAdd['price']);
                $product->setStatus($datasToAdd['status']);
                $product->setBrandId($datasToAdd['brand_id']);
                $product->setCategoryId($datasToAdd['category_id']);
                $product->setTypeId($datasToAdd['type_id']);
    
                if ($product->insert()) {
                    $_SESSION['alert'] = "Votre produit a bien été ajouté !";
                }

                $this->redirectToRoute("product-list");
            }
            else
            {
                $this->redirectToRoute("product-add");
            }
            
            


        }
     
    }


    public function update($params = [])
    { 
        $this->checkAuthorization(["admin", "catalog-manager"]);

        $product = Product::find($params);
            $categories = Category::findAll();
            $brands = Brand::findAll();
            $types = Type::findAll();

        if(empty($_POST))
        {
            
        }
        else 
        {
            
            $validData = $this->checkDatasValidity($_POST);
            $datas = [
                'name' => $validData['name'], 
                'description' => $validData['description'], 
                'picture' => $validData['picture'], 
                'price' => $validData['price'], 
                'status' => $validData['status'],
                'brand_id' => $validData['brand_id'],  
                'category_id' => $validData['category_id'],
                'type_id' => $validData['type_id']
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if (empty($_SESSION['complianceAlert'])) {

                $product->setName($datasToAdd['name']);
                $product->setDescription($datasToAdd['description']);
                $product->setPicture($datasToAdd['picture']);
                $product->setPrice($datasToAdd['price']);
                $product->setStatus($datasToAdd['status']);
                $product->setBrandId($datasToAdd['brand_id']);
                $product->setCategoryId($datasToAdd['category_id']);
                $product->setTypeId($datasToAdd['type_id']);

                if ($product->changeDatas()) {
                    $_SESSION['alert'] = "Votre produit a bien été modifié !";
                }
                
                $this->redirectToRoute("product-list");
            }
            else
            {
                $this->redirectToRoute("product-update", ['id' => $params]);
            }
        }

        $this->show('product/update', [
            "product" => $product,
            "categories" => $categories, 
            "brands" => $brands, 
            "types" => $types
            ]);
     
    }
    
    public function delete($params = [])
    {
        $this->checkAuthorization(["admin", "catalog-manager"]);
        
        $product = Product::find($params);
        $product->deleteDatas($params);

        $this->redirectToRoute("product-list");

    }
}