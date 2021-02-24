<?php

//http://127.0.0.1/Kiosk/Kiosk.Web/Views/Areas/Admin/Home/index.php#

require $_SERVER['DOCUMENT_ROOT'].'/Community/Data/required_services.php';
$t = new AdminController();

#Create New Tenant EndPoint
if(isset($_GET['new']))
{
    $t->Create($_POST);
}

#getAll Endpoint
if(isset($_GET['GetAll']))
{
    $t->GetAll();
}

#GetSingle Endpoint
if(isset($_GET['tenant_id']))
{
    $t->GetSingle($_GET['tenant_id']);
}

if(isset($_GET['update']))
{
    $t->Update($_POST);
}

if(isset($_GET['delete']))
{
    $t->Delete($_GET['delete']);
}


class AdminController
{
    private $AdminService;

    public function __construct()
    {
       $this->AdminService = new AdminService(new AdminRepo()); 
    }

    /********************************* Functions *****************************************/
    public function Create($values)
    {
        $result = $this->AdminService->Add($values);
        //var_dump($result);    
        echo json_encode($result);
    }

    public function GetAll()
    {
        $result = $this->AdminService->GetAllAdmins();
        echo json_encode($result);
    }

    public function GetSingle($id)
    {
        $result = $this->AdminService->GetAdminById($id);
        echo json_encode($result);
    }

    public function Delete($id)
    {
        $result = $this->AdminService->Remove($id);

        echo json_encode($result);
    }

    public function Update($values)
    {
        $result = $this->AdminService->UpdateAdmin($values);

        echo json_encode($result);
    }
}