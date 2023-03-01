<?php

class Type
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getTypes()
    {
        $query = "SELECT * FROM types where types.isDeleted !=1 order by tId ASC ";
        $this->db->query($query);
        return $this->db->resultset();
    }


    public function getType($row, $rowperpage, $data )
    {
        $query = "SELECT * ";
        $innerQuery = " from types where types.isDeleted !=1 ";

        $conditions = array();

        if (!empty($data['tName'])) {
            $conditions[] = "types.tName LIKE '%{$data['tName']}%'";
        }

        $sql = $innerQuery;
        if (count($conditions) > 0) {
            $sql = $sql . " and ";
            $sql .= " " . implode(' AND ', $conditions);
        }
        $sql = $sql . " order by types.tId asc";
        $this->db->query($query . $sql);
        $_ = $this->db->single();
        $result[] = $this->db->rowCount();
        //get filtered data
        $sql = $sql . " limit " . $row . " , " . $rowperpage;
        $this->db->query($query . $sql);
        $result[] = $this->db->resultset();
        return $result;
    }


    public function getTypeCount()
    {
        $selectStm = "SELECT count(types.tId) as 'count' FROM types where types.isDeleted !=1  ";
        $this->db->query($selectStm);
        return $this->db->single()->count;
    }

    public function getJsonTypes()
    {
        $query = "SELECT  tId as 'value', tName as 'text' FROM types  WHERE isDeleted !=1 and isActive !=0 order by tId ASC ";
        $this->db->query($query);
        $results = $this->db->resultset();
        return json_encode($results);

    }


    public function adtId($data)
    {
        // Prepare Query
        $this->db->query('INSERT INTO types (tName,createdBy) VALUES (:gName,:createdBy)');
        // Bind Values
        $this->db->bind(':gName', $data['tName']);
        $this->db->bind(':createdBy', $data['createdBy']);
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateType($data)
    {
        $q = "Update `types` set " . $data["name"] . " = ?  WHERE tId= ? ";

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
