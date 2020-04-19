<?php

namespace App\Controllers;

use App\Models\AppUser;

class LoginController extends CoreController {

    /**
     * Méthode s'occupant de la page de connexion au back-offiche
     *
     * @return void
     */

    public function backOfficeLogin()
    {
        if(!empty($_POST))
        {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $user = AppUser::findByEmail($email);

            if($user)
            {
                if(password_verify($password, $user->getPassword()))
                {
                    $user->changeDatas();
                    $_SESSION['user'] = ["userId" => $user->getId(), "userObject" => $user];
                    $_SESSION['loginMessage'] = 'Bonjour '.$user->getFirstname().', bonne journée !';
                    $this->redirectToRoute("main-home");
                }
                else
                {
                    $_SESSION['loginMessage'] = 'Hmm un imposteur ? Etes-vous sûr.e d’être autorisé.e à venir par ici ?';
                    $this->redirectToRoute("back-office-login");

                }
            }
            else
            {
                $_SESSION['loginMessage'] = 'Hmm un imposteur ? Etes-vous sûr.e d’être autorisé.e à venir par ici ?';
                $this->redirectToRoute("back-office-login");

            }

        }

        $this->show('login/back-office-login');

    }

    public function firstLogin()
    {
        $user = AppUser::find($_SESSION['user']['userId']);

        if(!empty($_POST))
        {
            $this->checkAuthorization(["admin"]);

            $user = AppUser::find($_SESSION['user']['userId']);
    
            $validData = $this->checkDatasValidity($_POST);
            $datas = [
                'oldpassword' => $validData['oldpassword'],  
                'newpassword' => $validData['newpassword'] 
            ];

            $datasToAdd = $this->checkDatasCompliance($datas);

            if(empty($_SESSION['complianceAlert']))
            {
                $user->setPassword($datasToAdd['oldpassword']);

                if ($user->changeDatas()) {
                    $_SESSION['alert'] = "Votre mot de passe a bien été modifié !";
                }

                $this->redirectToRoute("main-home");
            }
            else
            {
                $this->redirectToRoute("first-login");
            }  

        }
        $this->show('login/first-login');
    }

    public function Disconnect()
    {
        unset($_SESSION['user']);
        $this->redirectToRoute("back-office-login");
        
    }
}