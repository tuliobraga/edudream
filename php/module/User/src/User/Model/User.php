<?php 
namespace User\Model;

 class User
 {

    const ROLE_SONHADOR = 'S';
    const ROLE_ORGANIZACAO = 'O';
    const ROLE_MENTOR = 'M';
  
    public $id;
    public $email;
    public $role;
    public $lastAccess;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->role  = (!empty($data['role'])) ? $data['role'] : null;
        $this->lastAccess = (!empty($data['role'])) ? $data['role'] : null;;
    }
 }