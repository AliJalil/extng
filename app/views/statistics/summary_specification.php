<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="<?php echo URLROOT . "/public/js/main.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/tableStyle.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/printStatics.css"; ?>">
<script src="<?php echo URLROOT . "/public/js/lodash.min.js" ?>"></script>


<div class="MA-vistitem2">

    <div class="nmbjiu2 not-print">
        <a href="<?php echo URLROOT . "/statistics/index/"; ?>">
            <button class="ma-backf">
                <i style="font-weight: bold; padding-top: 10px;" class="far fa-arrow-right"></i>
            </button>
        </a><span class="mainm">التفاصيل</span></div>
    <div class="ma-dir not-print">

        <form class="row" enctype="multipart/form-data" name="searchForm" method="post" id="searchForm">
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
                    <select multiple  class="ma-forplace" id="user" name="user"
                            required>
                        <option  value=0> الكل</option>
                    </select>
                    <label class="wqe">مدخل البيانات</label>
                </div>
                <input type="submit" name="btnSend" value="بحث" class="ma-date ma-add"
                       style="background-color: #14A0A9">
            </div>
        </form>

        <div class="ma-expand">
            <button class="not-print ma-add" id="expandAllFormats">توسيع الكل</button>
            <input class="input-medium search-query ma-ytr" id="searcher" placeholder="ابحث هنا">
            <div style="position: absolute;top: 12px;right: 13px;">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
    <div class="ma-headerprint">
        <span style="text-align: center; " class="ma-spanprint maiew">ت</span>
        <span style="text-align: center;width: 40% " class="ma-spanprint">العملة</span>
        <span style="text-align: center;width: 40% " class="ma-spanprint ">المبلغ</span>
    </div>
    <br>
    <br>
    <div id="section-to-print">
        <div style="text-align: center" id="statisticsName"></div>
<!--        <div style="text-align: center" id="dateInfo"></div>-->
        للفترة من:
        <div style="text-align: center" id="dateFromD"></div>
        <div style="text-align: center" id="dateFromH"></div>
        الى
        <div style="text-align: center" id="dateToD"></div>
        <div style="text-align: center" id="dateToH"></div>

        <div class="accordion panel-group" id="accordionFormat">
        </div>
    </div>


</div>
<script>
    $( document ).ready( function () {

            $( 'option[value="0"]' ).prop( 'selected', true );
            $( '#user' ).select2( {
                placeholder: 'اختر المستخدم',
                dir: 'rtl',
                allowClear: true,
            } );

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
                        if (element.name !== 'user') {
                            formData.append( element.name, element.value );
                        }
                    } );
                    formData.append( "user", $( "#user" ).val() );
                    getData( formData )
                    return false;
                }
            );

            function addCommas(nStr) {
                nStr += '';
                x = nStr.split( '.' );
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test( x1 )) {
                    x1 = x1.replace( rgx, '$1' + ',' + '$2' );
                }
                return x1 + x2;
            }

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
                $( "#accordionFormat" ).empty();
                const gifts = data.gifts;
                const ids = Array.from( new Set( gifts.map( (item) => item.gName ) ) );
                const showItems = _.groupBy( gifts, gift => gift.gName );

                const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) - 3 );
                if (path == "1/1/2") {
                    $( "#statisticsName" ).text( "كشف الدولار حسب التخصيص" );
                } else if (path == "1/1/1") {
                    $( "#statisticsName" ).text( "كشف الدينار حسب التخصيص" );
                } else if (path == "y/1/1") {
                    $( "#statisticsName" ).text( "كشف العملات العربية والاجنبية حسب التخصيص" );
                }
                // $( "#dateInfo" ).text( "للفترة من  " + data.from_date + " الى " + data.to_date );
                $( "#dateFromD" ).text( moment(data.from_date).format('DD/MM/YYYY'));
                $( "#dateFromH" ).text( moment(data.from_date).format('h:mm a'));
                $( "#dateToD" ).text( moment(data.to_date).format('DD/MM/YYYY'));
                $( "#dateToH" ).text( moment(data.to_date).format('h:mm a'));

                var tableBody = "";
                let rowC = 0;
                let text = "";
                ids.forEach( item => {
                    const objs = showItems[item].filter( (x) => x.state != 2 );
                    const subItems = _.groupBy( objs, objs => objs.sName );
                    const sNames = Array.from( new Set( objs.map( (_item) => _item.sName ) ) );
                    rowC += 1;

                    text = '<div class="accordion-item masier" style="direction: rtl;">' +
                        '<h2 class="accordion-header" id="heading"+item+">' +
                        '<button class="accordion-button" type="button" data-bs-toggle="collapse"' +
                        ' data-bs-target="#collapse' + item + '" aria-expanded="true"' +
                        'aria-controls="collapse' + item + '">' +
                        '<div class="ma-inprint"' +
                        ' style="display: inline-flex;text-align: justify; justify-content: space-between">' +
                        ' <span style="color: #ffffff" class="card-title">' + item + '</span>' +
                        ' <div>' +
                        '<span style="color: #ffffff"> الاجمالي:' + addCommas(objs.reduce( (acc, o) => acc + parseInt( o.amount ), 0 )) + '</span>' +
                        ' </div>' +
                        ' </div>' +
                        ' </button>' +
                        ' </h2>' +
                        ' <div style="text-align: center" id="collapse' + item + '" class="accordion-collapse collapse show"' +
                        ' aria-labelledby="heading' + item + '" data-bs-parent="#accordionExample">' +
                        '  <div class="accordion-body">' +
                        '  <table  id="table' + rowC + '" class="styled-table ">' +
                        '<thead>' +
                        '  <tr class="mjk">' +
                        ' <th>الكمية</th>' +
                        '  <th>النوع</th>' +
                        ' </tr>' +
                        ' </thead>' +
                        '  </table>';
                    $( '#accordionFormat' ).append( text );

                    sNames.forEach( sName => {
                        var subItem = subItems[sName];
                        subItem.forEach( _subItem => {
                            tableBody = '  <tr>' +
                                '<td>' + addCommas( subItem.reduce( (acc, o) => acc + parseInt( o.amount ), 0 ) ) + '</td>' +
                                ' <td>' + sName + '</td>' +
                                '</tr>';
                        } );
                        $( '#table' + rowC ).append( tableBody );
                    } );
                    $( '#accordionFormat' ).append( ' </div>' +
                        ' </div>' +
                        ' </div>' );
                } );
                $( '#accordionFormat' ).append( '<span class="ma-spanprint" >عدد الوصولات الكلي' + '<span class="maopo">' + gifts.length + '</span>' + '</span>' );
                $( '#accordionFormat' ).append( ' <span class="ma-spanprint">عدد الوصولات البطالة' + '<span class="maopo">' + gifts.filter( item => item.state == 2 ).length + '</span>' + '</span>' );

                $( '#accordionFormat' ).append(
                    '<div class="ma-spanprint2">' +
                    ' <span >المدقق</span>' +
                    ' <span>مسؤول شعبة الهدايا والنذور</span>' +
                    ' <span class="ma-timein">التاريخ<?php echo  date("Y/m/d");?></span>' +
                    ' <span class="ma-timein">الوقت<?php echo  date("h:i:sa");?></span>' +
                    '</div>'
                );
            }
        }
    )
    ;
</script>
<script>

    $( document ).ready( function () {
        $( "#searcher" ).on( "keypress click input", function () {
            var val = $( this ).val();
            if (val.length) {
                $( ".panel-group .accordion-item" ).hide().filter( function () {
                    return $( '.card-title', this ).text().toLowerCase().indexOf( val.toLowerCase() ) > -1;
                } ).show();
            } else {
                $( ".panel-group .accordion-item" ).show();
            }
        } );
    } );

</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>


    $( "#expandAllFormats" ).click( function () {
        if ($( '.collapse' ).hasClass( "show" )) {

            $( '.collapse' ).removeClass( 'show' );
            // $('.collapse').collapse('show');
            $( this ).text( "عرض التفاصيل" );
        } else {
            $( '.collapse' ).addClass( 'show' );
            // $('.collapse').collapse('hide');
            $( this ).text( "الملخصات" );
        }
    } );

</script>


<style>

    a {
        text-decoration: none !important;
    }

    }
</style>
