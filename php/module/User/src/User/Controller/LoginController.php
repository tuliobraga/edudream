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
        if($code === null) {
            session_start();
            \Facebook\FacebookSession::setDefaultApplication('1410290089262851', '71144b560323842d1a6fffeb9cbec9e7');

            $redirectUrl = $this->url()->fromRoute('home');
            $helper = new \Facebook\FacebookRedirectLoginHelper('http://104.236.104.98/'.$redirectUrl.'login/facebook');
            $loginUrl = $helper->getLoginUrl();
            $this->redirect()->toUrl($loginUrl);
        } else {
            $session = $helper->getSessionFromRedirect();
            var_dump($code);
            var_dump($session);die;
        }
    }

}
