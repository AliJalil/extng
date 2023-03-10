<?php

class Extinguisher
{

    public $tempImgName = "";
    public $imgName = "uploads/noimageicon.png";

    public $tempCardImgName = "";
    public $imgCardName = "uploads/noimageicon.png";
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getExtinguishers()
    {
        $query = "select extinguishers.exId, extinguishers.exSeq,extinguishers.exNo,extinguishers.exName
     ,extinguishers.exType
     ,extinguishers.exSize
     ,extinguishers.exPlace
     ,extinguishers.notes
     ,extinguishers.state
     ,extinguishers.ignoreBy
         from extinguishers inner join types on extinguishers.exType = types.tId
         inner join sizes on extinguishers.exSize =sizes.sId
         inner join users on extinguishers.createdBy =users.userId
         where types.isActive =1 and types.isDeleted =0 and extinguishers.isActive =1 and extinguishers.isDeleted =0 and sizes.isDeleted = 0";
        $this->db->query($query);
        return $this->db->resultset();
    }

    public function getExtinguisher($row, $rowperpage, $data, $dTypeId = 0, $isGOldStatics = 0): array
    {
        $query = "select extinguishers.exId, 
        extinguishers.exSeq,
        extinguishers.exNo,
        extinguishers.exName
     ,extinguishers.exType
     ,extinguishers.exSize
     ,extinguishers.exPlace
     ,extinguishers.notes
     ,extinguishers.state
     ,extinguishers.ignoreBy ";
        $innerQuery = " from extinguishers inner join types on extinguishers.exType = types.tId
         inner join sizes on extinguishers.exSize =sizes.sId
         inner join users on extinguishers.createdBy =users.userId
         where types.isActive =1 and types.isDeleted =0 and extinguishers.isActive =1 and extinguishers.isDeleted =0 and sizes.isDeleted = 0  ";

        $conditions = array();
        if (!empty($data['exName'])) {
            $conditions[] = "extinguishers.exName LIKE '%{$data['exName']}%'";
        }

        if (!empty($data['exSeq'])) {
            $conditions[] = "extinguishers.exSeq LIKE '%{$data['exSeq']}%'";
        }

        if (!empty($data['exNo'])) {
            $conditions[] = "extinguishers.exNo LIKE '%{$data['exNo']}%'";
        }
        if (!empty($data['exType'])) {
            $conditions[] = "extinguishers.exType LIKE '%{$data['exType']}%'";
        }
        if (!empty($data['exSize'])) {
            $conditions[] = "extinguishers.exSize LIKE '%{$data['exSize']}%'";
        }
        if (!empty($data['exPlace'])) {
            $conditions[] = "extinguishers.exPlace LIKE '%{$data['exPlace']}%'";
        }

        if (!empty($data['notes'])) {
            $conditions[] = "extinguishers.notes LIKE '%{$data['notes']}%'";
        }
        if (!empty($data['state'])) {
            $conditions[] = "extinguishers.state = '{$data['state']}'";
        }
        if (!empty($data['amountExtra'])) {
            $conditions[] = "extinguishers.amountExtra = '{$data['amountExtra']}'";
        }

        $sql = $innerQuery;
        if (count($conditions) > 0) {
            $sql = $sql . " and ";
            $sql .= " " . implode(' AND ', $conditions);
        }

        $sql = $sql . " order by extinguishers.exId asc";

        $this->db->query($query . $sql);
        $_ = $this->db->single();
        $result[] = $this->db->rowCount();

        //get filtered data
        $sql = $sql . " limit " . $row . " , " . $rowperpage;

        $this->db->query($query . $sql);
        $result[] = $this->db->resultset();
        return $result;
    }


    public function getExtinguisherCount($dTypeId = 0, $isGOldStatics = 0)
    {
        $selectStm = "SELECT count(extinguishers.exId) as 'count' FROM extinguishers
                                             inner join types on extinguishers.exType = types.tId
                                             inner join sizes on extinguishers.exSize =sizes.sId
                                             inner join users on extinguishers.createdBy =users.userId
                                 where  ";

        $query = $selectStm . " types.isActive =1 and types.isDeleted =0 and sizes.isDeleted =0 and extinguishers.isActive =1 and extinguishers.isDeleted =0  order by extinguishers.exId desc";
        $this->db->query($query);
        return $this->db->single()->count;
    }

    public function getStatistics($data = [])
    {


        $query = "select donationTypes.dTypeName,types.dType, gId,vId,dName,details,REPLACE(amount , ',', '') as amount ,gWeight,bad,isChecked,checkedBy, IFNULL(NULLIF(benefitSide, '' ), 0) as 'benefitSide',authorizedName,FROM_UNIXTIME(gifts.createdAt,'%Y-%m-%d')as createdAt,specifications.sName ,types.gName,types.tId, users.name,gifts.state ";

        $innerQuery = " from gifts 
         inner join types on gifts.tId = types.tId
         inner join donationTypes on donationTypes.dTypeId = types.dType
         inner join specifications on gifts.sId =specifications.sId
         inner join users on gifts.createdBy =users.userId
         where types.isActive =1 and types.isDeleted =0 and gifts.isActive =1 and gifts.isDeleted = 0 and sizes.isDeleted = 0  ";

        $conditions = array();

        if (isset($data['dTypeId']) && $data['dTypeId'] != 0) {
            $conditions[] = "types.dType = '{$data['dTypeId']}'";
        }

        if (isset($data['user']) && $data['user'] != 0) {
            $conditions[] = "gifts.createdBy in ({$data['user']})";
        }

        if (isset($data['tId']) && $data['tId'] == 999) {
            $conditions[] = "gifts.tId != 1 and gifts.tId != 2 ";
        } else if (isset($data['tId']) && $data['tId'] != 0) {
            $conditions[] = "gifts.tId = '{$data['tId']}'";
        }
        $conditions[] = "gifts.createdAt between {$data['fromDate']} and {$data['toDate']}";

        $sql = $innerQuery;
        if (count($conditions) > 0) {
            $sql = $sql . " and ";
            $sql .= " " . implode(' AND ', $conditions);
        }
//        var_dump($query . $sql . ' order by gifts.gId');
//        die();
        $this->db->query($query . $sql . ' order by types.tId');
        return $this->db->resultset();
    }


    public function getGiftById($gId = 0)
    {

        $this->db->query("select notes,amountExtra,vId,gId,gName,dName,details,amount,gWeight,bad,isChecked,checkedBy,gifts.createdBy, benefitSide,authorizedName,FROM_UNIXTIME(gifts.createdAt,'%Y-%m-%d %H:%i:%s') as 'createdAt',specifications.sName,types.gName,types.moneyCode,users.name from gifts 
                                             inner join types on gifts.tId = types.tId
                                             inner join specifications on gifts.sId =specifications.sId
                                             inner join users on gifts.createdBy =users.userId
                                WHERE  types.isActive =1 and types.isDeleted =0 and gifts.isActive =1 and gifts.isDeleted =0 and gId = :gId and sizes.isDeleted = 0 ");
        $this->db->bind(':gId', $gId);
        return $this->db->single();
    }


    public function getGiftSumAmountById($gId = 0)
    {

        $this->db->query("SELECT  gName as 'text',sum(gifts.amount) as 'value'
                                FROM types
                                inner join gifts on gifts.tId = types.tId
                                WHERE gifts.isDeleted != 1
                                and types.isDeleted != 1
                                and gifts.isActive != 0
                                and types.isActive != 0
                                and dType = :gId
                                GROUP BY types.tId ");
        $this->db->bind(':gId', $gId);
        return $this->db->resultset();
    }

    public function getGiftSumAmountBySpecifications($dType = 1)
    {

        $this->db->query("SELECT sName as 'text', sum(gifts.amount) as 'value'
        FROM specifications
        inner join gifts on gifts.sId = specifications.sId
        inner join types on gifts.tId = types.tId
        WHERE gifts.isDeleted != 1
        and sizes.isDeleted != 1
        and gifts.isActive != 0
        and specifications.isActive != 0
        and types.dType = :dType
        GROUP BY specifications.sId ");
        $this->db->bind(':dType', $dType);
        return $this->db->resultset();
    }


    public function addExt($data)
    {



        $this->db->query('INSERT INTO extinguishers (exSeq, exNo, exType, exSize, exPlace,notes,createdBy) 
               VALUES (:exSeq,:exNo,:exType,:exSize,:exPlace,:notes,:createdBy)');
        // Bind Values
        $this->db->bind(':exSeq', $data['exSeq']);
        $this->db->bind(':exNo', $data['exNo']);
        $this->db->bind(':exType', $data['exType']);
        $this->db->bind(':exSize', $data['exSize']);
        $this->db->bind(':exPlace', $data['exPlace']);
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
    public function updateGift($data)
    {
        $q = "";
        $updateQuery = "Update extinguishers set " . $data["name"] . " = '{$data["value"]}'";

        if ($data["name"] == 'state') {
            $q = ", ignoreBy ={$data['userId']}  ";
        }

        $q = $q . "  WHERE exId= {$data["pk"]} ";

        $this->db->query($updateQuery . $q);
        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxVID($tId)
    {

        $this->db->query("SELECT max(vId) as maxVId from gifts
                                                     inner join types t on gifts.tId = t.tId
                                                     inner join donationTypes dT on t.dType = dT.dTypeId
                                                     where dT.dTypeId = (select distinct (dTypeId) from donationTypes inner join types on dType = dTypeId where tId = {$tId} limit 1) ");

        return $this->db->single()->maxVId;
    }
}
