<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/DataAccess/Interface/IPaymentRepo.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Community/Domain/Payments.php';

class PaymentRepo implements IPaymentRepo
{
    private $table = "payments";

    public function Create($entity)
    {
        #create a new payment object
        $payment = new Payments();

        $payment->id = Guidv4();
        $payment->payment_category_id = $entity['payment_category_id'];
        $payment->tenant_id = $entity['tenant_id'];
        $payment->amount = $entity['amount'];
        $payment->treated_by = $entity['treated_by'];

        $sql = "INSERT INTO $this->table (id, payment_category_id, tenant_id, amount, treated_by)
                VALUES ('{$payment->id}', '{$payment->payment_category_id}', '{$payment->tenant_id}', '{$payment->amount}', '{$payment->treated_by}')";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $payment;

        return false;
    }

    public function GetAll()
    {
        $sql = "SELECT * FROM $this->table";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty list
        $payments = array();
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $payment = new Payments(); #simple object
                $payment->id = $result['id'];
                $payment->payment_category_id = $result['payment_category_id'];
                $payment->tenant_id = $result['tenant_id'];
                $payment->amount = $result['amount'];
                $payment->datePaid= $result['datePaid'];
                $payment->treated_by = $result['treated_by'];

                #push to list
                array_push($payments, $payment);
            }

            return $payments;
        }

        return $payments;
    }

    public function GetById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = '{$id}'";
        $runSql = DB::DBInstance()->query($sql);

        #initialize an empty object
        $payment = new Payments(); #simple object
        if($runSql)
        {
            while ($result = $runSql->getResults())
            {
                # code...
                $payment->id = $result['id'];
                $payment->payment_category_id = $result['payment_category_id'];
                $payment->tenant_id = $result['tenant_id'];
                $payment->amount = $result['amount'];
                $payment->datePaid= $result['datePaid'];
                $payment->treated_by = $result['treated_by'];
            }

            return $payment;
        }

        return $payment;
    }

    public function Update($newEntity)
    {
        if(is_null($newEntity) || empty($newEntity)) return "Entity Cannot be null or empty";

        #fetch the entity to update
        $EntityToUpdate = $this->GetById($newEntity['id']);

        if(is_null($EntityToUpdate) || empty($EntityToUpdate)) return "Entity was not found";

        $paymentUpdate = new Payments();

        $paymentUpdate->tenant_id = is_null($newEntity['tenant_id']) || empty($newEntity['tenant_id']) ? $EntityToUpdate->tenant_id : $newEntity['tenant_id'];
        $paymentUpdate->payment_category_id = is_null($newEntity['payment_category_id']) || empty($newEntity['payment_category_id']) ? $EntityToUpdate->payment_category_id : $newEntity['payment_category_id'];
        $paymentUpdate->amount = is_null($newEntity['amount']) || empty($newEntity['amount']) ? $EntityToUpdate->amount : $newEntity['amount'];
        $paymentUpdate->treated_by = is_null($newEntity['treated_by']) || empty($newEntity['treated_by']) ? $EntityToUpdate->treated_by : $newEntity['treated_by'];
        
        
        $paymentUpdate->id = $EntityToUpdate->id;

        #update script
        $sql = "UPDATE $this->table SET
                tenant_id = '{$paymentUpdate->tenant_id}',
                payment_category_id = '{$paymentUpdate->payment_category_id}',
                amount = '{$paymentUpdate->amount}',
                treated_by = '{$paymentUpdate->treated_by}',
                WHERE id = '{$paymentUpdate->id}'";

        $runSql = DB::DBInstance()->query($sql);

        if($runSql) return $paymentUpdate;

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