<?php

class Router{

    private static $path;
    private static $method;

    static function GET($path,$controller) {
        if(self::$path !== $path){
            return;     
        }

        $controllerClass = $controller[0];
        $controllerMethod = $controller[1];

        $controllerClass::$controllerMethod();       
    }

    static function POST($path,$controller) {
        if(self::$path === $path && self::$method == "POST"){
            $controllerClass = $controller[0];
            $controllerMethod = $controller[1];

            $controllerClass::$controllerMethod();
        }
    }


    static function getRequest() {
        $requestUri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];
        $urlParsed = parse_url($requestUri);
        $path = $urlParsed["path"];

        return [
            "path"=>$path,
            "method"=>$method
        ];
    }

    static function init() {
        $requestInfo = self::getRequest();

        self::$path = $requestInfo["path"];
        self::$method = $requestInfo["method"];
    }
}