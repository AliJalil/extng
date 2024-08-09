<?php

class DonationType
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getDonationTypes()
    {

        $query = "SELECT * FROM donationTypes where donationTypes.isDeleted !=1 order by dTypeId ASC ";
        $this->db->query($query);
        return $this->db->resultset();

    }

    public function getJsonDonationTypes()
    {
        $query = "SELECT dTypeId as 'value', dTypeName as 'text' FROM donationTypes  WHERE isDeleted !=1 and isActive !=0 order by dTypeId ASC ";
        $this->db->query($query);
        $results = $this->db->resultset();
        return json_encode($results);
    }


    public function addDonationType($data)
    {

        $this->db->query('INSERT INTO donationTypes (dTypeName) VALUES (:dTypeName)');
        $this->db->bind(':dTypeName', $data['dTypeName']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDonationType($data)
    {

        $q = "Update `donationTypes` set " . $data["name"] . " = ?  WHERE dTypeId= ? ";

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
