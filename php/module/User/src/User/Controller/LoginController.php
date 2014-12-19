<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function facebookAction() {
        $code = $this->params()->fromQuery('code');
        $state = $this->params()->fromQuery('state');
        $redirectUrl = $this->url()->fromRoute('home');
        session_start();
        \Facebook\FacebookSession::setDefaultApplication('1410290089262851', '71144b560323842d1a6fffeb9cbec9e7');
        if($code === null) {
            $helper = new \Facebook\FacebookRedirectLoginHelper('http://104.236.104.98/'.$redirectUrl.'login/facebook');
            $loginUrl = $helper->getLoginUrl();
            $this->redirect()->toUrl($loginUrl);
        } else {
            $helper = new \Facebook\FacebookRedirectLoginHelper();
            $session = $helper->getSessionFromRedirect();
            var_dump($session);die;
        }
    }

}
