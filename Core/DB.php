<?php
require "config.php";

class DB{
    private $dbConnection;
    private $table;
    private $query;
    private $values = [];
    private $lastInstruction = "";
    
    private function __construct($table) {
        $this->table = $table;
        $this->dbConnection = new PDO("mysql:host=$GLOBALS[DB_HOST];dbname=$GLOBALS[DB_DATABASE_NAME]",$GLOBALS["DB_USER"],$GLOBALS["DB_PASSWORD"],[
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_SILENT
        ]);
    }

    static function table($table) {
        $queryBuilder = new DB($table);
        return $queryBuilder;
    }

    public function getQuery() {
        return $this->query;
    }

    private function reset() {
        $this->query = "";
        $this->values = [];
    }

    function insert($dictColumnsValues) {

        $columns = array_keys($dictColumnsValues);
        $values = array_values($dictColumnsValues);

        $columnsToInsert = $this->joinArrayColumns($columns);
        $placeholdersValues = $this->generatePositionalPlaceholders($values);

        $this->query = "INSERT INTO $this->table ($columnsToInsert) VALUES ($placeholdersValues)";

        $statement = $this->dbConnection->prepare($this->query);
        $statement->execute($values);

        $id = $this->dbConnection->lastInsertId();

        $this->lastInstruction = "insert";

        return $id;
    }

    function select($columns=["*"]) {
        $columnsToSelect = $this->joinArrayColumns($columns);
        $this->query = "SELECT $columnsToSelect from $this->table";

        $this->lastInstruction = "select";

        return $this;
    }

    function where($column,$comparator,$value) {

        if($this->lastInstruction === "where"){
            $this->query.=" AND $column $comparator ?";
        }
        else{
            $this->query.=" WHERE $column $comparator ?";
        }

        $this->values[] = $value;

        $this->lastInstruction = "where";

        return $this;
    }

    function update($dictColumnsValues) {
        
        $columns = array_keys($dictColumnsValues);
        $values = array_values($dictColumnsValues);

        $columnsToUpdate= $this->generateSetColumnValues($columns);

        if($this->lastInstruction === "where"){
            $this->query = "UPDATE $this->table SET $columnsToUpdate " . $this->query;
            $this->values = array_merge($values,$this->values);
        }
        else{
            $this->query = "UPDATE $this->table SET $columnsToUpdate";
            $this->values = $values;    
        }

        $this->lastInstruction = "update";

        $statement = $this->dbConnection->prepare($this->query);
        $statement->execute($this->values);

        return $statement->rowCount();
    }

    function delete() {

        if($this->lastInstruction === "where"){
            $this->query = "DELETE FROM $this->table " . $this->query;
        }
        else{
            $this->query = "DELETE FROM $this->table";
        }
        

        $this->lastInstruction = "delete";

        $statement = $this->dbConnection->prepare($this->query);
        $statement->execute($this->values);

        return $statement->rowCount();
    }

    function get(){
        $statement = $this->dbConnection->prepare($this->query);
        $statement->execute($this->values);
        return $statement->fetchAll();
    }

    private function generatePositionalPlaceholders($arrayValues) {
        $arrayPlaceholders = array_map(function($value) {
            return "?";
        },$arrayValues);

        return implode(",",$arrayPlaceholders);
    }

    private function joinArrayColumns($arrayColumns){
        return implode(",",$arrayColumns);
    }

    private function generateSetColumnValues($arrayColumns) {
        $setValues = array_map(function ($column){
            return "$column = ?";
        },$arrayColumns);

        return implode(",",$setValues);

    }
}





$todos = DB::table('todo')->select()->get();