<?php

class Charts extends Controller
{
    public function __construct()
    {

        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->giftModel = $this->model('Extinguisher');
        $this->userModel = $this->model('User');
        $this->typeModel = $this->model('Type');
        $this->specificationModel = $this->model('Specification');
        $this->cashModel = $this->model('Size');
        $this->permissionModel = $this->model('Permission');
        $this->permissionsArray = array_column($this->permissionModel->getPermissionsByUserId($_SESSION['extUserId']), PERMISSION_COLUMN);

    }


    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            $draw = $_POST['draw'];
//            $row = $_POST['start'];
//            $rowperpage = $_POST['length']; // Rows display per page
//            $iTotalRecords = $this->giftModel->getGiftsCount($gTypeId);
//
//            if ($rowperpage == -1) {
//                $rowperpage = $iTotalRecords;
//            }
//            $columns = $_POST['columns'];
//            $newArr = [];
//            foreach ($columns as $column) {
//                if (!empty($column['search']['value'])) {
//                    $newArr[trim($column['data'])] = $column['search']['value'];
//                }
//            }
//
////            $fromDate = isset($_POST['from_date']) ? strtotime(DateTime::createFromFormat('Y-m-d', $_POST['from_date'])->format('m/d/Y')) : strtotime(date('m/d/Y'));
////            $toDate = isset($_POST['to_date']) ? strtotime(DateTime::createFromFormat('Y-m-d', $_POST['to_date'])->format('m/d/Y')) : strtotime(date('m/d/Y'));
//
//
//            $fromDate = isset($_POST['from_date']) ? strtotime($_POST['from_date']) : strtotime(date('m/d/YTH:i:s'));
//            $toDate = isset($_POST['to_date']) ? strtotime($_POST['to_date']) : strtotime(date('m/d/YTH:i:s'));
//
//
//            $newArr ['fromDate'] = $fromDate - 86400;
//            $newArr ['toDate'] = $toDate + 86400;
//
//
//            $result = $this->giftModel->getGift($row, $rowperpage, $newArr, $gTypeId);
//            $response = array(
//                "draw" => intval($draw),
//                "iTotalRecords" => $iTotalRecords,
//                "iTotalDisplayRecords" => $result[0],
//                "aaData" => $result[1],
//            );
//
//            echo json_encode($response);

        } else {


            $moneyCounts = $this->convertDataToChartForm($this->giftModel->getGiftSumAmountById(1));
            $goldCounts = $this->convertDataToChartForm($this->giftModel->getGiftSumAmountById(2));
            $specifications = $this->convertDataToChartForm($this->giftModel->getGiftSumAmountBySpecifications(1));
            $data = [
                'moneyCounts' => $moneyCounts,
                'goldCounts' => $goldCounts,
                'specifications' => $specifications,
                'permissions' => $this->permissionsArray
            ];
            $this->view('charts/index', $data);
        }
    }

    function convertDataToChartForm($data)
    {
        $newData = "";
        $i = 0;
        while ($i < count($data) - 1) {
            $newData .= "['" . $data[$i]->text . "'," . intval($data[$i]->value) . "],";
            $i++;
        }
        $newData .= "['" . $data[$i]->text . "'," . intval($data[$i]->value) . "]";
        return $newData;
    }
}
