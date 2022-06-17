<?php
require_once "../Inventor.php";
require_once "../Invention.php";
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        header("HTTP/1.1 201 OK");
        $data = json_decode(file_get_contents('php://input'), true);
        if($data['description']){
            $inventor = new Inventor();
            $inventor->setName($data['name']);
            $inventor->setSurname($data['surname']);
            $inventor->setDescription($data['description']);
            $inventor->setBirthDate($data["birth_date"]);
            $inventor->setBirthPlace($data["birth_place"]);
            $inventor->setDeathPlace($data["death_place"]);
            $inventor->setDeathDate($data["death_date"]);
            $inventor->save();
            $invention=new Invention();
            $invention->setDescription($data["inventionDescription"]);
            $invention->setInventionDate($data["inventionYear"]);
            $invention->setInventorId($inventor->getId());
            $invention->save();
        }
        else if($data['inventorId']){
            $invention=new Invention();
            $invention->setDescription($data["inventionDescription"]);
            $invention->setInventionDate($data["inventionYear"]);
            $invention->setInventorId($data["inventorId"]);
            $invention->save();
        }
        break;
    case "PATCH":
        header("HTTP/1.1 202 Accepted");
        $data = json_decode(file_get_contents('php://input'), true);
        Inventor::updateInventor($data["id"],$data["name"], $data["surname"],$data["birthPlace"],$data["birthDate"], $data["description"], $data["deathDate"], $data["deathPlace"]);
        break;
    case "DELETE":
        header("HTTP/1.1 204");
        $id = $_GET['Id'];
        Inventor::findInventor($id)->destroy();
        break;
    case "GET":
        header("HTTP/1.1 200 OK");
        $name = $_GET['Name'];
        $id=$_GET['Id'];
        if($name){
            echo json_encode(Inventor::findBySurname($name));
        }
        else if($id){
            echo json_encode(Inventor::findWithInventions($id));
        }
        else {
            echo json_encode(Inventor::all());
        }
        break;
}



