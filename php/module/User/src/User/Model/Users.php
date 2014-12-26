<?php 
namespace User\Model;

 class Users
 {

    const ROLE_SONHADOR = 'S';
    const ROLE_ORGANIZACAO = 'O';
    const ROLE_MENTOR = 'M';
  
    public $id;
    public $email;
    public $role;
    public $lastaccess;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->role  = (!empty($data['role'])) ? $data['role'] : null;
        $this->lastaccess = (!empty($data['lastaccess'])) ? $data['lastaccess'] : null;;
    }
 }