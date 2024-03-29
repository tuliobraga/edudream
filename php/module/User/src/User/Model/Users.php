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
    public $facebookid;
    public $name;
    public $password;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->facebookid = (!empty($data['facebookid'])) ? $data['facebookid'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->role  = (!empty($data['role'])) ? $data['role'] : null;
        $this->lastaccess = (!empty($data['lastaccess'])) ? $data['lastaccess'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;;
    }

    public function isDreamer() {
        return $this->role === self::ROLE_SONHADOR;
    }

    public function isAngel() {
        return $this->role === self::ROLE_MENTOR;
    }
 }