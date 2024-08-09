<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript1.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/tableStyle.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/printStatics.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/addprint.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/animalprint.css"; ?>">
<div class="MA-vistitem2">

    <div class="ma-alltable">

        <div class="nmbjiu2 not-print">
            <a href="<?php echo URLROOT . "/statistics/index/"; ?>">
                <button class="ma-backf"><i style="font-weight: bold; padding-top: 10px;" class="far fa-arrow-right"
                                            aria-hidden="true"></i>
                </button>
            </a><span class="mainm">التفاصيل</span>
        </div>

        <div class="container">
            <div class="table-responsive">
                <div class="ma-delete">
                    <div class="ma-border">
                        <div class="ma-kl">
                            <label style="margin-left: 18px; color: #2E8B57; font-size: 17px; font-weight: 500;">التاريخ</label>
                            <label class="wqe">من</label>
                            <input class="ma-ytr" type="datetime-local" id="min" name="min"
                                   value="<?= date('Y-m-01 07:00') ?>">
                        </div>

                        <div class="ma-kl">
                            <label class="wqe">الى</label>
                            <input class="ma-ytr" type="datetime-local" id="max" name="max"
                                   value="<?= date('Y-m-d H:i') ?>">
                        </div>

                        <div class="ma-date">
                            <select class="ma-ytr" id="user" name="user"
                                    required>
                                <option value=0> الكل</option>
                            </select>
                            <label class="wqe">مدخل البيانات</label>
                        </div>
                        <input id="btnSend" type="submit" name="btnSend" value="بحث" class="ma-date ma-add"
                               style="background-color: #14A0A9">

                    </div>
                </div>
                <div style="text-align: center; margin-top: 10px" id="statisticsName" class="ma-appernace"></div>
                <!--                <div style="text-align: center" id="dateInfo"></div>-->
                <div class="ma-addtime">
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
                        <tr class="golddetedction" pcolor=#CCCCCC style="background-color: #054739;
    color: #fff;  border-radius: 12px;">
                            <th class="serial_th">ت</th>
                            <th class="dName_th">رقم الوصل</th>
                            <th class="details_th">التفاصيل</th>
                            <th class="type_th">المادة</th>
                            <th class="sp_th">التخصيص</th>
                            <th class="gWeight_th">العيار</th>
                            <th class="amount_th">الوزن بالغرام</th>
                            <th class="amount_extra_th">الملاحظات</th>
                        </tr>

                        </thead>
                        <!--End of Header-->
                    </table>
                </div>
                <!--Summarization tables-->
                <table class="table table-striped">
                    <tr class="odd">
                        <td>مجموع الذهب عيار 9</td>
                        <td id="w9"></td>
                    </tr>
                    <tr>
                        <td>مجموع الذهب عيار 12</td>
                        <td id="w12"></td>
                    </tr>
                    <tr class="odd">
                        <td>مجموع الذهب عيار 14</td>
                        <td id="w14"></td>
                    </tr>
                    <tr>
                        <td>مجموع الذهب عيار 17</td>
                        <td id="w17"></td>
                    </tr>
                    <tr class="odd">
                        <td>مجموع الذهب عيار 18</td>
                        <td id="w18"></td>
                    </tr>
                    <tr>
                        <td>مجموع الذهب عيار21</td>
                        <td id="w21"></td>
                    </tr>
                    <tr class="odd">
                        <td>مجموع الذهب عيار22</td>
                        <td id="w22"></td>
                    </tr>
                    <tr>
                        <td>مجموع الذهب عيار24</td>
                        <td id="w24"></td>
                    </tr>
                </table>
                <br>
                <br>
                <table class="table table-bordered ">
                    <tr>
                        <td>مجموع اوزان الذهب</td>
                        <td id="wGold"></td>
                        <td>مجموع اوزان الفضة</td>
                        <td id="wSilver"></td>
                    </tr>

                    <tr>
                        <td>القيمة التقديرية للذهب</td>
                        <td id="wGoldPrice"></td>
                        <td>القيمة التقديرية للفضة</td>
                        <td id="wSilverPrice"></td>
                    </tr>
                </table>
                <br>
                <br>
                <table class="table table-striped ">
                    <tr>
                        <td>عدد الوصولات الكلي</td>
                        <td id="tBills"></td>
                    </tr>
                    <tr>
                        <td>عدد الوصولات الصحيحة</td>
                        <td id="rBills"></td>
                    </tr>
                    <tr>
                        <td>عدد الوصولات الباطلة</td>
                        <td id="fBills"></td>
                    </tr>
                    <tr>
                        <td>عدد الوصولات (حلي كاذبة)</td>
                        <td id="otherBills"></td>
                    </tr>

                </table>

                <div class="ma-spanprint2" style="display:flex;">
                    <span>المدقق</span>
                    <span>مسؤول شعبة الهدايا والنذور</span>
                    <span class="ma-timein">التاريخ<?php echo date("Y/m/d"); ?></span>
                    <span class="ma-timein">الوقت<?php echo date("h:i:sa"); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>$( document ).ready( function () {

        $( 'option[value="0"]' ).prop( 'selected', true );
        $( '#user' ).select2( {
            placeholder: 'اختر المستخدم',
            dir: 'rtl',
            allowClear: true,
        } );

        let users = <?php echo $data['users']; ?>;
        populateSelectFromDs( "user", users );

        const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) + 1 );
        if (path == "2") {
            $( "#statisticsName" ).text( "كشف الذهب والفضة" );
        }
        // $( "#dateInfo" ).text( "للفترة من  " + $( "#min" ).val() + " الى " + $( "#max" ).val() );
        $( "#dateFromD" ).text( moment( $( "#min" ).val() ).format( 'DD/MM/YYYY' ) );
        $( "#dateFromH" ).text( moment( $( "#min" ).val() ).format( 'h:mm a' ) );
        $( "#dateToD" ).text( moment( $( "#max" ).val() ).format( 'DD/MM/YYYY' ) );
        $( "#dateToH" ).text( moment( $( "#max" ).val() ).format( 'h:mm a' ) );

        var w9 = w12 = w14 = w17 = w18 = w21 = w22 = w24 = wGold = wSilver = wSilverPrice = wGoldPrice = tBills = rBills = fBills = otherBills = 0
        let specifications = <?php echo $data['specifications']; ?>;
        let types = <?php echo $data['types']; ?>;
        const moneyTypes = types.filter( type => type.dType == 2 )

        var emTable = $( '#detailsTable' ).DataTable( {
            dom: '',
            pageLength: -1,
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,

            'ajax': {
                'url': '<?php echo URLROOT . "/main/details/2/1" ?>',
                "type": 'POST',
                "data": function (data) {
                    data.from_date = $( "#min" ).val(),
                        data.to_date = $( "#max" ).val(),
                        data.user = $( "#user" ).val()
                },

            },
            columns: [
                {
                    data: 'gId',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'vId'},
                {data: 'details'},
                {data: 'tId'},
                {data: 'sId'},
                {data: 'gWeight'},
                {data: 'amount'},
                {data: 'notes'},
            ],

            columnDefs: [
                {
                    targets: "type_th",
                    render: function (data, type, row) {
                        return '<a class="tId" id="tId" data-name="tId"  data-type="select" data-pk=' + row['gId'] + '>' + moneyTypes.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
                {
                    targets: "sp_th",
                    render: function (data, type, row) {
                        return '<a class="sId" id="sId" data-name="sId"  data-type="select" data-pk=' + row['gId'] + '>' + specifications.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
                {
                    targets: "gWeight_th",
                    render: function (data, type, row) {
                        return '<a class="gWeight" id="gWeight" data-name="gWeight"  data-type="select" data-pk=' + row['gId'] + '>' + gWeights.filter( state => state.value == data )[0].text + '</a>'
                    }
                }
            ],
            rowCallback: function (row, data, index) {

                tBills += 1;

                if (data.gWeight == 1 && data.state != 2) {
                    w9 += parseFloat( data.amount )
                }
                if (data.gWeight == 2 && data.state != 2) {
                    w12 += parseFloat( data.amount )
                }
                if (data.gWeight == 3 && data.state != 2) {
                    w14 += parseFloat( data.amount )
                }
                if (data.gWeight == 4 && data.state != 2) {
                    w17 += parseFloat( data.amount )
                }
                if (data.gWeight == 5 && data.state != 2) {
                    w18 += parseFloat( data.amount )
                }
                if (data.gWeight == 6 && data.state != 2) {
                    w21 += parseFloat( data.amount )
                }
                if (data.gWeight == 7 && data.state != 2) {
                    w22 += parseFloat( data.amount )
                }
                if (data.gWeight == 8 && data.state != 2) {
                    w24 += parseFloat( data.amount )
                }

                $( "#w9" ).text( w9.toFixed( 2 ) );
                $( "#w12" ).text( w12.toFixed( 2 ) );
                $( "#w14" ).text( w14.toFixed( 2 ) );
                $( "#w17" ).text( w17.toFixed( 2 ) );
                $( "#w18" ).text( w18.toFixed( 2 ) );
                $( "#w21" ).text( w21.toFixed( 2 ) );
                $( "#w22" ).text( w22.toFixed( 2 ) );
                $( "#w24" ).text( w24.toFixed( 2 ) );

                if (data.tId == 24 && data.state != 2) {
                    wGold += parseFloat( data.amount );
                    wGoldPrice += parseFloat( data.amount ) * parseFloat( data.price )
                }
                if (data.tId == 25 && data.state != 2) {
                    wSilver += parseFloat( data.amount );
                    wSilverPrice += parseFloat( data.amount ) * parseFloat( data.price )
                }
                // if (data.tId == 6) {
                //     wSilver += parseFloat( data.amount );
                //     wSilverPrice += parseFloat( data.amount ) * parseFloat( data.price )
                // }


                $( "#wGold" ).text( wGold.toFixed( 2 ) );
                $( "#wSilver" ).text( wSilver.toFixed( 2 ) );
                $( "#wGoldPrice" ).text( addCommas(wGoldPrice.toFixed( 2 )) );
                $( "#wSilverPrice" ).text( addCommas(wSilverPrice.toFixed( 2 )) );

                if (data.state != 2) {
                    rBills += 1;
                } else {
                    fBills += 1
                }

                if (data.tId == 26) {
                    otherBills += 1;
                }

                $( "#tBills" ).text( tBills );
                $( "#rBills" ).text( rBills );
                $( "#fBills" ).text( fBills );
                $( "#otherBills" ).text( otherBills );

                if (data.state == 2) {
                    $( row ).hide();
                }
            }
        } );

        $( '#btnSend' ).on( 'click', function () {
            w9 = w12 = w14 = w17 = w18 = w21 = w22 = w24 = wGold = wSilver = wSilverPrice = wGoldPrice = tBills = rBills = fBills = otherBills = 0
            emTable.draw();
            $( "#dateFromD" ).text( moment( $( "#min" ).val() ).format( 'DD/MM/YYYY' ) );
            $( "#dateFromH" ).text( moment( $( "#min" ).val() ).format( 'h:mm a' ) );
            $( "#dateToD" ).text( moment( $( "#max" ).val() ).format( 'DD/MM/YYYY' ) );
            $( "#dateToH" ).text( moment( $( "#max" ).val() ).format( 'h:mm a' ) );

        } )
        // $( '#min, #max' ).on( 'change', function () {
        //
        // } );
    } )
    ;


</script>

