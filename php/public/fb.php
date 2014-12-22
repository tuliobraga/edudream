 <?php
       error_reporting(E_ALL);
     ini_set("display_errors", 1);
     require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/FacebookSDKException.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/FacebookSession.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/FacebookRequest.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/Entities/AccessToken.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/FacebookResponse.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/HttpClients/FacebookHttpable.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/HttpClients/FacebookCurl.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/HttpClients/FacebookCurlHttpClient.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/FacebookRequestException.php';
require_once dirname(__DIR__) . '/vendor/facebook/php-sdk-v4/src/Facebook/FacebookRedirectLoginHelper.php';
session_start();
\Facebook\FacebookSession::setDefaultApplication('1411744809117379', 'd4fa6295ed95a37967eccd8e47bd4618');
$helper = new \Facebook\FacebookRedirectLoginHelper('http://localhost:4567/edudream/php/public/fb.php');
try {
  $session = $helper->getSessionFromRedirect();
} catch(\Facebook\FacebookRequestException $ex) {
    throw $ex;
  // When Facebook returns an error
} catch(\Exception $ex) {
    throw $ex;
  // When validation fails or other local issues
}
if ($session) {
  echo 'autenticado';
}
 die;

 /**
  * Display all errors when APPLICATION_ENV is development.
  */
// if ($_SERVER['APPLICATION_ENV'] == 'development') {
     error_reporting(E_ALL);
     ini_set("display_errors", 1);
// }

 /**
  * This makes our life easier when dealing with paths. Everything is relative
  * to the application root now.
  */
 chdir(dirname(__DIR__));

 // Decline static file requests back to the PHP built-in webserver
 if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
     return false;
 }

 // Setup autoloading
 require 'init_autoloader.php';

 // Run the application!
 Zend\Mvc\Application::init(require 'config/application.config.php')->run();