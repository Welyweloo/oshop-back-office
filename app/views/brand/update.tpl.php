<a href="<?= $router->generate('brand-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification de la marque <?= $brand->getName(); ?></h2>

<form action="<?= $router->generate('brand-update') ?><?= $brand->getId(); ?>" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $brand->getName(); ?>">
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>