  
<?php
if (empty($_SESSION['user'])) 
{
    ?>
  <p class="display-4">
      Bienvenue dans le backOffice <br />
  </p>
  <p><strong>Démo</strong> -> Login = admin@oshop.fr / Password = cameleon</p>
  <?php
        if (!empty($_SESSION['loginMessage'])):
    ?>
    <div class="alert alert-danger"><?= $_SESSION['loginMessage'] ?></div>
    <?php
        //supprimer le message de la session pour ne pas le réafficher sur la prochaine page
        unset($_SESSION['loginMessage']);
    endif; ?>

  <div class="row mt-5 middle">
    <form action="<?= $router->generate('back-office-login') ?>" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="roger@shoe.com">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="••••••••••">
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
       
  </div>

<?php
}
else if($_SESSION['user']['userObject']->getLastLogin() == NULL)
{
?>
<p>
  Vous êtes bien connecté.e, toutefois penser à modifier votre mot de passe pour plus de sécurité.<br />
  <a href="<?= $router->generate("first-login") ?>">Modifier mon mot de passe.</a>
</p>
<?php
}
else 
{
?>
  <p class="display-4">
      Tu es déjà connecté.e <strong>petit.e coquin.e</strong>... Tu peux naviguer en cliquant sur les boutons tout là haut!
  </p>


<?php
}
?>