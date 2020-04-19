<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Ajouter un produit</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="Nom du produit">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input name="description" type="text" class="form-control" id="description" placeholder="Description du produit">
    </div>
    <div class="form-group">
        <label for="category">Catégorie</label>
        <select name="category_id" class="form-control" id="category">
            <option value ="" selected>Choisissez la catégorie du produit, exemple : "Détente"</option>
            <?php foreach($categories as $category) :?>
                <option value="<?= $category->getId(); ?>"><?= $category->getName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="brand">Marque</label>
        <select name="brand_id" class="form-control" id="brand">
        <option value ="" selected>Choisissez la marque du produit, exemple : "oCirage"</option>
            <?php foreach($brands as $brand) :?>
                <option value="<?= $brand->getId(); ?>"><?= $brand->getName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="type_id">Type</label>
        <select name="type_id" class="form-control" id="type">
        <option value ="" selected>Choisissez le type du produit, exemple : "Chaussure de ville"</option>
            <?php foreach($types as $type) :?>
                <option value="<?= $type->getId(); ?>"><?= $type->getName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input name="picture" type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="price">Prix</label>
        <input name="price" type="number" class="form-control" id="price" step="0.01" placeholder="34,99">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <input name="status" type="number" class="form-control" id="status" placeholder="1 - le produit est disponible" min="1" max="2">
        <small id="statusHelpBlock" class="form-text text-muted">
            Le status est de 2 si le produit n'est pas disponible, 1 s'il est disponible
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>