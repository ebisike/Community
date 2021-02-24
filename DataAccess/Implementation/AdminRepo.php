<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/DataAccess/Interface/IAdminRepo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Domain/Admin.php';

class AdminRepo implements IAdminRepo
{
    private $table = "admin";

    public function Create($entity)
    {
        #create a new tenant object
        $admin = new Admin();

        $admin->id = Guidv4();
        $admin->tenant_id = $entity['tenant_id'];
        $admin->username = $entity['username'];
        $admin->password = $entity['password'];

        $sql = "INSERT INTO $this->table (id, tenant_id, username, passcode)
                VALUES ('{$admin->id}', '{$admin->tenant_id}', '{$admin->username}', '{$admin->password}')";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $admin;

        return false;
    }

    public function GetAll()
    {
        $sql = "SELECT * FROM $this->table";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty list
        $admins = array();
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $admin = new Admin(); #simple object
                $admin->id = $result['id'];
                $admin->tenant_id = $result['tenant_id'];
                $admin->username = $result['username'];
                $admin->password = $result['passcode'];

                #push to list
                array_push($admins, $admin);
            }

            return $admins;
        }

        return $admins;
    }

    public function GetById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = '{$id}'";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty list
        $admin = new Admin(); #simple object
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $admin->id = $result['id'];
                $admin->tenant_id = $result['tenant_id'];
                $admin->username = $result['username'];
                $admin->password = $result['passcode'];
            }

            return $admin;
        }

        return $admin;
    }

    public function Update($newEntity)
    {
        if(is_null($newEntity) || empty($newEntity)) return "Entity Cannot be null or empty";

        #fetch the entity to update
        $EntityToUpdate = $this->GetById($newEntity['id']);

        if(is_null($EntityToUpdate) || empty($EntityToUpdate)) return "Entity was not found";

        $adminUpdate = new Admin();

        $adminUpdate->tenant_id = is_null($newEntity['tenant_id']) || empty($newEntity['tenant_id']) ? $EntityToUpdate->tenant_id : $newEntity['tenant_id'];
        $adminUpdate->username = is_null($newEntity['username']) || empty($newEntity['username']) ? $EntityToUpdate->username : $newEntity['username'];
        $adminUpdate->password = is_null($newEntity['password']) || empty($newEntity['password']) ? $EntityToUpdate->password : $newEntity['password'];
        
        $adminUpdate->id = $EntityToUpdate->id;

        #update script
        $sql = "UPDATE $this->table SET
                tenant_id = '{$adminUpdate->tenant_id}',
                username = '{$adminUpdate->username}',
                passcode = '{$adminUpdate->password}'
                WHERE id = '{$adminUpdate->id}'";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $adminUpdate;

        return false;

    }

    public function Delete($id)
    {
        if(is_null($id) || empty($id)) return "Id cannnot be null or empty";

        $sql = "DELETE FROM $this->table WHERE id = '{$id}'";
        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return true;

        return false;
    }
}