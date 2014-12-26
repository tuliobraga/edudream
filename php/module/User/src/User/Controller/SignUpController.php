<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SignUpController extends AbstractActionController
{
    protected $userTable;

    public function indexAction()
    {
        if($this->getRequest()->isPost()) {
            /** @todo filter form inputs */
            $name = $this->getRequest()->getPost('name');
            $email = $this->getRequest()->getPost('email');
            $password = md5($this->getRequest()->getPost('password'));
            $role = $this->getRequest()->getPost('role');
            
            if(!$name)
                throw new \Exception('Campo Nome é obrigatório!');
            if(!$email)
                throw new \Exception('Campo Email é obrigatório!');
            if(!$password)
                throw new \Exception('Campo Password é obrigatório!');
            if(!$role)
                throw new \Exception('Campo Role é obrigatório!');
            
            $data = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role
            );

            $user = new \User\Model\Users();
            $user->exchangeArray($data);

            $userTable = $this->getUsersTable();
            $userTable->insertUser($user, $password);
            
            // init session
            
            $container = new \Zend\Session\Container('login');
            $container->user = $user;

            if($user->isDreamer()) {
                $this->redirect()->toRoute('dream');
            } else if ($user->isAngel()) {
                $this->redirect()->toRoute('angel');
            }
        }

        return new ViewModel();
    }

    /**
     * 
     * @return \User\Model\UsersTable
     */
    public function getUsersTable()
     {
         if (!$this->userTable) {
             $sm = $this->getServiceLocator();
             $this->userTable = $sm->get('User\Model\UsersTable');
         }
         return $this->userTable;
     }
    
}
