<?php
class Project {
    public $title;
    public $description;
    private $category;

    public function __construct($title, $description, $category) {
        $this->title       = $title;
        $this->description = $description;
        $this->category    = $category;
    }

    public function getCategory() {
        return $this->category;
    }
}

$project1 = new Project(
    "My Project",
    "This is a description of my project.",
    "Web Development"
);

// Titel
echo $project1->title . "<br>";

// Categorie via getter
echo $project1->getCategory();
?>
