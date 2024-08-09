<?php

class Manages extends Controller
{

    public $permissionModel;
    public $permissionsArray;
    public $typeModel;
    public $sizeModel;
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->giftModel = $this->model('Extinguisher');
        $this->typeModel = $this->model('Type');
        $this->sizeModel = $this->model('Size');
        $this->permissionModel = $this->model('Permission');
        $this->cashModel = $this->model('Size');
        $this->permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');

    }


    public function index()
    {
        if (!checkPermission($this->permissionsArray, 'ManagePage')) {
            redirect('main/index');
        }
        $types = $this->typeModel->getJsonTypes();
        $sizes = $this->sizeModel->getJsonSizes();

        $data = [
            'types' => $types,
            'sizes' => $sizes,
            'permissions' => $this->permissionsArray
        ];

        $this->view('manages/index', $data);

    }

    function getSizes()
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $iTotalRecords = $this->sizeModel->getSizeCount();

            if ($rowperpage == -1) {
                $rowperpage = $iTotalRecords;
            }

            $columns = $_POST['columns'];
            $newArr = [];
            foreach ($columns as $column) {
                if (!empty($column['search']['value'])) {
                    $newArr[trim($column['data'])] = $column['search']['value'];
                }
            }

            $result = $this->sizeModel->getSize($row, $rowperpage, $newArr);
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $iTotalRecords,
                "iTotalDisplayRecords" => $result[0],
                "aaData" => $result[1],
            );
            echo json_encode($response);
        }
    }

    function getTypes()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $iTotalRecords = $this->typeModel->getTypeCount();

            if ($rowperpage == -1) {
                $rowperpage = $iTotalRecords;
            }
            $columns = $_POST['columns'];
            $newArr = [];
            foreach ($columns as $column) {
                if (!empty($column['search']['value'])) {
                    $newArr[trim($column['data'])] = $column['search']['value'];
                }
            }

            $result = $this->typeModel->getType($row, $rowperpage, $newArr);
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $iTotalRecords,
                "iTotalDisplayRecords" => $result[0],
                "aaData" => $result[1],
            );
            echo json_encode($response);
        }
    }


    public function add($manageId = 0)
    {
        if (!checkPermission($this->permissionsArray, 'ManagePage')) {
            redirect('main/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if ($manageId == 1) {
                // Sanitize POST
                $data = [
                    'sName' => isset($_POST['sName']) ? trim($_POST['sName']) : '',
                    'createdBy' => isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0
                ];

                if ($this->sizeModel->addSize($data)) {
                    echo json_encode(array("200"));
                    die();
                } else {
                    die();
                }
            } else if ($manageId == 2) {
                $data = [
                    'price' => isset($_POST['price']) ? trim($_POST['price']) : '0',
                    'dType' => isset($_POST['dType']) ? trim($_POST['dType']) : '0',
                    'gName' => isset($_POST['gName']) ? trim($_POST['gName']) : '',
                    'createdBy' => isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0
                ];
                if ($this->typeModel->addType($data)) {
                    echo json_encode(array("200"));
                    die();
                } else {
                    die();
                }
            } else if ($manageId == 3) {

                $data = [
                    'dTypeId' => isset($_POST['dTypeId']) ? trim($_POST['dTypeId']) : '0',
                    'cName' => isset($_POST['cName']) ? trim($_POST['cName']) : '',
                    'amount' => isset($_POST['amount']) ? trim($_POST['amount']) : 0,
                    'createdBy' => isset($_SESSION['extUserId']) ? trim($_SESSION['extUserId']) : 0
                ];
                if ($this->cashModel->addCash($data)) {
                    echo json_encode(array("200"));
                    die();
                } else {
                    die();
                }
            }
        } else {
            $coins = $this->typeModel->getJsonTypes(1);
            $types = $this->typeModel->getJsonTypes();
            $specifications = $this->sizeModel->getJsonSpecifications();
            $donationTypes = $this->donationTypeModel->getJsonDonationTypes();
            $data = [
                'coins' => $coins,
                'types' => $types,
                'donationTypes' => $donationTypes,
                'specifications' => $specifications,
                'permissions' => $this->permissionsArray
            ];
            // Load View
            $this->view('manages/index', $data);
        }
    }


    public function edit($manageId = 0)
    {
        if (!checkPermission($this->permissionsArray, 'ManagePage')) {
            redirect('main/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $params = $_POST;
            if (isset($params['name']) && isset($params['value']) && isset($params['pk'])) {

                if ($params['name'] == 'dTypeId' || $params['name'] == 'cName' || $params['name'] == 'amount'
                    || $params['name'] == 'price' || $params['name'] == 'seqId'
                    || $params['name'] == 'sName' || $params['name'] == 'dType' || $params['name'] == 'tName'
                    || $params['name'] == 'isActive' || $params['name'] == 'isDeleted') {

                    $data = [
                        'name' => trim($params["name"]),
                        'value' => trim($params["value"]),
                        'pk' => trim($params["pk"])
                    ];

                    if (trim($params["name"]) != 'isActive' && trim($params["name"]) != 'isDeleted') {
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

            if ($manageId == 1) {
                if ($data['pk'] == 0) {
                    die();
                }
                if ($this->sizeModel->updateSize($data)) {
                    $Post_error = "succ";
                    echo json_encode(array($Post_error));
                }
            } else if ($manageId == 2) {
                if ($data['pk'] == 1 || $data['pk'] == 2) {
                    die();
                }
                if ($this->typeModel->updateType($data)) {
                    $Post_error = "succ";
                    echo json_encode(array($Post_error));
                }
            } else if ($manageId == 3) {
                if ($this->cashModel->updateCash($data)) {
                    $Post_error = "succ";
                    echo json_encode(array($Post_error));
                }
            } else {
                die('');
            }
        } else {
            $this->index();
        }
    }

}
