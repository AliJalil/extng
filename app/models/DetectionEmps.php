<?php


class DetectionEmps
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getExtInDetection()
    {
        $query = "
            SELECT 
                extinguishers.exId, 
                extinguishers.exNo, 
                extinguishers.exName, 
                users.userId, 
                users.name
            FROM detectionemps
            INNER JOIN extinguishers ON extinguishers.exId = detectionemps.exId
            INNER JOIN users ON users.userId = detectionemps.userId
            WHERE extinguishers.isDeleted = 0 
              AND detectionemps.isDeleted = 0
            ORDER BY extinguishers.exId DESC
        ";

        $this->db->query($query);
        return $this->db->resultset();
    }

    public function getExtNotInDetection()
    {
        $query = "
            SELECT 
                extinguishers.exId, 
                extinguishers.exNo, 
                extinguishers.exName
            FROM extinguishers
            WHERE extinguishers.isDeleted = 0 
              AND extinguishers.exId NOT IN (
                  SELECT detectionemps.exId 
                  FROM detectionemps 
                  WHERE detectionemps.isDeleted = 0
              )
            ORDER BY extinguishers.exId DESC
        ";

        $this->db->query($query);
        return $this->db->resultset();
    }

    public function deleteAdd($data)
    {
        $deleteSql = "
            UPDATE detectionemps d
            JOIN extinguishers ex ON d.exId = ex.exId
            JOIN users u ON u.userId = d.userId
            SET d.isDeleted = 1 
            WHERE d.dId = :dId;
        ";

        $insertSql = "
            INSERT INTO detectionemps (dId, userId, exId) VALUES 
        ";

        // Constructing the placeholders dynamically
        $placeholders = [];
        for ($i = 0, $count = count($data['userIds']); $i < $count; $i++) {
            $placeholders[] = "(:dId$i, :userId$i, :exId$i)";
        }

        $query = $deleteSql . $insertSql . implode(',', $placeholders) . "
            ON DUPLICATE KEY UPDATE detectionemps.isDeleted = 0;
        ";

        $this->db->query($query);

        // Binding parameters for DELETE
        $this->db->bind(':dId', $data['dId']);

        // Binding parameters for INSERT
        for ($i = 0, $count = count($data['userIds']); $i < $count; $i++) {
            $this->db->bind(":dId$i", $data['dId']);
            $this->db->bind(":userId$i", $data['userIds'][$i]);
            $this->db->bind(":exId$i", $data['exIds'][$i]);
        }

        // Execute and return status
        return $this->db->execute();
    }
}

