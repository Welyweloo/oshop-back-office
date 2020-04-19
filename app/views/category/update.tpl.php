<a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification de la catégorie <?= $category->getName(); ?></h2>

<form action="<?= $router->generate('category-update') ?><?= $category->getId(); ?>" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $category->getName(); ?>">
    </div>
    <div class="form-group">
        <label for="subtitle">Sous-titre</label>
        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?= $category->getSubtitle(); ?>" aria-describedby="subtitleHelpBlock">
        <small id="subtitleHelpBlock" class="form-text text-muted">
            Sera affiché sur la page d'accueil comme bouton devant l'image
        </small>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input type="text" class="form-control" id="picture" name="picture" value="<?= $category->getPicture(); ?>" aria-describedby="pictureHelpBlock">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>