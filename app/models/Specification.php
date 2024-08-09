<?php

class Specification
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getSpecifications()
    {

        $query = "SELECT * FROM specifications where specifications.isDeleted !=1 order by sId ASC ";
        $this->db->query($query);
        return $this->db->resultset();

    }


    public function getSpecification($row, $rowperpage)
    {
        $query = "SELECT * ";
        $innerQuery = " FROM specifications where specifications.isDeleted !=1 ";

        $conditions = array();

        if (!empty($data['sName'])) {
            $conditions[] = "specifications.sName LIKE '%{$data['sName']}%'";
        }


        $sql = $innerQuery;
        if (count($conditions) > 0) {
            $sql = $sql . " and ";
            $sql .= " " . implode(' AND ', $conditions);
        }
        $sql = $sql . " order by specifications.sId asc";
        $this->db->query($query . $sql);
        $_ = $this->db->single();
        $result[] = $this->db->rowCount();
        //get filtered data
        $sql = $sql . " limit " . $row . " , " . $rowperpage;
        $this->db->query($query . $sql);
        $result[] = $this->db->resultset();
        return $result;
    }


    public function getSpecificationCount()
    {
        $selectStm = "SELECT count(specifications.sId) as 'count' FROM specifications
                                             
                                 where specifications.isDeleted !=1  ";
        $this->db->query($selectStm);
        return $this->db->single()->count;
    }

    public function getJsonSpecifications()
    {
        $query = "SELECT sId as 'value', sName as 'text' FROM specifications  WHERE isDeleted !=1 and isActive !=0 order by sId ASC ";
        $this->db->query($query);
        $results = $this->db->resultset();
        return json_encode($results);
    }


    public function addSpecification($data): bool
    {

        $this->db->query('INSERT INTO specifications (sName,createdBy) VALUES (:sName,:createdBy)');
        $this->db->bind(':sName', $data['sName']);
        $this->db->bind(':createdBy', $data['createdBy']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSpecification($data): bool
    {
        $q = "Update `specifications` set " . $data["name"] . " = ?  WHERE sId= ? ";

        // Prepare Query
        $this->db->query($q);

        // Bind Values
        $this->db->bind(1, $data["value"], PDO::PARAM_STR);
        $this->db->bind(2, $data["pk"], PDO::PARAM_STR);
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
