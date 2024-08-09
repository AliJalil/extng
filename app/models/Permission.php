<?php

class Permission
{
    private $db;

    public $tempImgName = "";
    public $imgName = "uploads/placeHolder.png";


    public function __construct()
    {
        $this->db = new Database;
    }


    public function getPermissions()
    {
        $query = "SELECT permissions.pId, permissions.pName,permissions.pNameAr FROM permissions where permissions.isDeleted = 0";
        $this->db->query($query);
        return $this->db->resultset();
    }

    public function getPermissionsByUserId($userId  = 0)
    {
        $query = "SELECT p.pId, p.pName,p.pNameAr FROM userpermissions
                                                              inner join permissions p on userpermissions.pId = p.pId
                                                              where p.isDeleted = 0 and userId = :userId";
        $this->db->query($query);
        $this->db->bind(':userId', $userId);

        return $this->db->resultset();
    }

}
