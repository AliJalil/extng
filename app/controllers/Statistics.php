<?php

class Statistics extends Controller
{

    public $userModel;
    public $permissionModel;
    public $permissionsArray;
    public $typeModel;
    public $specificationModel;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->giftModel = $this->model('Extinguisher');
        $this->typeModel = $this->model('Type');
        $this->specificationModel = $this->model('Specification');
        $this->permissionModel = $this->model('Permission');
        $this->userModel = $this->model('User');
        $this->permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), 'pName');

    }


    public function index()
    {

        if (!checkPermission($this->permissionsArray, 'StatementView')) {
            redirect('main/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $types = $this->typeModel->getJsonTypes();
            $specifications = $this->specificationModel->getJsonSpecifications();

            $data = [
                'types' => $types,
                'specifications' => $specifications,
                'permissions' => $this->permissionsArray
            ];
            // Load View
            $this->view('statistics/index', $data);
        }
    }

    public function summary($sId = 0, $dTypeId = 0, $tId = 0)
    {

        if (!checkPermission($this->permissionsArray, 'StatementView')) {
            redirect('main/index');
        }

//        86400
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

//            $fromDate = isset($_POST['from_date']) ? strtotime(DateTime::createFromFormat('Y-m-dTH:i:s', $_POST['from_date'])->format('m/d/YTH:i')) : strtotime(date('m/d/YTH:i:s'));
//            $toDate = isset($_POST['to_date']) ? strtotime(DateTime::createFromFormat('Y-m-dTH:i:s', $_POST['to_date'])->format('m/d/YTH:i')) : strtotime(date('m/d/YTH:i:s'));
            $fromDate = isset($_POST['from_date']) ? strtotime($_POST['from_date']) : strtotime(date('m/d/YTH:i:s'));
            $toDate = isset($_POST['to_date']) ? strtotime($_POST['to_date']) : strtotime(date('m/d/YTH:i:s'));
            $users = $_POST['user'] ?? 0;

//            $users = explode(",", $users);
            $filterData = [
                'user' => $users,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'dTypeId' => $dTypeId ?? null,
                'tId' => $tId ?? null,
            ];

            $gifts = $this->giftModel->getStatistics($filterData);

            $data = [
                'gifts' => $gifts,
                'permissions' => $this->permissionsArray,
                'from_date' => $_POST['from_date'],
                'to_date' => $_POST['to_date'],
            ];
            if ($sId == 1 && $dTypeId == 4) {
                $data['animalBenefits'] = $this->giftModel->getAnimalBenefits($filterData);
            }

            echo json_encode($data);

        } else {

            $types = $this->typeModel->getJsonTypes();
            $specifications = $this->specificationModel->getJsonSpecifications();
            $users = $this->userModel->getJsonUsers();

            $data = [
                'types' => $types,
                'specifications' => $specifications,
                'permissions' => $this->permissionsArray,
                'users' => $users,
            ];


            if ($sId == 0) {
                if ($dTypeId == 0 || $dTypeId == 1) {
                    $this->view('statistics/summary', $data);
                } else if ($dTypeId == 2) {

                    $this->view('statistics/summary_gold', $data);
                }
            } else if ($sId == 1 && $dTypeId == 2) {
                $this->view('statistics/summary_specification_gold', $data);
            } else if ($sId == 1 && $dTypeId == 4) {

                $this->view('statistics/summary_animal', $data);
            } else {
                $this->view('statistics/summary_specification', $data);
            }
        }
    }


}
