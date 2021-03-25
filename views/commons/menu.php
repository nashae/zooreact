<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Back-office</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (!Securite::verifAccessSession()) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>back/login">Login</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>back/admin">Accueil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Familles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= URL ?>back/familles/visualisation">Visualisation</a>
                        <a class="dropdown-item" href="<?= URL ?>back/familles/creation">Création</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Animaux
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= URL ?>back/animaux/visualisation">Visualisation</a>
                        <a class="dropdown-item" href="<?= URL ?>back/animaux/creation">Création</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>back/deconnexion">Déconnexion</a>
                </li>
            <?php }  ?>
        </ul>
    </div>
</nav>