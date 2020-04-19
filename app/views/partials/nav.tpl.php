<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">oShop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

<?php if(isset($_SESSION['user'])): ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php  if($currentPage == "main/home"){ echo "active";} ?>">
                    <a class="nav-link" href="<?= $router->generate("main-home")?>">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <?php if($_SESSION['user']['userObject']->getRole() === 'admin') :?>
                <li class="nav-item <?php  if($currentPage == "user/list"){ echo "active";} ?>">
                    <a class="nav-link" href="<?= $router->generate("user-list")?>">Utilisateurs<span class="sr-only">(current)</span></a>
                </li>
                <?php endif; ?>
                <li class="nav-item <?php if($currentPage == "category/list"){ echo "active";}?>">
                    <a class="nav-link" href="<?= $router->generate("category-list")?>">Catégories</a>
                </li>
                <li class="nav-item <?php if($currentPage == "product/list"){ echo "active";}?>">
                    <a class="nav-link" href="<?= $router->generate("product-list")?>">Produits</a>
                </li>
                <li class="nav-item <?php if($currentPage == "type/list"){ echo "active";}?>">
                    <a class="nav-link" href="<?= $router->generate("type-list")?>">Type</a>
                </li>
                <li class="nav-item <?php if($currentPage == "brand/list"){ echo "active";}?>">
                    <a class="nav-link" href="<?= $router->generate("brand-list")?>">Brand</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tags</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sélections Accueil &amp; Footer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= $router->generate("back-office-logout")?>">Déconnexion</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Rechercher">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
<?php endif; ?>
    </div>
</nav>