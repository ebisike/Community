<?php

class TableConfiguration extends DB
{
    private $dbName = "community";
    private $tbl_Tenants = "tenants";
    private $tbl_admin = "admin";
    private $tbl_payments = "payments";
    private $tbl_payment_category = "payment_category";

    //constructor
    public function __construct()
    {
        $this->createTableAdmin();
        $this->createTablePaymentCategory();
        $this->createTablePayments();
        $this->createTableTenants();
    }

    private function createTableTenants()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->dbName.$this->tbl_Tenants
                ( `id` VARCHAR(255) NOT NULL , 
                    `firstName` VARCHAR(255) NOT NULL ,
                    `lastName` VARCHAR(255) NOT NULL ,
                    `phone` VARCHAR(255) NOT NULL ,
                    `addresss` VARCHAR(255) NOT NULL ,
                    `balance` VARCHAR(255) NOT NULL ,
                    `isAdmin` BOOLEAN NOT NULL DEFAULT FALSE ,
                    `created_by` VARCHAR(255) NOT NULL ,  
                    PRIMARY KEY (`id`)
                ) ENGINE = InnoDB;";

        $runsql = DB::DBInstance()->query($sql);
    }

    private function createTableAdmin()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->dbName.$this->tbl_admin
                ( `id` VARCHAR(255) NOT NULL , 
                    `tenant_id` VARCHAR(255) NOT NULL ,
                    `username` VARCHAR(255) NOT NULL ,
                    `passcode` VARCHAR(255) NOT NULL ,
                    PRIMARY KEY (`id`)
                ) ENGINE = InnoDB;";

        $runsql = DB::DBInstance()->query($sql);
    }

    private function createTablePaymentCategory()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->dbName.$this->tbl_payment_category
                ( `id` VARCHAR(255) NOT NULL , 
                    `category_name` VARCHAR(255) NOT NULL ,
                    `created_by` VARCHAR(255) NOT NULL ,  
                    PRIMARY KEY (`id`)
                ) ENGINE = InnoDB;";

        $runsql = DB::DBInstance()->query($sql);
    }

    private function createTablePayments()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->dbName.$this->tbl_payments
                ( `id` VARCHAR(255) NOT NULL , 
                    `tenant_id` VARCHAR(255) NOT NULL ,
                    `payment_categor_id` VARCHAR(255) NOT NULL ,
                    `amount` DOUBLE NOT NULL ,
                    `dateAdded` DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                    `treated_by` VARCHAR(255) NOT NULL ,  
                    PRIMARY KEY (`id`)
                ) ENGINE = InnoDB;";

        $runsql = DB::DBInstance()->query($sql);
    }
}