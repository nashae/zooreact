<?php ob_start() ?>

<form method="POST" action="<?= URL ?>back/animaux/creationValidation" enctype="multipart/form-data">
    <div class="form-group">
        <label for="animal_nom">Nom de l'animal</label>
        <input type="text" class="form-control" id="animal_nom" name="animal_nom">
    </div>
    <div class="form-group">
        <label for="animal_description">Description</label>
        <textarea class="form-control" id="animal_description" name="animal_description" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image : </label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>



    <div class="form-group">
        <label for="animal_famille">Famille :</label>
        <select class="form-control" id="animal_famille" name="animal_famille">
            <?php foreach ($familles as $famille) : ?>
                <option value="<?= $famille['famille_id'] ?>">
                    <?= $famille['famille_id'] ?> - <?= $famille['famille_libelle'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="row no-gutters">
        <div class="col-1"></div>
        <?php foreach ($continents as $continent) : ?>
            <div class="form-group form-check col-2">
                <input type="checkbox" class="form-check-input" name="continent_<?= $continent['continent_id'] ?>">
                <label class="form-check-label" for="exemplecheck1">
                    <?= $continent['continent_libelle'] ?>
                    <label>
            </div>
        <?php endforeach; ?>
        <div class="col-1"></div>
    </div>

    <!-- <div class="form-group">
        <label for="animal_continent">continent</label>
        <select multiple class="form-control" id="animal_continent" name="animal_continent">
            <?//php foreach ($continents as $continent) : ?>
                <option value="continent_<?//= $continent['continent_id'] ?>" name="continent_<?//= $continent['continent_id'] ?>"> <?//= $continent['continent_libelle'] ?></option>
            <?php// endforeach ;?>
        </select>
    </div> -->

    <button type="submit" class="btn btn-primary">Créer</button>
</form>

<?php
$content = ob_get_clean();
$titre = "Page de création d'un animal";
require "views/commons/template.php";
