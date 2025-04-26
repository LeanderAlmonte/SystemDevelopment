<?php


class App {

    public function start() {
        spl_autoload_register(function($class) {
            // Convert namespace separators to directory separators
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            // Ensure first character of each namespace segment is uppercase
            $file = implode(DIRECTORY_SEPARATOR, array_map('ucfirst', explode(DIRECTORY_SEPARATOR, $file)));
            $file .= '.php';
            
            if (file_exists($file)) {
                require $file;
            }
        });

        $requestBuilderClass = "Core\\Http\\RequestBuilder";

        if(class_exists($requestBuilderClass)) {
            $requestBuilder = new $requestBuilderClass();
            $request = $requestBuilder->getRequest();

            if (isset($_GET['url'])) {
                echo "URL = ".$_GET['url'];

                $urlParams = $request->getParams();

                $resourceName = $urlParams[0];
                $action = $urlParams[1] ?? '';

                $controllerClass = substr(ucfirst($resourceName), 0, strlen($resourceName) - 1) . "Controller";
                $controllerClass = "Controllers\\" . $controllerClass;

                if(class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    $requestMethod = $request->getMethod();

                    echo $requestMethod;

                    // Handle specific actions first
                    if ($action === 'archive') {
                        $controller->archive();
                        return;
                    }

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
                } else {
                    echo "<br>";
                    echo "Controller not found";
                }
            } else {
                // Redirect to default route if no URL parameter
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
                exit();
            }
        }
    }
}

// Start the application
$app = new App();
$app->start();
