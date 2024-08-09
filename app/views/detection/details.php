<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<script src="<?php echo URLROOT . "/public/js/lodash.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/detectPage.css" ?>" crossorigin="anonymous">

<div class="MA-vistitem2">


    <a href="<?php echo URLROOT . "/main/index"; ?>">
        <button class="ma-backf"><i style="font-weight: bold; padding-top: 10px;" class="far fa-arrow-right"
                                    aria-hidden="true"></i></button>
    </a><span class="mainm">التفاصيل</span>

    <div class="col-md-12" style="display: flex; justify-content: space-between;">

        <div class="not-print" style="margin-right: 10px">
            <button class="btn btn-default btn-sm btn-exp not-print" onclick="window.print(); ">طباعة</button>
        </div>

        <div class="search-container col-md-4 not-print" style="text-align: left;">
            <input style="height: 30px;    border-radius: 3px;padding: 5px" class="input-medium search-query"
                   id="searcher" placeholder="ابحث هنا">
        </div>
    </div>
    <div id="detailsDiv" class="row" style="display: flex;justify-content: center;">
    </div>

</div>

<script>
    $(document).ready(function () {

        getData();

        function getData() {
            const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) + 1 );
            console.log(path);
            // const pathValues = location.pathname.split("/");
            // const lastThreeComponents = pathValues.slice(-3).join("/");
            // console.log(lastThreeComponents);
            $.ajax({
                    url: '<?php echo URLROOT . "/detections/details/";?>' + path,
                    method: "post",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        bindData($.parseJSON(data))
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        showAlert('error', "خطأ: " + errorThrown);
                    },
                }
            );
        }

        function bindData(data) {
            $('#detailsDiv').empty();
            const detectionInfo = data.detectInfo;
            const userNames = Array.from(new Set(detectionInfo.map((item) => item.name)));
            const showItems = _.groupBy(detectionInfo, dectInfo => dectInfo.name);
            let rowC = 0;
            const yesValue = 'نعم';
            const noValue = 'لا';

            userNames.forEach(itemParent => {
                const objs = showItems[itemParent];

                let cardContent = `<a style="color: #A39E94 !important;margin: 3px;background: #E2E0DB;font-weight: bold" class="btn" data-bs-toggle="collapse" href="#collapseCard${rowC}" role="button" aria-expanded="false" aria-controls="collapseExample">${itemParent}</a>
                                   <div class="collapse" id="collapseCard${rowC}">`;
                rowC += 1;
                objs.forEach(item => {
                    cardContent += `
                          <div class="detectCard col-md-12" style="width: auto !important;">
                            <h5 style="color: black" class="card-title">${item.exName}  |  ${item.exNo}</h5>
                            <div class="card-body">
                              <div>
                                <h6>هل المطفأة موجودة</h6>
                                <p>${item.isThere === 1 ? yesValue : noValue}</p>
                              </div>
                               <div>
                                <h6>هل البسمار جيد</h6>
                                <p>${item.lockIsGood === 1 ? yesValue : noValue}</p>
                              </div>
                              <div>
                                <h6>هل عداد الضغط جيد</h6>
                                <p>${item.gageIsGood === 1 ? yesValue : noValue}</p>
                              </div>
                              <div>
                                <h6>هل حالة الخرطوم جيدة</h6>
                                <p>${item.jetIsGood === 1 ? yesValue : noValue}</p>
                              </div>
                              <div>
                                <h6>هل حالة المقبض جيدة</h6>
                                <p>${item.handleIsGood === 1 ? yesValue : noValue}</p>
                              </div>
                              <div>
                                <h6>هل المطفأة مستخدمة</h6>
                                <p>${item.isUsed === 1 ? yesValue : noValue}</p>
                              </div>
                              <div>
                                <h6>الملاحظات</h6>
                                <p>${item.notes}</p>
                              </div>
                               <div>
                                <h6>موقع الفحص</h6>
                                <p>${item.gps}</p>
                              </div>
                              <div>
                                <h6>قام بفحصها</h6>
                                <p>${item.name}</p>
                              </div>

                              <div>
                                <h6>اسم الكشف</h6>
                                <p>${item.dName}</p>
                              </div>
                            </div>
                            </div>`;
                })
                cardContent += `</div>`;

                $('#detailsDiv').append(cardContent);

            })
        }
    });


</script>
<script>

    $(document).ready(function () {
        $("#searcher").on("keypress click input", function () {
            var val = $(this).val();
            console.log(val);
            if (val.length) {
                $(".collapse").hide().filter(function () {
                    return $('.btn', this).text().toLowerCase().indexOf(val.toLowerCase()) > -1;
                }).show();
            } else {
                $(".collapse").show();
            }
        });
    });

</script>

