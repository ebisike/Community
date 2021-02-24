<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/includes.php';

class AdminService
{
    private $repo;

    public function __construct(IAdminRepo $repo)
    {
        $this->repo = $repo;
    }

    public function Add($admin)
    {
        return $this->repo->Create($admin);
    }

    public function GetAllAdmins()
    {
        return $this->repo->GetAll();
    }

    public function GetAdminById($id)
    {
        return $this->repo->GetById($id);
    }

    public function GetAdminByTenantID($tenant_id)
    {
        $adminList = $this->repo->GetAll();

        $match = null;

        #iterate through the list
        foreach ($adminList as $key => $value)
        {
            # code...
            if($value->tenant_id == $tenant_id) return $match = $value;

            return $match;
        }
    }

    public function UpdateAdmin($admin)
    {
        return $this->repo->Update($admin);
    }

    public function Remove($id)
    {
        return $this->repo->Delete($id);
    }

    public function Signin($username, $password)
    {
        $adminList = $this->repo->GetAll();

        $validAdmin = null;
        #iterate through the list
        foreach ($adminList as $key => $value)
        {
            # code...
            if((strtolower($value->username) == strtolower($username)) && ($value->password == $password))
            {
                $validAdmin = $value;
                break;
            }
        }

        if(!is_null($validAdmin))
        {
            //set SESSION VARIABLES
            $this->SetSessionVariables($validAdmin);
            return $validAdmin;
        }

        return $validAdmin;
    }

    private function SetSessionVariables($userObject)
    {
        $_SESSION['id'] = $userObject->id;
    }

    public function Signout()
    {
        unset($_SESSION['id']);
        return session_destroy();
    }

    public function isSignedIn()
    {
		if(isset($_SESSION['id'])) return true;
        
        return false;
    }
}