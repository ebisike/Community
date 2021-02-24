<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/DataAccess/Interface/ITenantRepo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Domain/Tenants.php';

class TenantRepo implements ITenantRepo
{
    private $table = "tenants";
    private $sysAdmin = "";

    public function Create($entity)
    {
        #create a new tenant object
        $tenant = new Tenants();

        $tenant->id = Guidv4();
        $tenant->firstName = $entity['firstName'];
        $tenant->lastName = $entity['lastName'];
        $tenant->phone = $entity['phone'];
        $tenant->address = $entity['address'];
        $tenant->balance = $entity['balance'];
        $tenant->isAdmin = $entity['isAdmin'];
        $entity->created_by = is_null($entity['created_by']) || empty($entity['created_by']) ? $this->sysAdmin : $entity['created_by'];

        $sql = "INSERT INTO $this->table (id, firstName, lastName, phone, addresss, balance, isAdmin, created_by)
                VALUES ('{$tenant->id}', '{$tenant->firstName}', '{$tenant->lastName}', '{$tenant->phone}', '{$tenant->address}', '{$tenant->balance}', '{$tenant->isAdmin}', '{$tenant->created_by}')";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $tenant;

        return false;
    }

    public function GetAll()
    {
        $sql = "SELECT * FROM $this->table";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty list
        $tenants = array();
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $tenant = new Tenants(); #simple object
                $tenant->id = $result['id'];
                $tenant->firstName = $result['firstName'];
                $tenant->lastName = $result['lastName'];
                $tenant->phone = $result['phone'];
                $tenant->address = $result['addresss'];
                $tenant->isAdmin = $result['isAdmin'] == "1" ? true : false;
                $tenant->created_by = $result['created_by'];

                #push to list
                array_push($tenants, $tenant);
            }

            return $tenants;
        }

        return $tenants;
    }

    public function GetById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = '{$id}'";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty list
        $tenant = new Tenants(); #simple object
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $tenant->id = $result['id'];
                $tenant->firstName = $result['firstName'];
                $tenant->lastName = $result['lastName'];
                $tenant->phone = $result['phone'];
                $tenant->address = $result['addresss'];
                $tenant->isAdmin = $result['isAdmin'] == "1" ? true : false;
                $tenant->created_by = $result['created_by'];
            }

            return $tenant;
        }

        return $tenant;
    }

    public function Update($newEntity)
    {
        if(is_null($newEntity) || empty($newEntity)) return "Entity Cannot be null or empty";

        #fetch the entity to update
        $EntityToUpdate = $this->GetById($newEntity['id']);

        if(is_null($EntityToUpdate) || empty($EntityToUpdate)) return "Entity was not found";

        $tenantUpdate = new Tenants();

        $tenantUpdate->firstName = is_null($newEntity['firstName']) || empty($newEntity['firstName']) ? $EntityToUpdate->firstName : $newEntity['firstName'];
        $tenantUpdate->lastName = is_null($newEntity['lastName']) || empty($newEntity['lastName']) ? $EntityToUpdate->lastName : $newEntity['lastName'];
        $tenantUpdate->phone = is_null($newEntity['phone']) || empty($newEntity['phone']) ? $EntityToUpdate->phone : $newEntity['phone'];
        $tenantUpdate->address = is_null($newEntity['address']) || empty($newEntity['address']) ? $EntityToUpdate->address : $newEntity['address'];
        $tenantUpdate->isAdmin = is_null($newEntity['isAdmin']) || empty($newEntity['isAdmin']) ? $EntityToUpdate->isAdmin : $newEntity['isAdmin'];
        $tenantUpdate->balance = is_null($newEntity['balance']) || empty($newEntity['balance']) ? $EntityToUpdate->balance : $newEntity['balance'];
        $tenantUpdate->created_by = is_null($newEntity['created_by']) || empty($newEntity['created_by']) ? $EntityToUpdate->created_by : $newEntity['created_by'];
        $tenantUpdate->id = $EntityToUpdate->id;

        #update script
        $sql = "UPDATE $this->table SET
                firstName = '{$tenantUpdate->firstName}',
                lastName = '{$tenantUpdate->lastName}',
                phone = '{$tenantUpdate->phone}',
                addresss = '{$tenantUpdate->address}',
                isAdmin = '{$tenantUpdate->isAdmin}',
                balance = '{$tenantUpdate->balance}'
                WHERE id = '{$tenantUpdate->id}'";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $tenantUpdate;

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