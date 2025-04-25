<?php


class App {

    public function start() {

    spl_autoload_register(function($class) {
        require($class . '.php');
    });

    $requestBuilderClass = "\\core\\http\\RequestBuilder";

    if(class_exists($requestBuilderClass)) {

        $requestBuilder = new $requestBuilderClass();
        $request = $requestBuilder->getRequest();

        echo "URL = ".$_GET['url'];

        $urlParams = $request->getParams();

        $resourceName = $urlParams[0];

        $controllerClass = substr(ucfirst($resourceName), 0, strlen($resourceName) - 1) . "Controller";

        $controllerClass = "controllers\\" . $controllerClass;

        if(class_exists($controllerClass)) {

            $controller = new $controllerClass();

            $requestMethod = $request->getMethod();

            echo $requestMethod;

            switch($requestMethod) {
                case "GET":
                    $controller->read();
                    break;
                case "POST":
                    $controller->create();
                    break;
                case "PUT":
                    $controller->update();
                    break;
                case "DELETE":
                    $controller->delete();
                    break;
                default:
                    break;
            }

        }
        else{
            echo "<br>";
            echo "Controller not found";
        }

    }
}
}

// Start the application
$app = new App();
$app->start();
