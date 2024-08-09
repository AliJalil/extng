<?php

class User
{
    private $db;

    public $tempImgName = "";
    public $imgName = "uploads/placeHolder.png";


    public function __construct()
    {
        $this->db = new Database;
    }

    public function getJsonUsers()
    {
        $query = "SELECT  userId as 'value', name as 'text' FROM users  WHERE isDeleted !=1 and isActive !=0 and userId != 0 order by userId ASC ";
        $this->db->query($query);
        $results = $this->db->resultset();
        return json_encode($results);
    }

    public function getUsers()
    {
        $query = "SELECT *,users.isActive as 'uIsActive' FROM users where userId != 0 and isDeleted != 1";

        $this->db->query($query);
        $_ = $this->db->single();
        $result[] = $this->db->rowCount();
        $result[] = $this->db->resultset();
        return $result;
    }

    public function getMaxId()
    {
        $this->db->query("SELECT MAX(userId) AS max_id  FROM users");
        $row = $this->db->single();
        return $row->max_id;
    }

    public function addUser($data)
    {

        $maxID = $this->getMaxId();
        $this->db->query('INSERT INTO `users`( `name`, `userName`, `password`,createdBy)
               VALUES (:name, :userName, :password,:createdBy)');

        // Bind Values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':userName', $data['userName']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':createdBy', $data['createdBy']);

        //Execute
        if ($this->db->execute()) {
            if ($this->addPermission($data['permissions'], $maxID + 1)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function changePermissions($data)
    {
        $q = "Delete from userpermissions  WHERE userId= :id ";
        $this->db->query($q);

        // Bind Values
        $this->db->bind(':id', $data['uId']);
        if ($this->db->execute()) {
            if ($this->addPermission($data['permissions'], $data['uId'])) {
                return true;
            }
        } else {
            return false;
        }

    }

    public function addPermission($data, $userId)
    {
        $x = json_decode($data);
        $sql = 'INSERT INTO userpermissions (pId,userId)  VALUES ';
        $elements = array();
        for ($i = 0; $i < count($x); $i++) {
            $elements[] = ('(:pId' . $i . ',:userId' . $i . ')');
        }
        $query = $sql . implode(',', $elements) . ";";
        $this->db->query($query . ";");
        for ($i = 0; $i < count($x); $i++) {
            $this->db->bind(':userId' . $i, $userId);
            $this->db->bind(':pId' . $i, $x[$i]);
        }

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // Add User / Register
    public function register($data)
    {
        // Prepare Query
        $this->db->query('INSERT INTO users (name, userName,password)
      VALUES (:name, :userName, :password)');

        // Bind Values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':userName', $data['userName']);
        $this->db->bind(':password', $data['password']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findUserNameToChangePassword($userName)
    {
        $this->db->query("SELECT * FROM users
                                 WHERE (users.userName LIKE :userName)");

        $this->db->bind(':userName', $userName);

        $row = $this->db->single();

        //Check Rows
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Find USer BY userName
    public function findUserByUserName($userName)
    {
        $this->db->query("SELECT * FROM users
                                WHERE (users.userName LIKE :userName)
                                 and (users.isActive = 1)
                                 and (users.isDeleted = 0)");

        $this->db->bind(':userName', $userName);
        $this->db->single();
        //Check Rows
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Login / Authenticate User
    public function login($userName, $password)
    {

        $this->db->query("SELECT *, users.uImgDeleted as 'uImgD',users.img as 'UImg'
                                 FROM users
                                 inner join userpermissions on users.userId = userpermissions.userId
                                 inner join permissions on userpermissions.pId = permissions.pId                          
                                 WHERE (users.userName LIKE :userName)
                                 and (users.isActive = 1)
                                 and (users.isDeleted = 0)");
        $this->db->bind(':userName', $userName);
        $row = $this->db->single();
        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    // Find User By ID
    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM users WHERE userId = :id");
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getUserNameById($id)
    {
        $this->db->query("SELECT name FROM users WHERE userId = :id");
        $this->db->bind(':id', $id);

        return $this->db->single();
    }


    public function getReceiverById($id)
    {
        $this->db->query("SELECT name,img FROM users WHERE userId = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updatePassword($data): bool
    {

        $q = "Update `users` set password = :password  WHERE userId= :id ";

        // Prepare Query
        $this->db->query($q);

        // Bind Values
        $this->db->bind(':password', $data["password"]);
        $this->db->bind(':id', $data["id"]);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($data)
    {

        $q = "Update `users` set " . $data["name"] . " = ?  WHERE userId= ? ";

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

    function setImgName($_tempImgName, $_imgName)
    {
        $this->tempImgName = $_tempImgName;
        $this->imgName = $_imgName;
    }

    public function replaceImg($data)
    {
        $path_parts = pathinfo($this->imgName);
        $ext = $path_parts['extension'];
        $newName = "";
        if ($this->tempImgName != "") {
            $newName = basename(rand() . "_" . time() . "." . $ext);
        } else {
            $newName = URLROOT . "/images/statics/placeHolder.png";
        }

        $q = "Update `users` set  img = :img,uImgDeleted=0  WHERE userId= :id ";
        $this->db->query($q);

// Bind Values
        $this->db->bind(':img', $newName);
        $this->db->bind(':id', $data['id']);


        // Writes the photo to the server
        if ($this->tempImgName != "") {

            $upOne = realpath(dirname(__FILE__) . '/../..');
            $target = $upOne . "/public/images/uploads/users/";
            $finalPathName = $target . $newName;

            $files = glob($target . '/' . $data['id'] . '*'); // get all file names
            foreach ($files as $file) { // iterate files
                if (is_file($file))
                    @unlink($file); // delete file
            }

            if (move_uploaded_file($this->tempImgName, $finalPathName)) {
                if ($this->db->execute()) {
                    //  echo "The file " . basename($this->imgName) . " has been uploaded, and your information has been added to the directory";
                    return true;
                } else {
                    return false;
                }
                // Tells you if its all ok
            } else {
                // Gives and error if its not
                //  echo "Sorry, there was a problem uploading your file.";
                return false;
            }
        }

    }

    // loadPermission
    public function loadPermission($userId)
    {
        $query = "SELECT p.pId, p.pName
         FROM users
         INNER JOIN userpermissions up ON users.userId = up.userId
         INNER JOIN permissions p ON p.pId = up.pId
         WHERE (users.userId = :userId)
         AND (users.isActive = 1)
         AND (users.isDeleted = 0)";

        $this->db->query($query);
        $this->db->bind(':userId', $userId);

        return $this->db->resultset();
    }
}
