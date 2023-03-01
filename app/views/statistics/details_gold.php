<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<!--<script src="   https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>-->
<!--<link rel="stylesheet" href="  https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css"/>-->
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>

<div class="ma-alltable">

    <div class="nmbjiu"><a href="<?php echo URLROOT . "/main/"; ?>">
            <button class="ma-back"><i class="fas fa-home"></i></button>
        </a></div>
    <div class="container">
        <div class="ma-header yu"><h3 class="gh" align="center">جدول الذهب</h3></div>

        <div class="table-responsive">

            <div class="ma-kl">
                <label style="margin-left: 18px; color: #2E8B57; font-size: 17px; font-weight: 500;">التاريخ</label>
                <label class="wqe">من</label>
                <input class="ma-ytr" type="date" id="min" name="min" value="<?= date('Y-m-01') ?>">
            </div>

            <div class="ma-kl">
                <label class="wqe">الى</label>
                <input class="ma-ytr" type="date" id="max" name="max" value="<?= date('Y-m-d') ?>">
            </div>


            <table id="detailsTable"
                   class="table table-striped table-bordered">
                <thead>
                <tr class="mjk" pcolor=#CCCCCC>
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
            <table class="table table-striped">
                <tr>
                    <td>مجموع الذهب عيار 9</td>
                    <td id="w9"></td>
                </tr>
                <tr>
                    <td>مجموع الذهب عيار 12</td>
                    <td id="w12"></td>
                </tr>
                <tr>
                    <td>مجموع الذهب عيار 14</td>
                    <td id="w14"></td>
                </tr>
                <tr>
                    <td>مجموع الذهب عيار 17</td>
                    <td id="w17"></td>
                </tr>
                <tr>
                    <td>مجموع الذهب عيار 18</td>
                    <td id="w18"></td>
                </tr>
                <tr>
                    <td>مجموع الذهب عيار21</td>
                    <td id="w21"></td>
                </tr>
                <tr>
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

        </div>
    </div>
</div>

<script>$( document ).ready( function () {
        var w9 = w12 = w14 = w17 = w18 = w21 = w22 = w24 = wGold = wSilver = wSilverPrice = wGoldPrice = 0
        let specifications = <?php echo $data['specifications']; ?>;
        let types = <?php echo $data['types']; ?>;
        const moneyTypes = types.filter( type => type.dType == 2 )

        var emTable = $( '#detailsTable' ).DataTable( {
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,

            'ajax': {
                'url': '<?php echo URLROOT . "/main/details/2" ?>',
                "type": 'POST',
                "data": function (data) {
                    data.from_date = $( "#min" ).val(),
                        data.to_date = $( "#max" ).val()
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
                }
            ],
            rowCallback: function (row, data, index) {
                console.log( data );
                // $('td:first', row).addClass('black').next().addClass('black');

                if (data.gWeight == 1) {
                    w9 += parseInt( data.amount )
                }
                if (data.gWeight == 2) {
                    w12 += parseInt( data.amount )
                }
                if (data.gWeight == 3) {
                    w14 += parseInt( data.amount )
                }
                if (data.gWeight == 4) {
                    w17 += parseInt( data.amount )
                }
                if (data.gWeight == 5) {
                    w18 += parseInt( data.amount )
                }
                if (data.gWeight == 6) {
                    w21 += parseInt( data.amount )
                }
                if (data.gWeight == 7) {
                    w22 += parseInt( data.amount )
                }
                if (data.gWeight == 8) {
                    w24 += parseInt( data.amount )
                }

                $( "#w9" ).text( w9 );
                $( "#w12" ).text( w12 );
                $( "#w14" ).text( w14 );
                $( "#w17" ).text( w17 );
                $( "#w18" ).text( w18 );
                $( "#w21" ).text( w21 );
                $( "#w22" ).text( w22 );
                $( "#w24" ).text( w24 );

                if (data.tId == 5) {
                    wGold += parseInt( data.amount );
                    wGoldPrice += parseInt( data.amount ) * parseInt( data.price )
                }
                if (data.tId == 6) {
                    wSilver += parseInt( data.amount );
                    wSilverPrice += parseInt( data.amount ) * parseInt( data.price )
                }
                $( "#wGold" ).text( wGold );
                $( "#wSilver" ).text( wSilver );
                $( "#wGoldPrice" ).text( wGoldPrice );
                $( "#wSilverPrice" ).text( wSilverPrice );


            }


        } );

        $( '#min, #max' ).on( 'change', function () {
            emTable.draw();
        } );
    } );


</script>


