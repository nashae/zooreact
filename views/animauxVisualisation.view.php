<?php ob_start() ?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Animal</th>
      <th scope="col">Description</th>
      <th scope="col" colspan="2" class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($animaux as $animal) : ?>
            <tr>
                <td><?= $animal['animal_id'] ?></td>
                <td>
                    <img src="<?= URL ?>public/images/<?= $animal['animal_image'] ?>" alt="image de <?= $animal["animal_nom"] ?>" height="30px" />
                </td>
                <td><?= $animal['animal_nom'] ?></td>
                <td><?= $animal['animal_description'] ?></td>
                <td>
                    <a href="<?= URL ?>back/animaux/modification/<?= $animal['animal_id'] ?>" class="btn btn-warning">Modifier</a>
                </td>
                <td>
                    <form method="post" action="<?= URL ?>back/animaux/validationSuppression" onsubmit="return confirm('voulez vous vraiment supprimer?');">
                        <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>" />
                        <button class="btn btn-danger" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        
    <?php endforeach ; ?>
  </tbody>
</table>

<?php 
$content = ob_get_clean();
$titre = "Page d'administration des animaux";
require "views/commons/template.php";