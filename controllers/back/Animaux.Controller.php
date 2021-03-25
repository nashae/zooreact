<?php 
require_once "controllers/back/Securite.Class.php";
require_once "models/back/Animaux.Manager.php";
require_once "models/back/Familles.manager.php";
require_once "models/back/Continents.Manager.php";
require_once "controllers/back/utile.php";

class AnimauxController 
{
    private $animauxManager;
    private $famillesManager;
    private $continentsManager;

    public function __construct()
    {
        $this->animauxManager = new AnimauxManager();
        $this->famillesManager = new FamillesManager();
        $this->continentsManager = new ContinentsManager();
    }

    public function visualisation()
    {
        if(Securite::verifAccessSession()){
            $animaux = $this->animauxManager->getAnimaux();
            require_once "views/animauxVisualisation.view.php";
        } else {
            throw new Exception("vous n'avez pas acces à cette page");
        }
    }

    public function suppression()
    {
        if(Securite::verifAccessSession()){
            $idAnimal = (int)Securite::secureHTML($_POST['animal_id']);
            $image = $this->animauxManager->getImageAnimal($idAnimal);
            unlink("public/images/".$image);
            $this->animauxManager->deleteDBAnimalContinent($idAnimal);  //suppression dans la table intermediaire en premier
            $this->animauxManager->deleteDBAnimal($idAnimal);   //puis dans table animal , sinon erreur
            $_SESSION['alert'] = [
                "message" => "L'animal est supprimé",
                "type" => "alert-success"
            ];
            
            
            header('location: '.URL."back/animaux/visualisation");
        } else {
            throw new Exception("vous n'avez pas le droit de faire cette action");
        }
    }

    public function creationTemplate()
    {
        if(Securite::verifAccessSession()){
            $familles = $this->famillesManager->getFamilles();
            $continents = $this->continentsManager->getContinents();
            require_once "views/animalCreation.view.php";
        } else {
            throw new Exception("accès interdit");
        }
    }

    public function creationValidation()
    {
        if(Securite::verifAccessSession()){
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = "";
            if($_FILES['image']['size'] > 0){
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'], $repertoire);
            }
            $famille = (int)Securite::secureHTML($_POST['animal_famille']);
            $idAnimal = $this->animauxManager->createanimal($nom, $description, $image, $famille);
            if(!empty($_POST["continent_1"])){
                $this->continentsManager->addContinentAnimal($idAnimal, 1);
            }
            if(!empty($_POST['continent_2'])){
                $this->continentsManager->addContinentAnimal($idAnimal, 2);
            }
            if(!empty($_POST['continent_3'])){
                $this->continentsManager->addContinentAnimal($idAnimal, 3);
            }
            if(!empty($_POST['continent_4'])){
                $this->continentsManager->addContinentAnimal($idAnimal, 4);
            }
            if(!empty($_POST['continent_5'])){
                $this->continentsManager->addContinentAnimal($idAnimal, 5);
            } 
            $_SESSION['alert'] = [
                "message" => "L'animal id: ".$idAnimal.' a bien été crée',
                "type" => "alert-success"
            ];
            header('location: '.URL."back/animaux/visualisation");
        } else {
            throw new Exception("accès interdit");
        }
    }

    public function modification($idAnimal)
    {
        if(Securite::verifAccessSession()){
            $familles = $this->famillesManager->getFamilles();
            $continents = $this->continentsManager->getContinents();
            $lignesAnimal = $this->animauxManager->getAnimal((int)Securite::secureHTML($idAnimal));
            $tabContinents = [];
            foreach($lignesAnimal as $continent){
                $tabContinents[] = $continent['continent_id'];
            }
            $animal = array_slice($lignesAnimal[0],0,5);
            require_once "views/animalModification.view.php";
        }else{
            throw new Exception("accès interdit");
        }
    }

    public function modificationValidation()
    {
        if(Securite::verifAccessSession()){
            $idAnimal = Securite::secureHTML($_POST['animal_id']);
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image = $this->animauxManager->getImageAnimal($idAnimal);
            if($_FILES['image']['size'] > 0){
                unlink("public/images/".$image);
                $repertoire = "public/images/";
                $image = ajoutImage($_FILES['image'], $repertoire);
            }
            $famille = (int) Securite::secureHTML($_POST['famille_id']);

            $this->animauxManager->updateAnimal($idAnimal,$nom,$description,$image,$famille);

            $continents = [
                1 => !empty($_POST['continent-1']),
                2 => !empty($_POST['continent-2']),
                3 => !empty($_POST['continent-3']),
                4 => !empty($_POST['continent-4']),
                5 => !empty($_POST['continent-5'])
            ];

            foreach ($continents as $key => $continent) {
                //continent coché et non present en bdd
                if($continent && !$this->continentsManager->verificationExisteAnimalContinent($idAnimal, $key)){
                    $this->continentsManager->addContinentAnimal($idAnimal, $key);
                }

                //continent non coché et present en bdd
                if(!$continent && $this->continentsManager->verificationExisteAnimalContinent($idAnimal, $key)){
                    $this->continentsManager->deleteDBContinentAnimal($idAnimal, $key);
                }
            }

            $_SESSION['alert'] = [
                "message" => "L'animal id: ".$nom.' a bien été modifié',
                "type" => "alert-success"
            ];
            header('location: '.URL."back/animaux/visualisation");
        }else{
            throw new Exception("accès interdit");
        }
    }

    /* public function modificationValidation(){
        if(Securite::verifAccessSession()){
            $idAnimal = Securite::secureHTML($_POST['animal_id']);
            $nom = Securite::secureHTML($_POST['animal_nom']);
            $description = Securite::secureHTML($_POST['animal_description']);
            $image="";
            $famille = (int) Securite::secureHTML($_POST['famille_id']);

            $this->animauxManager->updateAnimal($idAnimal,$nom,$description,$image,$famille);
            
            $continents = [
                1 => !empty($_POST['continent-1']),
                2 => !empty($_POST['continent-2']),
                3 => !empty($_POST['continent-3']),
                4 => !empty($_POST['continent-4']),
                5 => !empty($_POST['continent-5']),
            ];

            $continentsManager = new ContinentsManager;

            foreach ($continents as $key => $continent) {
                //continent coché et non présent en BD
                if($continents[$key] && !$continentsManager->verificationExisteAnimalContinent($idAnimal,$key)){
                    $continentsManager->addContinentAnimal($idAnimal,$key);
                }

                //continent non coché et présent en BD
                if(!$continents[$key] && $continentsManager->verificationExisteAnimalContinent($idAnimal,$key)){
                    $continentsManager->deleteDBContinentAnimal($idAnimal,$key);
                }
            }

            $_SESSION['alert'] = [
                "message" => "L'animal a bien été modifié",
                "type" => "alert-success"
            ];
            header('Location: '.URL.'back/animaux/visualisation');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    } */
}