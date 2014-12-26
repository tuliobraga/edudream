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
        // verify if input is a valid role
        if(isset($_GET['role']) && in_array($_GET['role'], array('S', 'M', 'O'))) {
            $_SESSION['role'] = $_GET['role'];
            $baseUrl = $this->getRequest()->getBaseUrl();
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $baseUrl . '/login/facebook';
            \Facebook\FacebookSession::setDefaultApplication('1410290089262851', '71144b560323842d1a6fffeb9cbec9e7');
            $helper = new \Facebook\FacebookRedirectLoginHelper($url);
            $loginUrl = $helper->getLoginUrl();
            $this->redirect()->toUrl($loginUrl);;
        } else {
            $viewModel = new ViewModel();
            return $viewModel;
        }
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

            $facebookid = $graphObject->getProperty('id');
            $data = array(
                'name' =>  $graphObject->getProperty('name'),
                'facebookid' => $facebookid,
                'role' => $_SESSION['role'],
            );
            
            $usersTable = $this->getUsersTable();
            $user = $usersTable->getUserByFacebookId($facebookid);

            if(!$user) {
                $user = new \User\Model\Users();
                $user->exchangeArray($data);

                $usersTable = $this->getUsersTable();
                $r = $usersTable->insertUser($user);
            }

            $container = new \Zend\Session\Container('login');
            $container->user = $user;

            if($user->isDreamer()) {
                $this->redirect()->toRoute('dream');
            } else if ($user->isAngel()) {
                $this->redirect()->toRoute('angel');
            }
        } else {
            throw new \Exception("Could not request a facebook session.");
        }
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
