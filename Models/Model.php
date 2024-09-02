<?php
require "Core/DB.php";

abstract class Model{

    public $table;
    public $columns = [];

    public function save(){

        $columnsValues = $this->getValuesSetted();

        if(!isset($this->id)){
            $lastInsertedId = DB::table($this->table)->insert($columnsValues);
            $data = DB::table($this->table)->select($this->columns)->where("id","=",$lastInsertedId)->get();
            self::fillModel($this,$data[0]);
            return;
        }

        DB::table($this->table)->where("id","=",$this->id)->update($columnsValues);
        $data = DB::table($this->table)->select($this->columns)->where("id","=",$this->id)->get();
        self::fillModel($this,$data[0]);
    }

    public function delete(){
        if(isset($this->id)){
            $rowCount = DB::table($this->table)->where("id","=",$this->id)->delete();
            return;
        }
    }

    static function where($column,$comparator,$value){
        $modelClass = get_called_class();
        $modelInstance = new $modelClass;
        return DB::table($modelInstance->table)->select($modelInstance->columns)->where($column,$comparator,$value);
    }

    static public function find($id){

        $modelClass = get_called_class();
        $modelInstance = new $modelClass;
        
        $table = $modelInstance->table;

        $results = DB::table($table)->select($modelInstance->columns)->where("id","=",$id)->get();

        if(sizeof($results) === 0){
            return null;
        }

        $result = $results[0];
       
        self::fillModel($modelInstance,$result);

        return $modelInstance;
    }

    static function all() {
        $modelClass = get_called_class();
        $tempModelInstance = new $modelClass;
        $table = $tempModelInstance->table;
        
        $results = DB::table($table)->select($tempModelInstance->columns)->get();

        return array_map(function($row) use ($modelClass){
            $newModelInstance = new $modelClass;
            self::fillModel($newModelInstance,$row);
            return $newModelInstance;
        },$results);
    }

    private static function fillModel($model,$data) {
        foreach ($data as $column => $value) {              
            $model->$column = $value;
        }
    }

    public function getValuesSetted(){
        $columnsValues = [];
        foreach ($this->columns as $column) {
            if(property_exists($this,$column)){
                $columnsValues[$column] = $this->$column;
            }
        }

        return $columnsValues;
    }

}