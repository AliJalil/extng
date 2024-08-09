<?php

class Users extends Controller
{
    public $userModel;
    public $permissionModel;


    public function __construct()
    {

        $this->userModel = $this->model('User');
        $this->permissionModel = $this->model('Permission');

    }

    public function index()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $draw = $_POST['draw'];
            $result = $this->userModel->getUsers();
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $result[0],
                "iTotalDisplayRecords" => $result[0],
                "aaData" => $result[1],
            );
            echo json_encode($response);

        } else {
            $permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');
            $permissions = json_encode($this->permissionModel->getPermissions());
            $data = [
                'permissions' => $permissionsArray,
                'permissionsToSet' => $permissions,
            ];

            $this->view('users/index', $data);

        }
    }


    public function replaceImage()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');
        if (!checkPermission($permissionsArray, 'EditUser')) {
            redirect('main/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (isset($_FILES['img']) != '') {

                $filename = $_FILES['img']['tmp_name'];
                $size = getimagesize($filename);
                if ($size === false) {
                    $Post_error = "50";
                    echo json_encode(array($Post_error));
                    die();
                }
                if ($size[0] > 5000 || $size[1] > 5000) {
                    $Post_error = "50";
                    echo json_encode(array($Post_error));
                    die();
                }
//                if (!$img = @imagecreatefromstring(file_get_contents($filename))) {
//                    $Post_error = "50";
//                    echo json_encode(array($Post_error));
//                    die();
//                }

                $this->userModel->setImgName($_FILES['img']['tmp_name'], $_FILES['img']['name']);
            }


            $data = [
                'id' => trim($_POST['id'])
            ];

            if ($this->userModel->replaceImg($data)) {
                $Post_error = "succ";
                echo json_encode(array($Post_error));
                die();

            } else {
                $Post_error = "err";
                echo json_encode(array($Post_error));
                die();

            }


        } else {
            // IF NOT A POST REQUEST

            $users = $this->userModel->getusers();

            $data = [
                'users' => $users
            ];


            // Load View
            $this->view('users', $data);
        }
    }

    public function add()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');
        if (!checkPermission($permissionsArray, 'AddUser')) {
            redirect('main/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'userName' => trim($_POST['userName']),
                'password' => trim($_POST['password']),
                'permissions' => trim($_POST['permissions']),
                'confirm_password' => trim($_POST['confirm_password']),
                'createdBy' => 0,//$_SESSION['lostVUserId'],
            ];

            // Validate userName
            if (empty($data['userName'])) {
                $Post_error = "10";
                echo json_encode(array($Post_error));
                die();
            } else if (preg_match("/[^a-zA-Z0-9]+/", $data['userName'])) {
                $Post_error = "11";
                echo json_encode(array($Post_error));
                die();
            } else {
                // Check userName
                if ($this->userModel->findUserByUserName($data['userName'])) {
                    $Post_error = "12";
                    echo json_encode(array($Post_error));
                    die();
                }
            }

            if (empty($data['name'])) {
                $Post_error = "20";
                echo json_encode(array($Post_error));
                die();
            }


            // Validate password
            if (empty($data['password'])) {
                $Post_error = "30";
                echo json_encode(array($Post_error));
                die();

            } elseif (strlen($data['password']) < 8) {
                $Post_error = "31";
                echo json_encode(array($Post_error));
                die();
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $Post_error = "40";
                echo json_encode(array($Post_error));
                die();
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $Post_error = "41";
                    echo json_encode(array($Post_error));
                    die();
                }
            }


            // Hash Password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            //Execute
            if (!$this->userModel->addUser($data)) {
                die();
            }

            $Post_error = "200";
            echo json_encode(array($Post_error));
            die();

        } else {
            // IF NOT A POST REQUEST
            // Load View
            $this->view('users/index', []);
        }
    }

    public function login($isApp =0)
    {
//        if (isLoggedIn()) {
//            redirect('main/index');
//        }

        // Check if POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'userName' => trim($_POST['userName']),
                'password' => trim($_POST['password']),
            ];

            // Check for email
            if (empty($data['userName'])) {
                $Post_error = "10";
                echo json_encode(array($Post_error));
                die();
            }

            // Check for name
            if (empty($data['password'])) {
                $Post_error = "11";
                echo json_encode(array($Post_error));
                die();
            }

            // Check for user
            if (!$this->userModel->findUserByUserName($data['userName'])) {
                // No User
                $Post_error = "12";
                echo json_encode(array($Post_error));
                die();
            }


            // Check and set logged in user
            $loggedInUser = $this->userModel->login($data['userName'], $data['password']);


            if ($loggedInUser) {
                // User Authenticated!

                if($isApp ==1)
                {
                    $permissions = array_column($this->userModel->loadPermission($loggedInUser->userId), 'pName');
                    $this->createUserJwt($loggedInUser,$permissions);
                }
                else{

                    $this->createUserSession($loggedInUser);
                }
            } else {
                $Post_error = "12";
                echo json_encode(array($Post_error));
                die();
            }

        } else {
            //Load View
            $this->view('users/login', []);
        }
    }


    // Create User Session
    public function createUserJwt($user, $permissions)
    {
        $headers = array('alg' => 'HS256', 'typ' => 'JWT');
        $payload = array('username' => $user->name, 'id' => $user->userId,  'exp' => (time() + 10800));

        $jwt = generate_jwt($headers, $payload);


        die(json_encode(array(
            'userId' => $user->userId,
            'name' => $user->name,
            'token' => $jwt,
            'permissions' => []//$permissions,

        )));
    }
    // Create Session With User Info
    public function createUserSession($user)
    {


        $_SESSION['extUserId'] = $user->userId;
        $_SESSION['user_name'] = $user->userName;
        $_SESSION['Uname'] = $user->name;

        $_SESSION['UImg'] = $user->UImg;


        if ($user->uImgD == 0) {
            $_SESSION['uImgD'] = "1";
        }

        $Post_error = "1";
        echo json_encode(array($Post_error));
    }

    // Logout & Destroy Session
    public function logout()
    {
        unset($_SESSION['extUserId']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['Uname']);
        unset($_SESSION['center_name']);
        unset($_SESSION['cPhone']);
        unset($_SESSION['uCenterId']);

        unset($_SESSION['UImg']);
        unset($_SESSION['uImgD']);

        unset($_SESSION['isAdmin']);

        session_destroy();
        redirect('users/login');
    }

    // Check Logged In
    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

            $data = [
                'userName' => trim($_POST['userName']),
                'newPassword' => trim($_POST['newPassword']),
                'newPasswordConform' => trim($_POST['newPasswordConform']),
                'id' => trim($_POST['uId'])
            ];


            if (empty($data['userName']) || empty($data['newPassword']) || empty($data['newPasswordConform'])) {
                $Post_error = "40";
                echo json_encode(array($Post_error));
                die();
            }

            if ($data['newPassword'] != $data['newPasswordConform']) {
                $Post_error = "41";
                echo json_encode(array($Post_error));
                die();
            }


//                $loggedInUser = $this->userModel->login($data['userName'], $data['prePassword']);

            // Check for user
            if ($this->userModel->findUserNameToChangePassword($data['userName'])) {
                // User Found
                $dataU['password'] = password_hash($data['newPassword'], PASSWORD_DEFAULT);
                $dataU['id'] = $data['id'];

                if ($this->userModel->updatePassword($dataU)) {
                    $Post_error = "200";
                    echo json_encode(array($Post_error));
                } else {

                    die('error');
                }

            } else {
                die('user Not found');
            }

        } else {

            $this->index();
        }
    }

    public function changeUserPassword()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');
        if (!checkPermission($permissionsArray, 'EditUser')) {
            redirect('main/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

            $data = [
                'newPassword' => trim($_POST['newPassword']),
                'newPasswordConform' => trim($_POST['newPasswordConform']),
                'id' => trim($_POST['uId'])
            ];


            if (empty($data['newPassword']) || empty($data['newPasswordConform'])) {
                $Post_error = "40";
                echo json_encode(array($Post_error));
                die();
            }

            if ($data['newPassword'] != $data['newPasswordConform']) {
                $Post_error = "41";
                echo json_encode(array($Post_error));
                die();
            }

            $dataU['password'] = password_hash(trim($data['newPassword']), PASSWORD_DEFAULT);
            $dataU['id'] = $data['id'];

            if ($this->userModel->updatePassword($dataU)) {
                $Post_error = "200";
                echo json_encode(array($Post_error));
            } else {

                die('error');
            }

        } else {

            $this->index();
        }
    }

    public function changePermission()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');
        if (!checkPermission($permissionsArray, 'EditUser')) {
            redirect('main/index');
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $data = [
                'permissions' => trim($_POST['permissions']),
                'uId' => trim($_POST['uId'])
            ];
            if ($this->userModel->changePermissions($data)) {
                $Post_error = "200";
                echo json_encode(array($Post_error));
            } else {
                die('error');
            }

        } else {
            $this->index();
        }
    }

    public function edit()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');
        if (!checkPermission($permissionsArray, 'EditUser')) {
            redirect('main/index');
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

            $params = $_POST;
            if (isset($params['name']) && isset($params['value']) && isset($params['pk'])) {

                if ($params['name'] == 'name' || $params['name'] == 'userName'
                    || $params['name'] == 'isActive' || $params['name'] == 'isDeleted' || $params['name'] == 'state'
                    || $params['name'] == 'uImgDeleted') {

                    $data = [
                        'name' => trim($params["name"]),
                        'value' => trim($params["value"]),
                        'pk' => trim($params["pk"])
                    ];

                    if ((trim($params["name"]) != 'isActive') && trim($params["name"]) != 'isAdmin') {
                        if (empty($data['name']) || empty($data['value']) || empty($data['pk'])) {
                            $Post_error = "err";
                            echo json_encode(array($Post_error));
                            die();
                        }
                    }
                }

            } else {
                $Post_error = "err";
                echo json_encode(array($Post_error));
                die();
            }


            if ($this->userModel->updateUser($data)) {
                $Post_error = "succ";
                echo json_encode(array($Post_error));
            } else {
                die('');
            }

        } else {

            $this->index();
        }
    }

    public function getPermissionsByUserId()
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'userId' => isset($_POST['userId']) ? trim($_POST['userId']) : 0
            ];
            echo json_encode($this->permissionModel->getPermissionsByUserId($data['userId']));
//            echo json_encode($this->permissionModel->getPermissionsByUserId($userId));


        }
    }

    public function getUserById($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo json_encode($this->userModel->getUserNameById($userId));
        }
    }

}
