<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<script src="<?php echo URLROOT . "/public/js/lodash.min.js" ?>"></script>

<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/tableStyle.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/printStatics.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/addprint.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/animalprint.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/tabelStyle.css"; ?>">
<div class="MA-vistitem2 ma-border4">
    <div class="ma-alltable">
        <div class="nmbjiu2 not-print">
            <a href="<?php echo URLROOT . "/statistics/index"; ?>">
                <button class="ma-backf"><i style="font-weight: bold; padding-top: 10px;" class="far fa-arrow-right"
                                            aria-hidden="true"></i>
                </button>
            </a><span class="mainm">التفاصيل</span>
        </div>
        <div class="container">


            <div class="table-responsive">


                <div class="ma-dir not-print">

                    <form class="row" enctype="multipart/form-data" name="searchForm" method="post" id="searchForm">
                        <div class="ma-delete">
                            <div class="ma-border">
                                <label class="wqe" style="color: #2E8B57;">التاريخ</label>
                                <div class="ma-date">
                                    <input class="ma-ytr" type="datetime-local" id="min" name="from_date"
                                           value="<?= date('Y-m-01 07:00') ?>">
                                    <label class="wqe">من</label>
                                </div>
                                <div class="ma-date">
                                    <input class="ma-ytr" type="datetime-local" id="max" name="to_date"
                                           value="<?= date('Y-m-d H:i') ?>">
                                    <label class="wqe">الى</label>
                                </div>
                                <div class="ma-date">
                                    <select multiple class="ma-forplace" id="user" name="user"
                                            required>
                                        <option value=0> الكل</option>
                                    </select>
                                    <label class="wqe">مدخل البيانات</label>
                                </div>

                                <input type="submit" name="btnSend" value="بحث" class="ma-date ma-add"
                                       style="background-color: #14A0A9">
                            </div>
                        </div>
                    </form>
                </div>

                <div style="text-align: center" id="statisticsName" class="ma-appernace"></div>
<!--                <div style="text-align: center" id="dateInfo"></div>-->
                <div class="ma-addtime">
                    <div style="margin: 20px 0px">كشف الانعام</div>
                للفترة من:
                <div style="text-align: center" id="dateFromD"></div>
                <div style="text-align: center" id="dateFromH"></div>
                الى
                <div style="text-align: center" id="dateToD"></div>
                <div style="text-align: center" id="dateToH"></div>
                </div>
                <div class="accordion-body tye">
                    <table id="detailsTable"
                           class="table table-striped table-bordered jkj">
                        <thead>
                        <tr class="golddetedction" style="      background-color: #054739;
    color: #fff;  border-radius: 12px;">
                            <th class="serial_th">ت</th>
                            <th>التأريخ</th>
                            <th>عدد الانعام</th>
                            <th>من الوصل</th>
                            <th>الى الوصل</th>
                            <th>الوصولات البطالة والنافقة واكثر من ١</th>
                            <th>الملاحظات</th>
                        </tr>
                        </thead>
                        <!--End of Header-->
                    </table>

                    <!--Summarization tables-->
                    <table class="table table-striped print_open jkj">
                        <tr>
                            <td>العدد الكلي للانعام</td>
                            <td id="tAnimal"></td>
                        </tr>
                        <tr>
                            <td>عدد الانعام النافقة</td>
                            <td id="tBadAnimal"></td>
                        </tr>
                        <tr>
                            <td>عدد الانعام التي تم تسليمها</td>
                            <td id="tDeliveredAnimal"></td>
                        </tr>

                    </table>

                    <div style="margin: 12px 0px;" class="print_st">الانعام التي تم تسليمها</div>
                    <table id="summarizeTable" class="table table-striped print_open jkj">
                        <thead>
                        <tr class="golddetedction" style="      background-color: #054739;
    color: #fff;  border-radius: 12px;">
                            <th>الانعام</th>
                            <th>الجهة المستلمة</th>
                            <th>العدد</th>
                            <th>القيمة التقديرية</th>
                        </tr>
                        </thead>

                    </table>
                </div>
                <div class="ma-spanprint2" style="display:flex;">
                    <span>المدقق</span>
                    <span>مسؤول شعبة الهدايا والنذور</span>
                     <span class="ma-timein"><?php echo  date("Y/m/d h:i:sa");?></span>
                    <span class="ma-timein"><?php echo  date("h:i:sa");?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>$( document ).ready( function () {
        let users = <?php echo $data['users']; ?>;
        populateSelectFromDs( "user", users );

        $( 'option[value="0"]' ).prop( 'selected', true );
        $( '#user' ).select2( {
            placeholder: 'اختر المستخدم',
            dir: 'rtl',
            allowClear: true,
        } );


        const form = $( "#searchForm" );
        const params = form.serializeArray();
        const formData = new FormData();
        $( params ).each( function (index, element) {
            formData.append( element.name, element.value );
        } )
        getData( formData )

        $( "#searchForm" ).submit( function (event) {
                const form = $( "#searchForm" );
                const params = form.serializeArray();
                const formData = new FormData();
                $( params ).each( function (index, element) {
                    if (element.name !== 'user') {
                        formData.append( element.name, element.value );
                    }
                } );
                formData.append( "user", $( "#user" ).val() );
                getData( formData )
                return false;
            }
        );


        function getData(formData) {
            // const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) - 1 );
            var pathValues = location.pathname.split( "/" );
            var path = pathValues.filter( function (el) {
                return el.length && el == +el;
            } ).join( '/' );

            $.ajax( {
                    url: '<?php echo URLROOT . "/statistics/summary/";?>' + path,
                    method: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        bindData( $.parseJSON( data ) )
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        showAlert( 'error', "خطأ: " + errorThrown );
                    },
                }
            );
        }


        function bindData(data) {

            $( '#detailsTable tbody' ).empty();
            const gifts = data.gifts;
            const ids = Array.from( new Set( gifts.map( (item) => item.createdAt ) ) );
            const showItems = _.groupBy( gifts, gift => gift.createdAt );

            const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) - 3 );
            if (path == "2") {
                $( "#statisticsName" ).text( "كشف الذهب والفضة" );
            }
            // $( "#dateInfo" ).text( "للفترة من  " + data.from_date + " الى " + data.to_date );
            $( "#dateFromD" ).text( moment(data.from_date).format('DD/MM/YYYY'));
            $( "#dateFromH" ).text( moment(data.from_date).format('h:mm a'));
            $( "#dateToD" ).text( moment(data.to_date).format('DD/MM/YYYY'));
            $( "#dateToH" ).text( moment(data.to_date).format('h:mm a'));

            var tableBody = "";
            let rowC = 0;
            let text = "";
            var tAnimal = tBadAnimal = tDeliveredAnimal = 0
            ids.forEach( item => {

                var totalDateAnimal = 0
                var badBillVid = "";
                var fallBillVid = "";
                var moreThanOne = "";
                var gName = "";
                const objs = showItems[item].filter( (x) => x.state != 2 );
                // const objs = showItems[item];
                const subItems = _.groupBy( objs, objs => objs.gName );
                const gNames = Array.from( new Set( objs.map( (_item) => _item.gName ) ) );
                rowC += 1;
                text = '<tr>' +
                    '<td id="seq' + rowC + '"></td>' +
                    '<td id="dateName' + rowC + '"></td>' +
                    '<td id="totalDateAnimal' + rowC + '"></td>' +
                    '<td id="fromVid' + rowC + '"></td>' +
                    '<td id="toVid' + rowC + '"></td>' +
                    '<td id="fallBadBillVid' + rowC + '"></td>' +
                    '<td id="notes' + rowC + '"></td>' +
                    '</tr>'


                $( '#detailsTable' ).append( text );
                var fromVid = Math.min( ...objs.map( o => o.vId ) );
                var toVid = Math.max( ...objs.map( o => o.vId ) );

                objs.forEach( object => {
                    totalDateAnimal += parseInt( object.amount )
                    if (object.bad != 0) {
                        badBillVid = " الوصل " + object.vId + " نفوق ";
                    }
                    if (object.state == 2) {
                        fallBillVid = " الوصل " + object.vId + " بطال ";
                    }
                    if (object.amount > 1) {
                        moreThanOne += " الوصل " + object.vId + " فيه  " + object.amount;
                    }
                    gName += object.gName + " ";

                    tAnimal += parseInt( object.amount );
                    if (object.bad != 0) {
                        tBadAnimal += parseInt( object.amount );
                    }
                    if (parseInt( object.benefitSide ) != 0) {
                        tDeliveredAnimal += parseInt( object.amount );

                        tableBody += '<tr>' +
                            '<td>' + object.gName + '</td>' +
                            '<td>' + object.benefitSide + '</td>' +
                            '<td>' + object.benefitSide + '</td>' +
                            '<td></td>' +
                            '</tr>';
                    }

                    // console.log( object );

                } )

                $( '#seq' + rowC ).text( rowC );
                $( '#totalDateAnimal' + rowC ).text( totalDateAnimal );
                $( '#dateName' + rowC ).text( item );
                $( '#fromVid' + rowC ).text( fromVid );
                $( '#toVid' + rowC ).text( toVid );
                $( '#fallBadBillVid' + rowC ).text( badBillVid + fallBillVid + moreThanOne );
                $( '#notes' + rowC ).text( gName );
            } )


            $( '#tAnimal' ).text( tAnimal );
            $( '#tBadAnimal' ).text( tBadAnimal );
            $( '#tDeliveredAnimal' ).text( tDeliveredAnimal );

            $( "#summarizeTable" ).empty();
            data.animalBenefits.forEach( benifitItem => {
                var row = '<tr>' +
                    '<td>' + benifitItem.gName + '</td>' +
                    '<td>' + benifitItem.benefitSide + '</td>' +
                    '<td>' + benifitItem.totalAmount + '</td>' +
                    '<td>' + benifitItem.totalPrice + '</td>' +
                    '</tr>'

                $( '#summarizeTable' ).append( row );
            } )

        }
    } );


</script>


