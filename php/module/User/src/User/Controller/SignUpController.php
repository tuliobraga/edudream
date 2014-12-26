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

            $user = new \User\Model\User();
            $user->exchangeArray($data);

            $userTable = $this->getUserTable();
            $userTable->insertUser($user, $password);
            $this->redirect()->toRoute("/home");
        }

        return new ViewModel();
    }

    /**
     * 
     * @return \User\Model\UserTable
     */
    public function getUserTable()
     {
         if (!$this->userTable) {
             $sm = $this->getServiceLocator();
             $this->userTable = $sm->get('User\Model\UserTable');
         }
         return $this->userTable;
     }
    
}
