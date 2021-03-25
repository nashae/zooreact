<?php ob_start(); ?>

<?php 

$content = ob_get_clean();
$titre = "page d'administration";
require "views/commons/template.php";