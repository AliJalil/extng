<?php

class DetectInfo
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDetectionsInfo($detectionId=0,$exId=0,$userId=0)
    {
        $query = "select
    detectionsinfo.exId,
    detectionsinfo.isThere,
    detectionsinfo.lockIsGood,
    detectionsinfo.gageIsGood,
    detectionsinfo.jetIsGood,
    detectionsinfo.handleIsGood,
    detectionsinfo.isUsed,
    detectionsinfo.notes,
    detectionsinfo.gps,
    extinguishers.exNo,
    extinguishers.exName,
    d.dName,
    types.tName,
    sizes.sName
from detectionsinfo
         inner join detectionemps on detectionsinfo.deId = detectionemps.deId
         inner join detections d on detectionemps.dId = d.dId
         inner join users on users.userId = detectionsinfo.createdBy
         inner join extinguishers on extinguishers.exId = detectionsinfo.exId
         inner join types on extinguishers.exType = types.tId
         inner join sizes on sizes.sId = extinguishers.exSize
where d.isDeleted = 0";

        if ($detectionId !=0){
            $query = $query . " and detectionsinfo.deId={$detectionId}";
        }

        if ($exId !=0){
            $query = $query . " and detectionsinfo.exId={$exId}";
        }

        if ($userId !=0){
            $query = $query . " and detectionsinfo.createdBy={$userId}";
        }

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

    public function addDetectionsInfo($data): bool
    {
        $this->db->query('INSERT INTO detectionsinfo (deId, exId, isThere,lockIsGood,gageIsGood,jetIsGood,handleIsGood,isUsed,gps,notes,createdBy) 
                                                    VALUES (:deId,:exId,:isThere,:lockIsGood,:gageIsGood,:jetIsGood,:handleIsGood,:isUsed,:gps,:notes,:createdBy)');
        // Bind Values
        $this->db->bind(':deId', $data['deId']);
        $this->db->bind(':exId', $data['exId']);
        $this->db->bind(':isThere', $data['isThere']);
        $this->db->bind(':lockIsGood', $data['lockIsGood']);
        $this->db->bind(':gageIsGood', $data['gageIsGood']);
        $this->db->bind(':jetIsGood', $data['jetIsGood']);
        $this->db->bind(':handleIsGood', $data['handleIsGood']);
        $this->db->bind(':isUsed', $data['isUsed']);
        $this->db->bind(':gps', $data['gps']);
        $this->db->bind(':notes', $data['notes']);
        $this->db->bind(':createdBy', $data['createdBy']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }



    // Update Post
    public function updateDetection($data): bool
    {
        $q = "";
        $updateQuery = "Update detections set " . $data["name"] . " = '{$data["value"]}'";
        $q = $q . "  WHERE dId= {$data["pk"]} ";
        $this->db->query($updateQuery . $q);
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
