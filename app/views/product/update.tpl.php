<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification du produit <?= $product->getName(); ?></h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="name">Nom</label>
        <input name="name" type="text" class="form-control" id="name" value="<?= $product->getName(); ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" type="text" class="form-control" id="description"><?= $product->getDescription(); ?></textarea>
    </div>
    <div class="form-group">
        <label for="category">Catégorie</label>
        <select name="category_id" class="form-control" id="category">
            <?php foreach($categories as $category) :?>
                <option <?= ($product->getCategoryId() == $category->getId()) ? 'selected' : ''; ?> value="<?= $category->getId(); ?>"><?= $category->getName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="brand">Marque</label>
        <select name="brand_id" class="form-control" id="brand">
            <?php foreach($brands as $brand) :?>
                <option <?= ($product->getBrandId() == $brand->getId()) ? 'selected' : ''; ?> value="<?= $brand->getId(); ?>"><?= $brand->getName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="type_id">Type</label>
        <select name="type_id" class="form-control" id="type">
            <?php foreach($types as $type) :?>
                <option <?= ($product->getTypeId() == $type->getId()) ? 'selected' : ''; ?> value="<?= $type->getId(); ?>"><?= $type->getName(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="picture">Image</label>
        <input name="picture" type="text" class="form-control" id="picture" value="<?= $product->getPicture(); ?>" aria-describedby="pictureHelpBlock">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>
    <div class="form-group">
        <label for="price">Prix</label>
        <input name="price" type="number" class="form-control" id="price" step="0.01" value="<?= $product->getPrice(); ?>">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <input name="status" type="number" class="form-control" id="status" value="<?= $product->getStatus(); ?>" min="1" max="2">
        <small id="statusHelpBlock" class="form-text text-muted">
            Le status est de 2 si le produit n'est pas disponible, 1 s'il est disponible
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>
