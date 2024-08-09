<?php


class DetectionEmps
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getExtInDetection($dId)
    {
        $query = "SELECT extinguishers.exId, extinguishers.exNo,extinguishers.exName,users.userId, users.name
                  FROM detectionemps
                  INNER JOIN extinguishers on extinguishers.exId = detectionemps.exId
                  INNER JOIN users on users.userId = detectionemps.userId
                  where extinguishers.isDeleted = 0 and detectionemps.isDeleted = 0 and detectionemps.dId = :dId ";

        $query = $query . " order by extinguishers.exId desc";
        $this->db->query($query);
        $this->db->bind(':dId', $dId);
        return $this->db->resultset();
    }

    public function getExtNotInDetection($dId)
    {
        $query = "SELECT extinguishers.exId, extinguishers.exNo,extinguishers.exName
                    FROM extinguishers
                    where extinguishers.isDeleted = 0 and
                    extinguishers.exId not in (select detectionemps.exId from detectionemps where detectionemps.isDeleted = 0 and dId = :dId) ";
        $query = $query . " order by extinguishers.exId desc";
        $this->db->query($query);
        $this->db->bind(':dId', $dId);
        return $this->db->resultset();
    }

    public function ifZyaraExist($zId)
    {
        $this->db->query("SELECT count(*) as 'count' FROM zyaraVol WHERE zId = :zId");

        $this->db->bind(':zId', $zId);

        return $this->db->single()->count;
    }

    public function getMaxSId($zid)
    {
        $this->db->query("select  max(sId) as maxSID from zyaraVol where zId = :zid");
        $this->db->bind(':zid', $zid);
        $row = $this->db->single();
        return $row->maxSID;
    }

    public function deleteAdd($data)
    {
        //TO SET NEW SERIAL NO TO VOLU WHICH UNIQUE IN EVERY ZYARA
//        $sId = $this->getMaxSId($data['zId']) + 1;

        //SET VOLU DELETE WHEN REMOVE HIM FROM SPECIFIC ZYZARA TO PREVENT PRINT OF HIS CARD
        //INSERT NEW VOLUS INTO TABLE AND UPDATE STATUS OF THEM TO ISDELETED=0 WHEN HIS ALREADY IN THE TABLE WITH SAME VOLID AND ZID

//        $sql = 'update zyaraVol z JOIN voluTb v on z.volId = v.id
//                    JOIN centers c on v.centerId = c.centerId
//                    set z.isDeleted = 1 where z.zId = :zId';
        $sql = 'update detectionemps d JOIN extinguishers ex on d.exId = ex.exId
                    JOIN users u on u.userId = d.userId
                    set d.isDeleted = 1 where d.dId = :dId';
//        if ($data['centerId'] != 0) {
//            $sql = $sql . " and c.centerId =" . $data['centerId'];
//        }

        $sql = $sql . ';INSERT INTO detectionemps (dId,userId,exId)  VALUES';

        $elements = array();
        for ($i = 0; $i < count($data['userIds']); $i++) {
            $elements[] = ('(:dId' . $i . ',:userId' . $i . ',:exId' . $i . ')');
        }

        $query = $sql . implode(',', $elements);
        $query = $query . " ON DUPLICATE KEY update detectionemps.isDeleted = 0;";

        //BIND ZID FOR DELETE QUERY
        $this->db->query($query);

        //BIND OTHER FIELDS WHEN INSERT
        $this->db->bind(':dId', $data['dId']);

        for ($i = 0; $i < count($data['userIds']); $i++) {
            $this->db->bind(':dId' . $i, $data['dId']);
            $this->db->bind(':userId' . $i, $data['userIds'][$i]);
            $this->db->bind(':exId' . $i, $data['exIds'][$i]);

        }

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxId()
    {
        $this->db->query("SELECT MAX(id) AS max_id  FROM voluTb");
        $row = $this->db->single();
        return $row->max_id;
    }

    public function getMaxVID($zid)
    {
        $this->db->query("select  max(vId) as maVID from voluTb where zyara = :zid");
        $this->db->bind(':zid', $zid);
        $row = $this->db->single();
        return $row->maVID;
    }


    public function getZyaraByVolId($volId)
    {
        $query = "SELECT zName from zyarat inner join zyaraVol on zyaraVol.zId=zyarat.zId where zyaraVol.volId = :volId ";
        $this->db->query($query);
        $this->db->bind(":volId", $volId);
        return $this->db->resultset();
    }
}
