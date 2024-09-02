<?php

function getTodoStatus($todo) {
    $status = "";
    if($todo->status === "PENDING"){
        $status = "Pending";
    }
    if($todo->status === "IN_PROGRESS"){
        $status = "In Progress";
    }
    if($todo->status === "DONE"){
        $status = "Done";
    }

    return $status;
}

function getClassNameStatus($todo) {
    $className = "";
    if($todo->status === "PENDING"){
        $className = "todo-status-pending";
    }
    if($todo->status === "IN_PROGRESS"){
        $className = "todo-status-progress";
    }
    if($todo->status === "DONE"){
        $className = "todo-status-done";
    }

    return $className;
}