  <p class="display-4">
      Bienvenue dans le backOffice <br /><strong>Dans les shoe</strong>...
  </p>
  <p class="display-5">
      Veuillez choisir un nouveau mot de passe avant de commencer svp!
  </p>
  <?php
        if (!empty($_SESSION['loginMessage'])):
    ?>
    <div class="alert alert-danger"><?= $_SESSION['loginMessage'] ?></div>
    <?php
        //supprimer le message de la session pour ne pas le réafficher sur la prochaine page
        unset($_SESSION['loginMessage']);
    endif; ?>

  <div class="row mt-5 middle">
    <form action="" method="POST">
    <div class="form-group">
            <label for="exampleInputPassword1">Old Password</label>
            <input name="oldpassword" type="oldpassword" class="form-control" id="exampleInputPassword1" placeholder="••••••••••">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">New Password</label>
            <input name="newpassword" type="newpassword" class="form-control" id="exampleInputPassword1" placeholder="••••••••••">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Confirm New Password</label>
            <input name="confirm-password" type="password" class="form-control" id="exampleInputPassword1" placeholder="••••••••••">
            <small id="passwordHelpBlock" class="form-text text-muted">
                Le mot de passe doit contenir 8 caractères minimum (1 majuscule minimum, 1 minuscule minimum, 1 chiffre minimum, 1 caractère spécial minimum). 
            </small>        
        </div>

        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
    </form>
       
  </div>

<?php
