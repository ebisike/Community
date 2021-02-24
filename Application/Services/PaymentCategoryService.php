<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/includes.php';

class PaymentCategoryService
{
    private $repo;

    public function __construct(IPaymentCategoryRepo $repo)
    {
        $this->repo = $repo;
    }

    public function Add($payCategory)
    {
        return $this->repo->Create($payCategory);
    }

    public function GetAllCategories()
    {
        return $this->repo->GetAll();
    }

    public function GetCategoryById($id)
    {
        return $this->repo->GetById($id);
    }

    public function UpdateCategory($payCategory)
    {
        return $this->repo->Update($payCategory);
    }

    public function Remove($category_id)
    {
        #NOTE: can't perform a delete operation on a category that has a dependence in another table (payments)

        #verify dependence
        $paymentService = new PaymentService(new PaymentRepo());
        $dependencyResult = $paymentService->PaymentsCategory($category_id);

        if(!is_null($dependencyResult) || !empty($dependencyResult)) return "DELETEs OPERATION NOT SUCCESSFUL. category already in use";
        
        return $this->repo->Delete($category_id);
    }
}