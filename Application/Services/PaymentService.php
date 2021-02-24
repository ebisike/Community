<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/includes.php';

class PaymentService
{
    private $repo;

    public function __construct(IPaymentRepo $repo)
    {
        $this->repo = $repo;
    }

    public function Add($payCategory)
    {
        return $this->repo->Create($payCategory);
    }

    public function GetAllPayments()
    {
        return $this->repo->GetAll();
    }

    public function GetPaymentById($id)
    {
        return $this->repo->GetById($id);
    }

    public function PaymentsCategory($category_id)
    {
        $payments = $this->repo->GetAll();

        $match = array();

        #iterate through the list
        foreach ($payments as $key => $value)
        {
            # code...
            if($value->category_id == $category_id) array_push($match, $value);
        }
        return $match;
    }

    public function UpdatePayment($pay)
    {
        return $this->repo->Update($pay);
    }

    public function Remove($payment_id)
    {
        return $this->repo->Delete($payment_id);
    }
}