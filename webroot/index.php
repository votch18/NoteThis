<<<<<<< HEAD
<?phpdefine("DS", DIRECTORY_SEPARATOR);define("ROOT", dirname(dirname(__FILE__)));define("VIEW_PATH", ROOT . DS . 'views');require_once(ROOT . DS . 'libs' . DS . 'init.php');header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");header("Cache-Control: post-check=0, pre-check=0", false);header("Pragma: no-cache");session_start();//error_reporting(E_ALL);App::run($_SERVER['REQUEST_URI']);
=======
<?php

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(dirname(__FILE__)));
define("VIEW_PATH", ROOT.DS.'views');

require_once(ROOT.DS.'libs'.DS.'init.php');

session_start();

App::run($_SERVER['REQUEST_URI']);
>>>>>>> 4f74314149a233f04baf993f8456f72ae35eefce
