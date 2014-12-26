<?php
namespace User\Model;

 use Zend\Db\TableGateway\TableGateway;

 class UserTable
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

     public function saveUser(User $user)
     {
        $data = array(
            'email' => $user->email,
            'role'  => $user->role,
            'lastAccess'  => $user->lastAccess,
        );

        $id = (int) $user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
     }

    public function insertUser(User $user, $password)
    {
        $data = array(
            'email' => $user->email,
            'role'  => $user->role,
            'lastAccess'  => $user->lastAccess,
            'password' => $password
        );

        $this->tableGateway->insert($data);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
 }