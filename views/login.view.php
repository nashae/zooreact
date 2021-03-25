<?php ob_start(); ?>
<div class="container">
    <form method="POST" action="<?= URL ?>back/connexion">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" class="form-control" id="login" name="login" aria-describedby="loginHelp">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>

<?php 
$content = ob_get_clean();
$titre = "Login";
require "views/commons/template.php";