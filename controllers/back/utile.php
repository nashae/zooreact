<?php 

function ajoutImage($file, $dir)
{
    if(!isset($file['name']) || empty($file['name'])) throw new Exception("vous devez indiquer une image");
    if(!file_exists($dir)) mkdir($dir, 0777);
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $random = rand(0,99999);
    $target_file = $dir.$random."_".$file['name'];

    if(!getimagesize($file["tmp_name"]))
        throw new Exception("le fichier n'est pas une image");
    if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png")
        throw new Exception("l'extension du fichier n'est pas reconnue");
    if(file_exists($target_file))
        throw new Exception("le fichier existe déjà");
    if($file['size'] > 500000)
        throw new Exception("le fichier est trop volumineux");
    if(!move_uploaded_file($file['tmp_name'], $target_file))
        throw new Exception("l'ajout de l'image n'a pas fonctionné");
    else return ($random."_".$file['name']);
    
}