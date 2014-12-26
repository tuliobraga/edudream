<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    protected $usersTable;
    //1410290089262851 production
    // 71144b560323842d1a6fffeb9cbec9e7
    public function indexAction()
    {
        $baseUrl = $this->getRequest()->getBaseUrl();
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $baseUrl . '/login/facebook';
        \Facebook\FacebookSession::setDefaultApplication('1410290089262851', '71144b560323842d1a6fffeb9cbec9e7');
        $helper = new \Facebook\FacebookRedirectLoginHelper($url);
        $loginUrl = $helper->getLoginUrl();
        $viewModel = new ViewModel();
        $viewModel->setVariable('loginUrl', $loginUrl);
        return $viewModel;
    }

    public function facebookAction() {
        $baseUrl = $this->getRequest()->getBaseUrl();
        \Facebook\FacebookSession::setDefaultApplication('1410290089262851', '71144b560323842d1a6fffeb9cbec9e7');
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $baseUrl . '/login/facebook';
        $helper = new \Facebook\FacebookRedirectLoginHelper($url);
        
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
            $graphObject = $response->getGraphObject(\Facebook\GraphUser::className());

            $data = array(
                'name' =>  $graphObject->getProperty('name'),
                'facebookId' => $graphObject->getProperty('id'),
                'role' => 'S',
            );

            $user = new \User\Model\Users();
            $user->exchangeArray($data);

            $usersTable = $this->getUsersTable();
            $r = $usersTable->insertUser($user);
        }

        die;
        $viewModel = new ViewModel();
        return $viewModel;
        
        \Facebook\FacebookSession::setDefaultApplication('1411744809117379', 'd4fa6295ed95a37967eccd8e47bd4618');
        $helper = new \Facebook\FacebookRedirectLoginHelper('http://localhost:4567/edudream/php/public/login/process');
        $url = $helper->getLoginUrl();
        $this->redirect()->toUrl($url);
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function processAction() {
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
            var_dump($graphObject);die;
            $data = array(
                'email' => $graphObject->email,
                'facebookId' => $graphObject->id,
                'role' => 'S',
                'password' => '*'
            );

            $user = new \User\Model\Users();
            $user->exchangeArray($data);
            $usersTable = $this->getUsersTable();
            $usersTable->insertUser($user, $password);
            var_dump($data);die;

            
        }

        die;
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     * 
     * @return \User\Model\UsersTable
     */
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('User\Model\UsersTable');
        }
        return $this->usersTable;
    }

}
