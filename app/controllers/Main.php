<?php

class Main extends Controller
{
    public function __construct()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        $this->extingModel = $this->model('Extinguisher');
        $this->userModel = $this->model('User');
        $this->typeModel = $this->model('Type');
        $this->specificationModel = $this->model('Specification');
        $this->sizeModel = $this->model('Size');
        $this->permissionModel = $this->model('Permission');
        $this->permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), PERMISSION_COLUMN);

    }


    public function index($gTypeId = 0)
    {

        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'exSeq' => isset($_POST['exSeq']) ? trim($_POST['exSeq']) : 0,
                'exNo' => isset($_POST['exNo']) ? trim($_POST['exNo']) : 0,
                'exType' => isset($_POST['exType']) ? trim($_POST['exType']) : 0,
                'exSize' => isset($_POST['exSize']) ? trim($_POST['exSize']) : 0,
                'exPlace' => isset($_POST['exPlace']) ? trim($_POST['exPlace']) : '',
                'notes' => isset($_POST['notes']) ? trim($_POST['notes']) : "",
                'createdBy' => isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0
            ];


            $addResult = $this->extingModel->addExt($data);
            if ($addResult) {
                echo json_encode("200");
                die();
            }
            die();

        } else {

            $sizes = $this->sizeModel->getJsonSizes();
            $types = $this->typeModel->getJsonTypes();

            $data = [
                'sizes' => $sizes,
                'types' => $types,
                'permissions' => $this->permissionsArray
            ];
            // Load View
            if ($gTypeId == 1) {
                $this->view('extng/add', $data);
            } else {
                $this->view('main/index', $data);
            }

        }
    }

    public function details($gTypeId, $isGOldStatics = 0)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $iTotalRecords = $this->extingModel->getExtinguisherCount($gTypeId, $isGOldStatics);

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


            $result = $this->extingModel->getExtinguisher($row, $rowperpage, $newArr);
//            foreach ($result[1] as $key => $item) {
//                $result[1][$key]->gGId = encrypt_decrypt($item->gId);
//            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $iTotalRecords,
                "iTotalDisplayRecords" => $result[0],
                "aaData" => $result[1],
            );

            echo json_encode($response);

        } else {

            $types = $this->typeModel->getJsonTypes();
            $sizes = $this->sizeModel->getJsonSizes();
            $data = [
                'types' => $types,
                'sizes' => $sizes,
                'permissions' => $this->permissionsArray
            ];

            $this->view('extng/details', $data);
        }
    }

    public function edit()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        if (!checkPermission($this->permissionsArray, 'EditGift')
            && !checkPermission($this->permissionsArray, 'SubEdit')
            && !checkPermission($this->permissionsArray, 'GoldExpert')
            && !checkPermission($this->permissionsArray, 'Checker')
            && !checkPermission($this->permissionsArray, 'StateChange')) {
            redirect('main/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $params = $_POST;
            if (isset($params['name']) && isset($params['value']) && isset($params['pk'])) {

                if ($params['name'] == 'exId' || $params['name'] == 'exSeq' || $params['name'] == 'exNo' || $params['name'] == 'exName' || $params['name'] == 'exType'
                    || $params['name'] == 'exSize' || $params['name'] == 'exPlace' || $params['name'] == 'notes' || $params['name'] == 'state'
                    || $params['name'] == 'isActive' || $params['name'] == 'isDeleted') {

                    $data = [
                        'name' => trim($params["name"]),
                        'value' => trim($params["value"]),
                        'pk' => trim($params["pk"])
                    ];

                    if (trim($params["name"]) != 'isActive' && trim($params["name"]) != 'isDeleted' && trim($params["name"]) != 'state') {
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
            if ($this->extingModel->updateGift($data)) {
                $Post_error = "succ";
                echo json_encode(array($Post_error));
            } else {
                die('');
            }
        } else {

            $this->index();
        }
    }

    public function print($gId = 0)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        $gId = encrypt_decrypt($gId, 'decrypt');
        $gift = $this->extingModel->getGiftById($gId);

        if ($gId != 0 && $gift) {
            $mGift = $this->extingModel->getGiftById($gId);
            $user = $this->userModel->getReceiverById($mGift->createdBy);
            $data = [
                'user' => $user,
                'gift' => $mGift,
                'permissions' => $this->permissionsArray
            ];
            $this->view('print/index', $data);
        } else {
            $this->index();
        }
    }

    public function animal($gId = 0)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        $gId = encrypt_decrypt($gId, 'decrypt');
        $gift = $this->extingModel->getGiftById($gId);

        if ($gId != 0 && $gift) {
            $mGift = $this->extingModel->getGiftById($gId);
            $user = $this->userModel->getReceiverById($mGift->createdBy);
            $data = [
                'user' => $user,
                'gift' => $mGift,
                'permissions' => $this->permissionsArray
            ];
            $this->view('print/animal', $data);
        } else {
            $this->index();
        }
    }

    public function item($gId = 0)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        $gId = encrypt_decrypt($gId, 'decrypt');
        $gift = $this->extingModel->getGiftById($gId);

        if ($gId != 0 && $gift) {
            $mGift = $this->extingModel->getGiftById($gId);
            $user = $this->userModel->getReceiverById($mGift->createdBy);
            $data = [
                'user' => $user,
                'gift' => $mGift,
                'permissions' => $this->permissionsArray
            ];
            $this->view('print/item', $data);
        } else {
            $this->index();
        }
    }

    public function gold($gId = 0)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }
        $gId = encrypt_decrypt($gId, 'decrypt');
        $gift = $this->extingModel->getGiftById($gId);

        if ($gId != 0 && $gift) {
            $mGift = $this->extingModel->getGiftById($gId);
            $user = $this->userModel->getReceiverById($mGift->createdBy);
            $data = [
                'user' => $user,
                'gift' => $mGift,
                'permissions' => $this->permissionsArray
            ];
            $this->view('print/gold', $data);
        } else {
            $this->index();
        }
    }

    public function cash($cId, $cashAmount = 1)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            die();
        }

        $cashToAdd = $this->sizeModel->getCashById($cId);
        $data = [
            'amountExtra' => isset($_POST['amountExtra']) ? trim($_POST['amountExtra']) : 0,
            'notes' => isset($_POST['notes']) ? trim($_POST['notes']) : "?????? ????????",
            'dName' => '?????? ????????????????',
            'details' => $cashToAdd->cName,
            'amount' => number_format(((int)$cashToAdd->amount * (int)$cashAmount), 0),
            'tId' => $cashToAdd->dTypeId,
            'sId' => 0,
            'benefitSide' => '',
            'authorizedName' => '',
            'createdBy' => isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0
        ];

        $addResult = $this->extingModel->addExt($data);
        $gift = $this->extingModel->getGiftById($addResult);

        if ($cId != 0 && $gift) {
            $user = $this->userModel->getReceiverById($_SESSION['extUserId']);

            $data = [
                'user' => $user,
                'gift' => $gift,
                'permissions' => $this->permissionsArray
            ];
            $this->view('print/cash', $data);
        } else {
            $this->index();
        }
    }

    public function chart()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->view('charts/index', []);
    }
}
