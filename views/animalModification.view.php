<?php ob_start() ?>

<form method="POST" action="<?= URL ?>back/animaux/modificationValidation" enctype="multipart/form-data">
    <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>" />
    <div class="form-group">
        <label for="animal_nom">Nom de l'animal</label>
        <input type="text" class="form-control" id="animal_nom" name="animal_nom" value="<?= $animal['animal_nom'] ?>" >
    </div>
    <div class="form-group">
        <label for="animal_description">Description</label>
        <textarea class="form-control" id="animal_description" name="animal_description" rows="3" ><?= $animal['animal_description'] ?>
        </textarea>
    </div>
    <div class="form-group">
        <label for="image">Image actuelle :  &nbsp;</label>
        <img src="<?= URL ?>public/images/<?= $animal['animal_image'] ?>" alt="image de <?= $animal['animal_nom'] ?>" height="50px" class="mb-3" />
        <input type="file" class="form-control-file" id="image" name="image">
    </div>



    <div class="form-group">
        <label for="animal_famille">Famille : </label>
        <select class="form-control" id="animal_famille" name="famille_id">
            <?php foreach ($familles as $famille) : ?>
                <option value="<?= $famille['famille_id'] ?>" 
                    <?php if($famille['famille_id'] === $lignesAnimal[0]['famille_id']) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?= $famille['famille_id'] ?> - <?= $famille['famille_libelle'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="row no-gutters">
        <div class="col-1"></div>
        <?php foreach ($continents as $continent) : ?>
            <div class="form-group form-check col-2">
                <input type="checkbox" class="form-check-input" name="continent-<?= $continent['continent_id'] ?>"
                    <?php if(in_array($continent['continent_id'], $tabContinents)) echo "checked" ?>
                >
                <label class="form-check-label" for="exemplecheck1">
                    <?= $continent['continent_libelle'] ?>
                    <label>
            </div>
        <?php endforeach; ?>
        <div class="col-1"></div>
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

<?php
$content = ob_get_clean();
$titre = "Page de modification de l'animal ". $animal['animal_nom'] ;
require "views/commons/template.php";
