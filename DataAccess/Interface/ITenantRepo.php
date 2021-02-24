<?php

interface ITenantRepo
{
    public function Create($entity);

    public function GetAll();

    public function GetById($id);

    public function Update($newEntity);

    public function Delete($id);
}