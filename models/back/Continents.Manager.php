<?php 

require_once "models/Model.php";

class ContinentsManager extends Model 
{
    public function getContinents()
    {
        $req = "Select * from continent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $continents;
    }

     public function addContinentAnimal($idAnimal, $idContinent)
    {
        $req = "Insert into animal_continent (animal_id, continent_id) 
        values (:idAnimal, :idContinent)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindvalue(':idAnimal', $idAnimal, PDO::PARAM_INT);
        $stmt->bindvalue(':idContinent', $idContinent, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    } 

    public function deleteDBContinentAnimal($idAnimal, $idContinent){
        $req = "DELETE from animal_continent WHERE animal_id = :idAnimal AND continent_id = :idContinent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindvalue(':idAnimal', $idAnimal, PDO::PARAM_INT);
        $stmt->bindvalue(':idContinent', $idContinent, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function verificationExisteAnimalContinent($idAnimal, $idContinent){
        $req = "SELECT count(*) as 'nb' 
        FROM animal_continent ac
        WHERE ac.animal_id = :idAnimal AND ac.continent_id = :idContinent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindvalue(':idAnimal', $idAnimal, PDO::PARAM_INT);
        $stmt->bindvalue(':idContinent', $idContinent, PDO::PARAM_INT);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if($resultat['nb'] >= 1) return true;
        return false;
    }

}