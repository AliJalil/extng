<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<script src="<?php echo URLROOT . "/public/js/lodash.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/tableStyle.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/printStatics.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/addprint.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/animalprint.css"; ?>">
<div class="MA-vistitem2">
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
                                    <select class="ma-ytr" id="user" name="user"
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
                <!--            <div style="text-align: center" id="dateInfo"></div>-->
                <div class="ma-addtime">
                    <div style="margin: 20px 0px">كشف الذهب حسب التخصيص</div>
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
                        <tr class="golddetedction" style=" background-color: #054739;  color: #fff;  border-radius: 12px;">
                            <th style="    border-top-right-radius: 12px;" class="serial_th">ت</th>
                            <th class="sp_th">التخصيص</th>
                            <th class="w9" id="w9">عيار 9</th>
                            <th id="w12">عيار 12</th>
                            <th id="w14">عيار 14</th>
                            <th id="w17">عيار 17</th>
                            <th id="w18">عيار 18</th>
                            <th id="w21">عيار 21</th>
                            <th id="w22">عيار 22</th>
                            <th id="w24">عيار 24</th>
                            <th id="tGold">مجموع الذهب</th>
                            <th style="    border-top-left-radius: 12px;" id="tSilver">مجموع الفضة</th>
                        </tr>

                        </thead>

                        <!--End of Header-->
                    </table>
                </div>
                <!--Summarization tables-->
                <table id="#table1" class="table table-striped">
                    <tr>
                        <td>مجموع الذهب كتابة</td>
                        <td id="tGoldWriting"></td>
                    </tr>
                    <tr>
                        <td>مجموع الفضة كتابة</td>
                        <td id="tSilverWriting"></td>
                    </tr>
                </table>

                <div class="ma-spanprint2" style="display:flex;">
                    <span>المدقق</span>
                    <span>مسؤول شعبة الهدايا والنذور</span>
                    <span><?php echo date("Y/m/d h:i:sa"); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>$( document ).ready( function () {
        let users = <?php echo $data['users']; ?>;
        populateSelectFromDs( "user", users );

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
                    formData.append( element.name, element.value );
                } );
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
            const ids = Array.from( new Set( gifts.map( (item) => item.sName ) ) );
            const showItems = _.groupBy( gifts, gift => gift.sName );

            const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) - 3 );
            if (path == "2") {
                $( "#statisticsName" ).text( "كشف الذهب والفضة" );
            }
            // $( "#dateInfo" ).text( "للفترة من  " + data.from_date + " الى " + data.to_date );
            $( "#dateFromD" ).text( moment( data.from_date ).format( 'DD/MM/YYYY' ) );
            $( "#dateFromH" ).text( moment( data.from_date ).format( 'h:mm a' ) );
            $( "#dateToD" ).text( moment( data.to_date ).format( 'DD/MM/YYYY' ) );
            $( "#dateToH" ).text( moment( data.to_date ).format( 'h:mm a' ) );

            var tableBody = "";
            let rowC = 0;
            let text = "";
            var totalGold = totalSilver = 0

            ids.forEach( item => {

                var w9 = w12 = w14 = w17 = w18 = w21 = w22 = w24 = wGold = wSilver = 0
                const objs = showItems[item].filter( (x) => x.state != 2 );
                const subItems = _.groupBy( objs, objs => objs.gName );
                const gNames = Array.from( new Set( objs.map( (_item) => _item.gName ) ) );
                rowC += 1;
                text = '<tr>' +
                    '<td id="seq' + rowC + '"></td>' +
                    '<td id="sName' + rowC + '"></td>' +
                    '<td id="w9' + rowC + '"></td>' +
                    '<td id="w12' + rowC + '"></td>' +
                    '<td id="w14' + rowC + '"></td>' +
                    '<td id="w17' + rowC + '"></td>' +
                    '<td id="w18' + rowC + '"></td>' +
                    '<td id="w21' + rowC + '"></td>' +
                    '<td id="w22' + rowC + '"></td>' +
                    '<td id="w24' + rowC + '"></td>' +
                    '<td id="wGold' + rowC + '"></td>' +
                    '<td id="wSilver' + rowC + '"></td>' +
                    '</tr>'


                $( '#detailsTable' ).append( text );

                objs.forEach( object => {
                    if (object.gWeight == 1 && object.tId == 24) {
                        w9 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 2 && object.tId == 24) {
                        w12 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 3 && object.tId == 24) {
                        w14 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 4 && object.tId == 24) {
                        w17 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 5 && object.tId == 24) {
                        w18 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 6 && object.tId == 24) {
                        w21 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 7 && object.tId == 24) {
                        w22 += parseFloat( object.amount )
                    }
                    if (object.gWeight == 8 && object.tId == 24) {
                        w24 += parseFloat( object.amount )
                    }

                    if (object.tId == 24) {
                        wGold += parseFloat( object.amount );
                        totalGold += parseFloat( object.amount );
                    }
                    if (object.tId == 25) {
                        wSilver += parseFloat( object.amount );
                        totalSilver += parseFloat( object.amount );
                    }


                    $( '#seq' + rowC ).text( rowC );
                    $( '#sName' + rowC ).text( item );
                    $( '#w9' + rowC ).text( w9.toFixed(2) );
                    $( '#w12' + rowC ).text( w12.toFixed(2) );
                    $( '#w14' + rowC ).text( w14.toFixed(2));
                    $( '#w17' + rowC ).text( w17.toFixed(2) );
                    $( '#w18' + rowC ).text( w18.toFixed(2) );
                    $( '#w21' + rowC ).text( w21.toFixed(2) );
                    $( '#w22' + rowC ).text( w22.toFixed(2) );
                    $( '#w24' + rowC ).text( w24.toFixed(2) );
                    $( '#wGold' + rowC ).text( wGold.toFixed(2) );
                    $( '#wSilver' + rowC ).text( wSilver.toFixed(2) );
                } )


            } )
            $( '#tGoldWriting' ).text( tafqeet( totalGold, 'WEIGHT' ) );
            $( '#tSilverWriting' ).text( tafqeet( totalSilver, 'WEIGHT' ) );

        }
    } );


</script>


