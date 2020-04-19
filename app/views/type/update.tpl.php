<a href="<?= $router->generate('type-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification du type <?= $type->getName(); ?></h2>

<form action="<?= $router->generate('type-update') ?><?= $type->getId(); ?>" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $type->getName(); ?>">
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>