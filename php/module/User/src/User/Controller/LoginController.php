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
        session_start();
        \Facebook\FacebookSession::setDefaultApplication('1410290089262851', '71144b560323842d1a6fffeb9cbec9e7');

        $redirectUrl = $this->url('/');
        $helper = new \Facebook\FacebookRedirectLoginHelper($redirectUrl);
        $loginUrl = $helper->getLoginUrl();
    }

}
