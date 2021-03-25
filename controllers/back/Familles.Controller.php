<?php 

require_once "controllers/back/Securite.Class.php";
require_once "models/back/Familles.manager.php";

class FamillesController 
{
    private $famillesManager;
    
    public function __construct()
    {
        $this->famillesManager = new FamillesManager();
    }

    public function visualisation()
    {
        if(Securite::verifAccessSession()){
            $familles = $this->famillesManager->getFamilles();
            require_once "views/famillesVisualisation.view.php";
        } else {
            throw new Exception("vous n'avez pas acces à cette page");
        }
    }

    public function suppression()
    {
        if(Securite::verifAccessSession()){
            $idFamille = (int)Securite::secureHTML($_POST['famille_id']);
            if($this->famillesManager->compterAnimaux($idFamille) > 0){
                $_SESSION['alert'] = [
                    "message" => "La famille n'a pas été supprimé",
                    "type" => "alert-danger"
                ];
            } else {
                $this->famillesManager->deleteDBFamille($idFamille);
                $_SESSION['alert'] = [
                    "message" => 'La famille est supprimée',
                    "type" => "alert-success"
                ];
            }
            header('location: '.URL."back/familles/visualisation");
        } else {
            throw new Exception("vous n'avez pas le droit de faire cette action");
        }
    }

    public function modification()
    {
        if(Securite::verifAccessSession()){
            $idFamille = (int)Securite::secureHTML($_POST['famille_id']);
            $libelle = Securite::secureHTML($_POST['famille_libelle']);
            $description = Securite::secureHTML($_POST['famille_description']);
            $this->famillesManager->updateFamille($idFamille, $libelle, $description);
            $_SESSION['alert'] = [
                "message" => 'La famille a bien été modifiée',
                "type" => "alert-success"
            ];
            header('location: '.URL."back/familles/visualisation");
        } else {
            throw new Exception("vous n'avez pas accès à cette fonction");
        }
    }

    public function creationTemplate()
    {
        if(Securite::verifAccessSession()){
            require_once "views/familleCreation.view.php";
        } else {
            throw new Exception("accès interdit");
        }
    }

    public function creationValidation()
    {
        if(Securite::verifAccessSession()){
            $libelle = Securite::secureHTML($_POST['famille_libelle']);
            $description = Securite::secureHTML($_POST['famille_description']);
            $idFamille = $this->famillesManager->createFamille($libelle, $description);
            $_SESSION['alert'] = [
                "message" => 'La famille '.$idFamille.'-'.$libelle.' a bien été crée',
                "type" => "alert-success"
            ];
            header('location: '.URL."back/familles/visualisation");
        } else {
            throw new Exception("accès interdit");
        }
    }
}