<?php

require "Models/TodoModel.php";

class TodoController{

    static function index() {
        $todos = TodoModel::all();
        include('Views/index.php');
    }
    
    static function create() {
        include('Views/createTodo.php');
    }

    static function save() {
       
        if(empty($_POST["title"]) 
            || empty($_POST["description"])
        ){
            header("location:/create?error=fieldsarerequired");
            return;
        }
 
        $todo = new TodoModel;
        $todo->title = htmlentities($_POST["title"],ENT_QUOTES|ENT_HTML5, "UTF-8", true);
        $todo->description = htmlentities($_POST["description"],ENT_QUOTES|ENT_HTML5, "UTF-8", true);
        $todo->status = "PENDING";

        $todo->save();

        header("location:/");
    }
    
    static function edit() {
        if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
            echo "<h1>Invalid Parameter</h1>";
            return;
        }

        $todo = TodoModel::find($_GET["id"]);

        if(is_null($todo)){
            echo "<h1>Not found</h1>";
            return;
        }



        include('Views/editTodo.php');
    }

    static function update() {

        if(empty($_POST["id"]) || !is_numeric($_POST["id"])){
            echo "<h1>Invalid Parameter</h1>";
            return;
        }

        if(empty($_POST["title"]) 
            || empty($_POST["description"])
            || empty($_POST["status"])
        ){
            header("location:/edit?error=fieldsarerequired");
            return;
        }

        $todo = TodoModel::find($_POST["id"]);

        if(is_null($todo)){
            echo "<h1>Not found</h1>";
            return;
        }

        $statutes = ["PENDING","IN_PROGRESS","DONE"];

        if(!in_array($todo->status,$statutes)){
            echo "<h1>Invalid Parameter</h1>";
        }

        $todo->title = htmlentities($_POST["title"],ENT_QUOTES|ENT_HTML5, "UTF-8", true);
        $todo->description = htmlentities($_POST["description"],ENT_QUOTES|ENT_HTML5, "UTF-8", true);
        $todo->status = $_POST["status"];
        

        $todo->save();

        header("location:/");
    }
    
    static function delete() {
        if(empty($_POST["id"]) || !is_numeric($_POST["id"])){
            echo "<h1>Invalid Parameter</h1>";
            return;
        }

        $todo = TodoModel::find($_POST["id"]);

        if(is_null($todo)){
            echo "<h1>Not found</h1>";
            return;
        }

        $todo->delete();

        header("location:/");

    }    
}
