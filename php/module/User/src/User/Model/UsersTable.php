<?php
namespace User\Model;

 use Zend\Db\TableGateway\TableGateway;

 class UsersTable
 {
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

     public function saveUser(Users $user)
     {
        $data = array(
            'email' => $user->email,
            'role'  => $user->role,
            'lastaccess'  => $user->lastaccess,
        );

        $id = (int) $user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('User id does not exist');
            }
        }
     }

    public function insertUser(Users $user, $password = null)
    {
        $data = array(
            'email' => $user->email,
            'role'  => $user->role,
            'lastaccess'  => date('m/d/Y'),
            'password' => $password,
            'name' => $user->name,
            'facebookId' => $user->facebookId,
        );

        $this->tableGateway->insert($data);
        $user->id = $this->tableGateway->lastInsertValue;
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
 }