<?php

namespace App\Controllers;

abstract class CoreController {
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     */
    protected function show(string $viewName, $viewVars = []) {

        global $router;


        $viewVars['currentPage'] = $viewName; 
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewVars);

        if(empty($_SESSION['user']))
        {
            $viewName = 'login/back-office-login';
        }

        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    /*
    * Anciennes méthodes créées pour la "sécurisation" des données saisies par l'user. Attention FILTER_SANITIZE_STRING n'agit pas toujours comme souhaité (https://www.php.net/manual/fr/filter.filters.sanitize.php#118186) et addslashes peut être évité en utilisant un prepare() execute() plutôt qu'un exec().


    protected function sanitizeString($string)
    {
        $stringWithSlashes = addslashes($string);
        $stringSanitized = filter_var($stringWithSlashes, FILTER_SANITIZE_STRING);
        $stringSanitized = htmlspecialchars($stringWithSlashes, ENT_QUOTES);
        $stringWithCap = ucfirst($stringSanitized);
        return $stringWithCap;
    }

    protected function sanitizeImageUrl($picture)
    {
        $pictureSanitized = filter_var($picture, FILTER_SANITIZE_STRING);
        return  $pictureSanitized ;
    }

    protected function validateId($id)
    {
        $id = (int)$id;
        if(is_int($id))
        {
            return $id;
        } 
        else 
        {
            echo 'Your id must be an integer';
        }
    }

    protected function validateStatus($status)
    {
        $status = (int)$status;
        if(is_int($status) && $status >= 1 && $status <= 2)
        {
            return $status;
        } 
        else 
        {
            echo 'You must select 0 if the product is not available, 1 if it is';
        }
    }

    protected function validatePrice($price)
    {
        $comaPrice = str_replace(',', '.', $price);
        $newPrice = (float)$comaPrice;
        if(is_float($newPrice))
        {
            return $newPrice;
        } 
        else 
        {
            echo 'You must have a price in float like 14.40...';
        }
    }
    */

    protected function checkAuthorization($allowedRoles = [])
    {

        if (!empty($_SESSION['user'])) {
            $user = $_SESSION['user']['userObject'];
            $role = $user->getRole();
            $status = $user->getStatus();

            if (!in_array($role, $allowedRoles)){
                $errorController = new ErrorController();
                $errorController->err403();
                die();
            } 
            else if(in_array($role, $allowedRoles) && $status == 2)
            {
                $errorController = new ErrorController();
                $errorController->err403();
                die();
            }
        }
    }
    
   /**
    *Cette méthode me permet de supprimer les espaces inutiles et de valider le contenu du $_POST si la *clé fournie existe sinon renvoie NULL, mais en même temps supprime les caractères spéciaux
    */
    protected function checkDatasValidity(array $datas)
    {
        $validArray = [];
        foreach($datas as $key => $data)
        {
           

            $validData = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);

            if(isset($validData))
            {
                $validArray[$key] = trim($validData);
            }
                
        }

        return $validArray;
    }

    /**
     *Cette méthode me permet de vérifier la conformité des informations saisies par l'utilisateur.
     *
     */

    protected function checkDatasCompliance($datas) 
    {
        $validArray = [];
        $_SESSION['complianceAlert'] = [];


        //Vérification d'un nom
        if(array_key_exists('name', $datas))
        {
            if(strlen($datas['name']) >= 3)
            {
                $validArray['name'] = ucfirst($datas['name']);
            }
            else 
            {
                $nameError = "Le nom saisi doit contenir 3 caractères minimum.";
                array_push($_SESSION['complianceAlert'], $nameError);
            }
        }

        //Vérification dun sous-titre
        if(array_key_exists('subtitle', $datas))
        {
            if(strlen($datas['subtitle']) >= 5)
            {
                $validArray['subtitle'] = ucfirst($datas['subtitle']);
            }
            else 
            {
                $subtitleError = "Le sous-titre saisie doit contenir 5 caractères minimum.";
                array_push($_SESSION['complianceAlert'], $subtitleError);
            }
        }

        //Vérification des images
        if(array_key_exists(('picture'), $datas))
        {
            // Attention à la valeur de retour de strpos(...) -> https://www.php.net/manual/fr/function.strpos.php#refsect1-function.strpos-returnvalues
            if(strpos($datas['picture'], "http://") === 0 || strpos($datas['picture'], "https://") === 0)
            {
                $validArray['picture'] = strtolower($datas['picture']);
            }
            else 
            {
                $pictureError = "L'url de votre image doit commencer par http:// ou https://.";
                array_push($_SESSION['complianceAlert'], $pictureError);
            }
        }

        //Vérification d'une description
        if(array_key_exists('description', $datas))
        {
            if(strlen($datas['description']) > 0)
            {
                $validArray['description'] = ucfirst($datas['description']);
            }
            else 
            {
                $descriptionError = "La description doit être fournie obligatoirement.";
                array_push($_SESSION['complianceAlert'], $descriptionError);
            }
        }
    
        //Vérification d'une catégorie 
        if(array_key_exists('category_id', $datas))
        {
             $validArray['category_id'] = (int) $datas['category_id'];
        }

        //Vérification d'une brand
        if(array_key_exists('brand_id', $datas))
        {
            $validArray['brand_id'] = (int) $datas['brand_id'];
        }

        //Vérification d'un type
        if(array_key_exists('type_id', $datas))
        {
            $validArray['type_id'] = (int) $datas['type_id'];
        }

        //Vérification d'un prix
        if(array_key_exists('price', $datas))
        {
            $validPrice = str_replace(',', '.', $datas['price']);
            $validArray['price'] = (float) $validPrice;
        }

        //Vérification d'un status
        if(array_key_exists('status', $datas))
        {
            $validStatus = (int) $datas['status'];
            if($validStatus > 0 && $validStatus <= 2)
            {
                $validArray['status'] = $validStatus;
            }
            else 
            {
                $statusError = "Le status du produit est impérativement entre 1 (disponible) et 2 (non disponible)";
                array_push($_SESSION['complianceAlert'], $statusError);
            }
        }
      
        //Vérification d'un email
        if(array_key_exists(('email'), $datas))
        {
            if(filter_var($datas['email'], FILTER_VALIDATE_EMAIL))
            {
                $validArray['email'] = $datas['email'];
            }
            else
            {
                $emailError = "L'email saisi est incorrect, veillez à avoir une syntaxe comme paulette@oclock.io";
                array_push($_SESSION['complianceAlert'], $emailError);
            }
        }

        //Vérification d'un password
        if(array_key_exists(('password'), $datas))
        {
            if(preg_match('#^(?=.*[a-zéèàêâùïüë])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}#', $datas['password'])) // regex cc Ezequiel with specchars and "french letters". More on the ?= here 'https://buzut.net/la-puissance-des-regex/'
            {
                $validArray['password'] = password_hash($datas['password'], PASSWORD_DEFAULT);
            }
            else
            {
                $passwordError = "Le mot de passe choisi est incorrect. Il doit contenir:<br /> - 8 caractères minimum,<br /> - 1 minuscule minimum,<br /> - 1 majuscule minimum,<br /> - 1 chiffre minimum,<br /> - 1 caractère spécial minimum";
                array_push($_SESSION['complianceAlert'], $passwordError);
            }
        }


        //Vérification d'un prénom
        if(array_key_exists('firstname', $datas))
        {
            $validArray['firstname'] = ucfirst($datas['firstname']);
        }

        //Vérification d'un nom de famille
        if(array_key_exists('lastname', $datas))
        {
            $validArray['lastname'] = ucfirst($datas['lastname']);
        }

        //Vérification d'un role
        if(array_key_exists('role', $datas))
        {
            if($datas['role'] == 'admin' || $datas['role'] == 'catalog-manager' )
            {
                $validArray['role'] = $datas['role'];
            }
            else 
            {
                $roleError = "Ce rôle n'existe pas encore, veuillez choisir un rôle dans la liste prédéfinie.";
                array_push($_SESSION['complianceAlert'], $roleError);
            }
        }

        //Vérification d'un status
        if(array_key_exists('statusUser', $datas))
        {
            $validUserStatus = (int) $datas['statusUser'];
            if($validUserStatus > 0 && $validUserStatus <= 2)
            {
                $validArray['statusUser'] = $validUserStatus;
            }
            else 
            {
                $statusError = "Le status de l'utilisateur est impérativement entre 1 (activé) et 2 (désactivé/bloqué)";
                array_push($_SESSION['complianceAlert'], $statusError);
            }
        }

        return $validArray;
    }

    public function redirectToRoute($route, $urlParams = [])
    {
         //redirection
         global $router;
         header("Location: " . $router->generate($route, $urlParams));
         die();
    }

}


