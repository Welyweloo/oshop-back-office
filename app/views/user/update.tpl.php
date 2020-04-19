<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modifier un utilisateur</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" type="text" class="form-control" id="email" value="<?= $user->getEmail(); ?>">
    </div>
    <div class="form-group">
        <label for="description">Password</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="Choisissez un mot de passe">
        <small id="passwordHelpBlock" class="form-text text-muted">
            Le mot de passe doit contenir 8 caractères minimum (1 majuscule minimum, 1 minuscule minimum, 1 chiffre minimum, 1 caractère spécial minimum). 
        </small>
    </div>
    <div class="form-group">
        <label for="description">Prénom</label>
        <input name="firstname" type="firstname" class="form-control" id="firstname" value="<?= $user->getFirstname(); ?>">
    </div>
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input name="lastname" type="text" class="form-control" id="lastname" value="<?= $user->getLastname(); ?>">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" class="form-control" id="role">
            <option value="catalog-manager" <?= ($user->getRole() === "catalog-manager") ? "selected" : ""; ?>>Catalog-Manager</option>
            <option value="admin" <?= ($user->getRole() === "admin") ? "selected" : ""; ?>>Admin</option>
        </select>
    </div>
    <div class="form-group">
        <label for="statusUser">Statut</label>
        <select name="statusUser" class="form-control" id="statusUser">
            <option value ="" selected>Choisissez le rôle de votre utilisateur</option>
            <option value="1" <?= ($user->getStatus() == 1) ? "selected" : ""; ?>>Activé</option>
            <option value="2" <?= ($user->getStatus() == 2) ? "selected" : ""; ?>>Désactivé / Bloqué</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>