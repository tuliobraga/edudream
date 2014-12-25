<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        \Facebook\FacebookSession::setDefaultApplication('1411744809117379', 'd4fa6295ed95a37967eccd8e47bd4618');
        $helper = new \Facebook\FacebookRedirectLoginHelper('http://localhost:4567/edudream/php/public/login/facebook');
        $loginUrl = $helper->getLoginUrl();
        $viewModel = new ViewModel();
        $viewModel->setVariable('loginUrl', $loginUrl);
        return $viewModel;
    }

    public function facebookAction() {
        \Facebook\FacebookSession::setDefaultApplication('1411744809117379', 'd4fa6295ed95a37967eccd8e47bd4618');
        $helper = new \Facebook\FacebookRedirectLoginHelper('http://localhost:4567/edudream/php/public/login/facebook');
        
        try {
            $session = $helper->getSessionFromRedirect();
        } catch(\Facebook\FacebookRequestException $ex) {
            // When Facebook returns an error
            throw $ex;
        } catch(\Exception $ex) {
            // When validation fails or other local issues
            throw $ex;
        }

        if ($session) {
            $request = new \Facebook\FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
            $graphObject = $response->getGraphObject();
            var_dump($graphObject);
        }

        die;
        $viewModel = new ViewModel();
        return $viewModel;
    }

}
