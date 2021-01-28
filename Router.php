<?php
class Router
{
    static public function parse()
    {
        $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : '/';

        if ($url == "/")
        {
            require_once ROOT_FOLDER . 'Controllers/HomeController.php';
            $homeController = new HomeController();

            $homeController->index(null);
            exit;
        }

        $requestedController = $url[0];

        // If a second part is added in the URI,
        // it should be a method
        $requestedAction = isset($url[1]) ? $url[1] : 'index';

        // The remain parts are considered as arguments of the method
        $requestedParams = array_slice($url, 2);

        // Check if controller exists:
        $ctrlPath = ROOT_FOLDER . 'Controllers/' . $requestedController . 'Controller.php';

        if (file_exists($ctrlPath)) {
            require_once ROOT_FOLDER . 'Controllers/' . $requestedController . 'Controller.php';

            $controllerName = ucfirst($requestedController) . 'Controller';

            $controllerObj = new $controllerName();

            if (method_exists($controllerObj, $requestedAction))
                $controllerObj->$requestedAction($requestedParams);
            else {
                header('HTTP/1.1 404 Not Found');

                die('404 - The method ' . $controllerName . '::' . $requestedAction . '()" was not found');
            }

        } else {
            header('HTTP/1.1 404 Not Found');
            die('404 - The file - ' . $ctrlPath . ' - not found');
            //require the 404 controller and initiate it
            //Display its view
        }

    }
}