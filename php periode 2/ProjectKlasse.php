<?php
class Project {
    public $title;
    public $description;
    public $category;

    
    public function sayHello() {
        return "<br> title: " . $this->title . 
               "<br> description: " . $this->description . 
               "<br> category: " . $this->category;
    }
}

$project1 = new Project();
$project1->title = "Mijn Project";
$project1->description = "Dit is een project ";
$project1->category = "Categorie 1";

$project2 = new Project();
$project2->title = "sinterklaasje";
$project2->description = "Dit is een project ";
$project2->category = "Categorie 2";

echo $project1->sayHello();
echo "<br>";
echo $project2->sayHello();

?>