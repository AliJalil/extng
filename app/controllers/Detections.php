<?php

class Detections extends Controller
{


    public $userModel;
    public $permissionModel;
    public $permissionsArray;
    public $extingModel;
    public $typeModel;
    public $sizeModel;
    public $detectModel;
    public $detectionemps;
    public $detectInfo;
    private $extUserId;

    public function __construct()
    {

        if (isLoggedIn()) {
            $this->extUserId = $_SESSION['extUserId'];
        } else {
            $bearer_token = get_bearer_token();
            $jwt_payload = is_jwt_valid($bearer_token);
            if (!$jwt_payload) {
                http_response_code(401);
                die(json_encode(array('error' => 'Access denied')));
            }
            $this->extUserId = isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : $jwt_payload->userId;
        }
        if (!$this->extUserId) {
            http_response_code(401);
            die(json_encode(array('error' => 'Access denied')));
        }


        $this->extingModel = $this->model('Extinguisher');
        $this->detectModel = $this->model('Detect');
        $this->detectInfo = $this->model('DetectInfo');
        $this->userModel = $this->model('User');
        $this->typeModel = $this->model('Type');
        $this->sizeModel = $this->model('Size');
        $this->detectionemps = $this->model('DetectionEmps');
        $this->permissionModel = $this->model('Permission');
        $this->permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($this->extUserId), PERMISSION_COLUMN);

    }

    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $iTotalRecords = $this->detectModel->getDetectCount();

            if ($rowperpage == -1) {
                $rowperpage = $iTotalRecords;
            }
            $columns = $_POST['columns'];
            $newArr = [];
            foreach ($columns as $column) {
                if (isset($column['search']['value'])) {
                    $newArr[trim($column['data'])] = $column['search']['value'];
                }
            }


            $result = $this->detectModel->getDetection($row, $rowperpage, $newArr);
//
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $iTotalRecords,
                "iTotalDisplayRecords" => $result[0],
                "aaData" => $result[1],
            );

            echo json_encode($response);

        } else {

            $data = [
                'permissions' => $this->permissionsArray
            ];

            $this->view('detection/index', $data);
        }
    }

    public function details($detectionId = 0, $exId = 0, $userId = 0)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }

        if ($detectionId == 0 && $exId == 0 && $userId == 0) {
            redirect('main/index');
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $detectInfo = $this->detectInfo->getDetectionsInfo($detectionId, encrypt_decrypt($exId, 'decrypt'), $userId);
            $data = [
                'detectInfo' => $detectInfo,
                'permissions' => $this->permissionsArray,
            ];
            echo json_encode($data);

        } else {
            $data = [
                'permissions' => $this->permissionsArray
            ];
            $this->view('detection/details', $data);
        }
    }


    public function addDetectionInfo($detectionId = 0, $exId = 0)
    {

        if (!isLoggedIn() && !$this->extUserId) {
            echo "invalid request";
            die();
        }

        if ($exId == 0) {
            echo "extinguisher undefined";
            die();
        }

        $currentDetection = $this->detectModel->getCurrentDetection();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'deId' => $currentDetection->dId,
                'exId' => encrypt_decrypt($exId, 'decrypt'),
                'assignTo' => isset($_POST['assignTo']) ? trim($_POST['assignTo']) : 0,
                'isThere' => isset($_POST['isThere']) ? trim($_POST['isThere']) : 0,
                'lockIsGood' => isset($_POST['lockIsGood']) ? trim($_POST['lockIsGood']) : 0,
                'gageIsGood' => isset($_POST['gageIsGood']) ? trim($_POST['gageIsGood']) : 0,
                'jetIsGood' => isset($_POST['jetIsGood']) ? trim($_POST['jetIsGood']) : 0,
                'handleIsGood' => isset($_POST['handleIsGood']) ? trim($_POST['handleIsGood']) : 0,
                'isUsed' => isset($_POST['isUsed']) ? trim($_POST['isUsed']) : 0,
                'notes' => isset($_POST['notes']) ? trim($_POST['notes']) : "",
                'gps' => isset($_POST['gps']) ? trim($_POST['gps']) : "",
                'createdBy' => $this->extUserId,

            ];

            $addResult = $this->detectInfo->addDetectionsInfo($data);
            if ($addResult) {
                echo json_encode("200");
                die();
            }
            die();
        } else {
            $exId = encrypt_decrypt($exId, 'decrypt');
            $currentExting = $this->extingModel->getExtinguisherById($exId);

            $data = [
                'currentExting' => $currentExting,
                'currentDetection' => $currentDetection,
                'permissions' => $this->permissionsArray
            ];

            if ($currentExting != null) {
                $this->view('detection/addDetectionInfo', $data);
            } else {
                $this->view('qr/notfound', $data);
            }
        }
    }

    public function add()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'dName' => isset($_POST['dName']) ? trim($_POST['dName']) : '',
                'startIn' => isset($_POST['startIn']) ? trim($_POST['startIn']) : '',
                'endAt' => isset($_POST['endAt']) ? trim($_POST['endAt']) : '',
                'notes' => isset($_POST['notes']) ? trim($_POST['notes']) : '',
                'createdBy' => isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0
            ];

            $addResult = $this->detectModel->addDetect($data);
            if ($addResult) {
                echo json_encode("200");
                die();
            }
            die();
        } else {
            $data = [
                'permissions' => $this->permissionsArray
            ];
            $this->view('detection/add', $data);
        }
    }

    public function edit()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        if (!checkPermission($this->permissionsArray, 'EditGift')) {
            redirect('main/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $params = $_POST;
            if (isset($params['name']) && isset($params['value']) && isset($params['pk'])) {

                if ($params['name'] == 'dName' || $params['name'] == 'startIn' || $params['name'] == 'endAt' || $params['name'] == 'isCurrent' || $params['name'] == 'notes'
                    || $params['name'] == 'isActive' || $params['name'] == 'isDeleted') {

                    $data = [
                        'name' => trim($params["name"]),
                        'value' => trim($params["value"]),
                        'pk' => $params["pk"],
                    ];

                    if (trim($params["name"]) != 'isActive' && trim($params["name"]) != 'isDeleted' && trim($params["name"]) != 'isCurrent') {
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

            $data['userId'] = isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0;
            if ($this->detectModel->updateDetection($data)) {
                $Post_error = "succ";
                echo json_encode(array($Post_error));
            } else {
                die('');
            }
        } else {

            $this->index();
        }
    }

    public function detect()
    {

        if (!checkPermission($this->permissionsArray, 'ManagePage')) {
            redirect('main/index');
        }
        $currentDetection = $this->detectModel->getCurrentDetection();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $exIds = json_decode(html_entity_decode($_POST['exIds']));
            $userIds = json_decode(html_entity_decode($_POST['userIds']));

            $data = [
                'exIds' => $exIds,
                'userIds' => $userIds,
                'dId' => $currentDetection->dId,
                'user_id' => isset($_SESSION['user_id']) != '' ? $_SESSION['user_id'] : 0,
            ];

            if ($this->detectionemps->deleteAdd($data)) {
                $Post_error = "200";
                echo json_encode(array($Post_error));
            } else {
                print_r("Not exist");
            }
            die();

        } else {
            $extinguishersSelected = $this->detectionemps->getExtInDetection($currentDetection->dId);
            $extinguishersNotSelected = $this->detectionemps->getExtNotInDetection($currentDetection->dId);
            $users = $this->userModel->getJsonUsers();

            $data = [
                'extinguishersSelected' => $extinguishersSelected,
                'extinguishersNotSelected' => $extinguishersNotSelected,
                'permissions' => $this->permissionsArray,
                'users' => $users,
            ];
            $this->view('detection/detect', $data);
        }
    }

    public function getUserDetections($exId = 0)
    {
        if (!isLoggedIn() && !$this->extUserId) {
            echo "invalid request";
            die();
        }
        $currentDetection = $this->detectModel->getCurrentDetection();
        $detectionId =$currentDetection->dId;
        $userId = $this->extUserId;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            $detectInfo = $this->detectInfo->getDetectionsInfo($detectionId, encrypt_decrypt($exId, 'decrypt'), $userId);
            $detectInfo = $this->detectInfo->getDetectionsInfo($detectionId,0, $userId);
            foreach ($detectInfo as $key => $item) {
                $item->exId = encrypt_decrypt($item->exId);
            }
            $data = [
                'detectInfo' => $detectInfo
            ];
            echo json_encode($data);

        }
    }

}
