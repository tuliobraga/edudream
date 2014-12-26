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
            $password = $this->getRequest()->getPost('password');
            $data = array(
                'email' => $this->getRequest()->getPost('email'),
                'password' => $this->getRequest()->getPost('password'),
                'role' => $this->getRequest()->getPost('role')
            );

            $user = new \User\Model\Users();
            $user->exchangeArray($data);

            $userTable = $this->getUsersTable();
            $userTable->insertUser($user, $password);
            
            // init session
            
            $this->redirect()->toRoute("home");
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
