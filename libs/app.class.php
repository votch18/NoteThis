<?php

class App
{

    protected static $router;
    public static $db;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {
        self::$router = new Router($uri);
        self::$db = new DB(Config::get('db_host'), Config::get('db_username'), Config::get('db_password'), Config::get('db_name'));

        $controller_class = ucfirst(self::$router->getController()) . 'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix() . self::$router->getAction());


        $layout = self::$router->getRoute();
        $action = strtolower(self::$router->getAction());
        $controller = strtolower(self::$router->getController());

        $email = Session::get('email');
		$access = !isset($email) ? (!isset($_COOKIE['email']) ? null : $_COOKIE['email']) : $email;

		
        if (!isset($access)) {
            //if not yet sign-in redirect to sign-in page...
            if ($layout != 'default') {
                if ($controller !== 'home' && $controller != 'signup'){
					Router::redirect('/');
				}
            }
        } else if (isset($access)) {
			
			//if cookie is found, renew cookie
			if(isset($_COOKIE['email'])) {
				Session::set('email', $_COOKIE['email']);
				setcookie('email', $_COOKIE['email'], time() + (31556926), "/");
			}
			
            //if sign-in dis-allow access to sign-in & sign-up page
            if ($controller == 'home' && $action == 'index') {
                //accessing sign-in page redirect to notes
                Router::redirect('/notes/');
            } else if ($controller == 'signup' && $action != 'success') {
                //accessing sign-up page redirect to notes
                Router::redirect('/notes/');
            }
        }

        $controller_object = new $controller_class();
        if (method_exists($controller_object, $controller_method)) {

            //check if params is greater than 5 limit of parameters within URL
            if (count(self::$router->getParams()) > 5) {
                Router::redirect('/');
            } else {
                $view_path = $controller_object->$controller_method();
                if ($layout == 'ajax') {
                    echo json_encode($controller_object->getData());
                } else if ($layout == 'uploads') {

                } else {
                    $view_object = new View($controller_object->getData(), $view_path);

                    //buffer data and html template
                    $content = $view_object->buffer();

                    $layout_path = VIEW_PATH . DS . $layout . '.php';
                    $view = new View($content);
                    $view->render($layout_path);
                }

            }

        } else {

            //header("HTTP/1.0 404 Not Found");
            Router::redirect("/home/page_not_found/");
            //throw new Exception ("Method: ".$controller_method." of class " .$controller_class." does not exist!");
        }
    }

}
