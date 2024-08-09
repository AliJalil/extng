<?php

class Detect
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDetections()
    {
        $query = "select detections.dId, detections.dName,detections.startIn,detections.endAt
                    ,detections.isCurrent
                    ,detections.isActive
                    ,detections.notes
         from detections 
         inner join users on detections.createdBy =users.userId
         where detections.isActive =1 and detections.isDeleted =0 ";
        $this->db->query($query);
        return $this->db->resultset();
    }

    public function getDetection($row, $rowperpage, $data): array
    {
        $query = "select detections.dId, detections.dName,detections.startIn,detections.endAt
                    ,detections.isCurrent
                    ,detections.isActive
                    ,detections.notes ";
        $innerQuery = " from detections 
         inner join users on detections.createdBy =users.userId
         where  detections.isDeleted =0   ";

        $conditions = array();
        if (!empty($data['dName'])) {
            $conditions[] = "detections.dName LIKE '%{$data['dName']}%'";
        }

        if (!empty($data['startIn'])) {
            $conditions[] = "detections.startIn LIKE '%{$data['startIn']}%'";
        }

        if (!empty($data['endAt'])) {
            $conditions[] = "detections.endAt LIKE '%{$data['endAt']}%'";
        }

        if (!empty($data['notes'])) {
            $conditions[] = "detections.notes LIKE '%{$data['notes']}%'";
        }
        if (!empty($data['isActive'])) {
            $conditions[] = "detections.isActive = '{$data['isActive']}'";
        }

        if (!empty($data['isCurrent'])) {
            $conditions[] = "detections.isCurrent = '{$data['isCurrent']}'";
        }

        $sql = $innerQuery;
        if (count($conditions) > 0) {
            $sql = $sql . " and ";
            $sql .= " " . implode(' AND ', $conditions);
        }

        $sql = $sql . " order by detections.dId asc";

        $this->db->query($query . $sql);
        $_ = $this->db->single();
        $result[] = $this->db->rowCount();

        //get filtered data
        $sql = $sql . " limit " . $row . " , " . $rowperpage;

        $this->db->query($query . $sql);

        $result[] = $this->db->resultset();
        return $result;
    }

    public function getDetectCount()
    {
        $selectStm = "SELECT count(detections.dId) as 'count' FROM detections
                                             inner join users on detections.createdBy =users.userId
                                 where  ";

        $query = $selectStm . " detections.isDeleted =0  order by detections.dId desc";
        $this->db->query($query);
        return $this->db->single()->count;
    }

    public function addDetect($data)
    {
        $this->db->query('INSERT INTO detections (dName, startIn, endAt, notes,createdBy) 
               VALUES (:dName,:startIn,:endAt,:notes,:createdBy)');
        // Bind Values
        $this->db->bind(':dName', $data['dName']);
        $this->db->bind(':startIn', $data['startIn']);
        $this->db->bind(':endAt', $data['endAt']);
        $this->db->bind(':notes', $data['notes']);
        $this->db->bind(':createdBy', $data['createdBy']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function updateDetection($data): bool
    {

        $q = "";
        if ($data["name"] == 'isCurrent') {
            $q = $q . "Update  `detections` set isCurrent = 2;";
        }

        $q = $q . "Update `detections` set " . $data["name"] . " = ?  WHERE dId= ? ";

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

    public function getCurrentDetection()
    {
        $this->db->query("SELECT * FROM detections WHERE isCurrent = 1");
        return $this->db->single();
    }

}
