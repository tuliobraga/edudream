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
            if(isset($_GET['message'])) {
                $viewModel->setVariable('message', $_GET['message']);
            }
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
            $this->redirect()->toRoute('dream');
        } else {
            throw new \Exception("Could not request a facebook session.");
        }
    }

    public function execAction() {
        if($this->getRequest()->isPost()) {
            /** @todo filter form inputs */
            $email = $this->getRequest()->getPost('email');
            $password = md5($this->getRequest()->getPost('password'));
            
            try {
                if(!$email)
                    throw new \Exception('Campo Nome é obrigatório!');
                if(!$password)
                    throw new \Exception('Campo Email é obrigatório!');
            } catch (\Exception $e) {
                $this->redirect()->toRoute('login', array('message' => $e->getMessage()));
            }
            
            $usersTable = $this->getUsersTable();
            $user = $usersTable->getUserByLogin($email, $password);
            if($user) {
                $container = new \Zend\Session\Container('login');
                $container->user = $user;

                if($user->isDreamer()) {
                    $this->redirect()->toRoute('dream');
                } else if ($user->isAngel()) {
                    $this->redirect()->toRoute('angel');
                }
                $this->redirect()->toRoute('dream');
            } else {
                $this->redirect()->toRoute('login', array('message' => 'Email ou senha inválidos.'));
            }
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
