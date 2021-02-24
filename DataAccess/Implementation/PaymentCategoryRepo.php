<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/DataAccess/Interface/IPaymentCategoryRepo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Domain/PaymentCategory.php';

class PaymentCategoryRepo implements IPaymentCategoryRepo
{
    private $table = "payment_category";

    public function Create($entity)
    {
        #create a new payment object
        $payCategory = new PaymentCategory();

        $payCategory->id = Guidv4();
        $payCategory->category_name = $entity['category_name'];
        $payCategory->created_by = $entity['created_by'];

        $sql = "INSERT INTO $this->table (id, category_name, created_by)
                VALUES ('{$payCategory->id}', '{$payCategory->category_name}', '{$payCategory->created_by}')";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $payCategory;

        return false;
    }

    public function GetAll()
    {
        $sql = "SELECT * FROM $this->table";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty list
        $payCategories = array();
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $payCategory = new PaymentCategory(); #simple object
                $payCategory->id = $result['id'];
                $payCategory->category_name = $result['category_name'];
                $payCategory->created_by = $result['created_by'];

                #push to list
                array_push($payCategories, $payCategory);
            }

            return $payCategories;
        }

        return $payCategories;
    }

    public function GetById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = '{$id}'";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty object
        $payCategory = new PaymentCategory(); #simple object
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $payCategory->id = $result['id'];
                $payCategory->category_name = $result['category_name'];
                $payCategory->created_by = $result['created_by'];
            }

            return $payCategory;
        }

        return $payCategory;
    }

    public function Update($newEntity)
    {
        if(is_null($newEntity) || empty($newEntity)) return "Entity Cannot be null or empty";

        #fetch the entity to update
        $EntityToUpdate = $this->GetById($newEntity['id']);

        if(is_null($EntityToUpdate) || empty($EntityToUpdate)) return "Entity was not found";

        $payCategoryUpdate = new PaymentCategory();

        $payCategoryUpdate->category_name = is_null($newEntity['category_name']) || empty($newEntity['category_name']) ? $EntityToUpdate->category_name : $newEntity['category_name'];
        
        $payCategoryUpdate->created_by = is_null($newEntity['created_by']) || empty($newEntity['created_by']) ? $EntityToUpdate->created_by : $newEntity['created_by'];
        
        
        $payCategoryUpdate->id = $EntityToUpdate->id;

        #update script
        $sql = "UPDATE $this->table SET
                category_name = '{$payCategoryUpdate->category_name}',
                created_by = '{$payCategoryUpdate->created_by}',
                WHERE id = '{$payCategoryUpdate->id}'";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $payCategoryUpdate;

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