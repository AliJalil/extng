<?php

class Size
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getSizes()
    {
        $query = "SELECT * FROM sizes where sizes.isDeleted !=1 order by sId ASC";
        $this->db->query($query);
        return $this->db->resultset();
    }


    public function getSize($row, $rowperpage, $data): array
    {
        $query = "SELECT * ";
        $innerQuery = " from sizes where sizes.isDeleted !=1 ";

        $conditions = array();

        if (!empty($data['sName'])) {
            $conditions[] = "sizes.sName LIKE '%{$data['sName']}%'";
        }

        if (!empty($data['sId'])) {
            $conditions[] = "sizes.sId = '{$data['sId']}'";
        }

        $sql = $innerQuery;
        if (count($conditions) > 0) {
            $sql = $sql . " and ";
            $sql .= " " . implode(' AND ', $conditions);
        }
        $sql = $sql . " order by sizes.sId ASC";
        $this->db->query($query . $sql);
        $_ = $this->db->single();
        $result[] = $this->db->rowCount();
        //get filtered data
        $sql = $sql . " limit " . $row . " , " . $rowperpage;
        $this->db->query($query . $sql);
        $result[] = $this->db->resultset();
        return $result;
    }


    public function getSizeCount()
    {
        $selectStm = "SELECT count(sizes.sId) as 'count' FROM sizes where sizes.isDeleted !=1  ";
        $this->db->query($selectStm);
        return $this->db->single()->count;
    }

    public function getJsonSizes()
    {
        $query = "SELECT  sId as 'value', sName as 'text' FROM sizes  WHERE isDeleted !=1 and isActive !=0 order by sizes.sId ASC";
        $this->db->query($query);
        $results = $this->db->resultset();
        return json_encode($results);

    }

    public function addSize($data): bool
    {

        // Prepare Query
        $this->db->query('INSERT INTO sizes (sName,createdBy) VALUES (:sName,:createdBy)');
        // Bind Values
        $this->db->bind(':sName', $data['sName']);
        $this->db->bind(':createdBy', $data['createdBy']);
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSize($data): bool
    {
        $q = "Update sizes set " . $data["name"] . " = '{$data["value"]}'  WHERE sId= {$data["pk"]} ";
        // Prepare Query
        $this->db->query($q);
        // Bind Values
//        $this->db->bind(1, $data["value"], PDO::PARAM_STR);
//        $this->db->bind(2, $data["pk"], PDO::PARAM_STR);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getSizeById($sId = 0)
    {
        $this->db->query("SELECT * FROM sizes
                                WHERE  sizes.isActive =1 and sizes.isDeleted =0  and sId = :sId ");
        $this->db->bind(':sId', $sId);
        return $this->db->single();
    }
}
