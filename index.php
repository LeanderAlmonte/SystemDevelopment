<?php
session_start();

// Include Composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// echo "Session Status:<br>";
// echo "Session ID: " . session_id() . "<br>";
// echo "Session Name: " . session_name() . "<br>";
// echo "Session Variables: <pre>";
// print_r($_SESSION);
// echo "</pre><br>";

class App {
    private $publicRoutes = ['auths/login', 'auths/logout', 'auths/verify2fa'];

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
                echo "URL = ".$_GET['url'] . "<br>";
                
                $urlParams = $request->getParams();
                $currentRoute = implode('/', $urlParams);

                // Redirect logged-in users away from login page
                if ($currentRoute === 'auths/login' && isset($_SESSION['userID'])) {
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                    exit();
                }

                // Check if user is authenticated for protected routes
                if (!in_array($currentRoute, $this->publicRoutes) && !isset($_SESSION['userID'])) {
                    echo "No session found, redirecting to login...<br>";
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
                    exit();
                }

                $resourceName = $urlParams[0];
                $action = $urlParams[1] ?? '';

                $controllerClass = substr(ucfirst($resourceName), 0, strlen($resourceName) - 1) . "Controller";
                $controllerClass = "Controllers\\" . $controllerClass;

                if(class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    $requestMethod = $request->getMethod();

                    // Handle specific actions first
                    if ($action === 'login') {
                        $controller->login();
                        return;
                    }

                    if ($action === 'verify2fa') {
                        $controller->verify2FA();
                        return;
                    }

                    if ($action === 'logout') {
                        $controller->logout();
                        return;
                    }

                    if ($action === 'archive') {
                        $controller->archive();
                        return;
                    }

                    if ($action === 'unarchive') {
                        $controller->unarchive();
                        return;
                    }

                    if ($action === 'manual') {
                        $controller->manual();
                        return;
                    }

                    if ($action === 'soldProducts') {
                        $controller->soldProducts();
                        return;
                    }

                    if ($action === 'processOrder') {
                        $controller->processOrder();
                        return;
                    }

                    if ($action === 'salesCosts') {
                        $controller->salesCosts();
                        return;
                    }

                    if ($action === 'enable2fa') {
                        $controller->enable2FA();
                        return;
                    }

                    if ($action === 'disable2fa') {
                        $controller->disable2FA();
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
