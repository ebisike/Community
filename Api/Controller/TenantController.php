<?php

//http://127.0.0.1/Kiosk/Kiosk.Web/Views/Areas/Admin/Home/index.php#

require $_SERVER['DOCUMENT_ROOT'].'/Community/Data/required_services.php';
$t = new TenantController();

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


class TenantController
{
    private $TenantService;
    private $adminService;

    public function __construct()
    {
       $this->TenantService = new TenantService(new TenantRepo());
       $this->adminService = new AdminService(new AdminRepo());
    }

    /********************************* Functions *****************************************/
    public function Create($values)
    {
        $result = $this->TenantService->Add($values);

        if($values['isAdmin'] == "1")
        {
            $NewAdmin = 
            [
                "tenant_id" => $result->id,
                "username" => $result->firstName.$result->lastName,
                "password" => $result->phone
            ];

            $this->adminService->Add($NewAdmin);
        }
        
        //var_dump($result);    
        echo json_encode($result);
    }

    public function GetAll()
    {
        $result = $this->TenantService->GetAllTenants();
        echo json_encode($result);
    }

    public function GetSingle($id)
    {
        $result = $this->TenantService->GetTenantById($id);
        echo json_encode($result);
    }

    public function Delete($id)
    {
        $result = $this->TenantService->Remove($id);

        echo json_encode($result);
    }

    public function Update($values)
    {
        $result = $this->TenantService->UpdateTenant($values);

        echo json_encode($result);
    }
}