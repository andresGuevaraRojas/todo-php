<?php
require "Controllers/TodoController.php";
require "Core/Router.php";

Router::init();

Router::GET("/",[TodoController::class,"index"]);
Router::GET("/create",[TodoController::class,"create"]);
Router::POST("/save",[TodoController::class,"save"]);
Router::GET("/edit",[TodoController::class,"edit"]);
Router::POST("/update",[TodoController::class,"update"]);
Router::POST("/delete",[TodoController::class,"delete"]);