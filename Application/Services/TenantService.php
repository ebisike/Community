<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/Community/Data/includes.php';

class TenantService
{
    private $repo;

    public function __construct(ITenantRepo $repo)
    {
        $this->repo = $repo;
    }

    public function Add($entity)
    {
        return $this->repo->Create($entity);
    }

    public function GetAllTenants()
    {
        return $this->repo->GetAll();
    }

    public function GetTenantById($id)
    {
        return $this->repo->GetById($id);
    }

    public function GetTenantByPhone($phone)
    {
        $tenantList = $this->repo->GetAll();

        $match = null;

        #iterate through the list
        foreach ($tenantList as $key => $value)
        {
            # code...
            if($value->phone == $phone) return $match = $value;

            return $match;
        }
    }

    public function UpdateTenant($tenant)
    {
        return $this->repo->Update($tenant);
    }

    public function Remove($tenant_id)
    {
        return $this->repo->Delete($tenant_id);
    }
}