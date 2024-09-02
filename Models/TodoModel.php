<?php
require "Model.php";

class TodoModel extends Model{
    public $table = "todo";
    public $columns = [
        "id",
        "title",
        "description",
        "status"
    ];
}