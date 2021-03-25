<?php 

require_once "models/front/API.manager.php";
require_once "models/Model.php";

class APIController {

    private $apiManager;

    public function __construct()
    {
        $this->apiManager = new APIManager();
    }

    public function getAnimaux($idFamille, $idContinent){
        $animaux = $this->apiManager->getDBAnimaux($idFamille, $idContinent);
        Model::sendJSON($this->formatDataLignesAnimaux($animaux));
    }

    public function getAnimal($idAnimal){
        $lignesAnimal = $this->apiManager->getDBAnimal($idAnimal);
        Model::sendJSON($this->formatDataLignesAnimaux($lignesAnimal));
    }

    private function formatDataLignesAnimaux($lignes){
        $tab = [];
        foreach($lignes as $ligne){
            if(!array_key_exists($ligne['animal_id'],$tab)){
                $tab[$ligne['animal_id']] = [
                    "id" => $ligne['animal_id'],
                    "nom" => $ligne['animal_nom'],
                    "description" => $ligne['animal_description'],
                    "image" => URL."public/images/".$ligne['animal_image'],
                    "famille" => [
                        "idFamille" => $ligne['famille_id'],
                        "libelleFamille" => $ligne['famille_libelle'],
                        "descriptionFamille" => $ligne['famille_description']
                    ]
                ];
            }
            $tab[$ligne['animal_id']]['continents'][] = [
                "idContinent" => $ligne["continent_id"],
                "libelleContinent" => $ligne['continent_libelle']
            ];
        }
        return $tab;
        /*
        [animal_id] => 1
            [animal_nom] => Chien
            [animal_description] => Un animal domestique
            [animal_image] => chien.png
            [famille_id] => 1
            [famille_libelle] => mammifères
            [famille_description] => animaux vertébrés nourrissant leurs petits avec du lait
            [continent_id] => 1
            [continent_libelle] => Europe
        */

    }

    public function getContinents(){
        $continents = $this->apiManager->getDBContinents();
        Model::sendJSON($continents);

    }

    public function getFamilles(){
        $familles = $this->apiManager->getDBFamilles();
        Model::sendJSON($familles);
    }

    public function sendMessage(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding");
        header("Content-Type: application/json");

        $obj = json_decode(file_get_contents('php://input'));
        
        /* $to = "contact@test.test";
        $subject = "message du site reactzoo de ".$obj->nom;
        $message = $obj->contenu;
        $headers = "From : ".$obj->email;
        mail($to, $subject, $message, $headers); */
        
        $messageRetour = [
            'from' => $obj->email,
            'to' => "contact@test.test"
        ];
        echo json_encode($messageRetour);
    }
}