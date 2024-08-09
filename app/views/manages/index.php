<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<div class="MA-vistitem2 jk">
    <div class="nmbjiu2"><a href="<?php echo URLROOT . "/main/index"; ?>">
            <button class="ma-backf"><i style="font-weight: bold;
    padding-top: 10px;" class="far fa-arrow-right" aria-hidden="true"></i>
            </button>

        </a><span class="mainm">ادارة الاحجام</span></div>
    <div class="ma-dir not-print">

        <div class="custom-model-main" id="add-size-model">
            <div class="custom-model-inner">
                <div id="close-btn-sp" class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="addSize">
                            <table>
                                <tr>
                                    <td class="rowone">اسم الحجم</td>
                                    <td>
                                        <input id="sName" name="sName" class="ma-forplace sName"
                                               placeholder="اسم الحجم" type="text" required="">
                                    </td>
                                </tr>
                            </table>
                            <div class="ma-tu adduser1">
                                <input id="send_data2" class="ma-add" type="submit" name="Submit" value="اضافة ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>
    </div>


    <div class="intable">
        <div class="ma-expand2">
            <div id="add-sp-btn" class="Click-here Click-here2 "><i style="font-size: 15px; margin-left: 9px;"
                                                                    class="fas fa-plus"></i>
                <label class="wqe1">اضافة حجم</label>
            </div>
        </div>
        <div class="table-responsive">
            <table id="sizeTable" class=" table table-striped table-bordered">
                <thead>
                <tr class="mjk">
                    <th class="sName_th">الحجم</th>
                    <th class="state_th">الحالة</th>
                    <th>الاجراء</th>
                </tr>

                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="MA-vistitem2 jk">
    <div style="padding-right: 25px;padding-top: 25px" class="nmbjiu2"><span class="mainm" >إدارة الانواع </span></div>

    <div class="ma-dir maopi not-print">
        <div id="add-type-model" class="custom-model-main">
            <div class="custom-model-inner">
                <div class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="addType">

                            <table>
                                <td class="rowone">اسم النوع</td>
                                <td>
                                    <input id="tName" name="tName" class="ma-forplace tName"
                                           placeholder="اسم النوع" type="text" required="">
                                </td>
                            </table>
                            <div class="ma-tu adduser1">
                                <input id="send_data2" class="ma-add" type="submit" name="Submit" value="اضافة ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>
    </div>

    <div class="intable">
        <div class="ma-expand2">
            <div id="add-type-btn" class="Click-here Click-here2 "><i style="font-size: 15px;
    margin-left: 9px;" class="fas fa-plus"></i><label
                        class="wqe1">اضافة نوع</label>
            </div>
        </div>

        <div class="table-responsive">

            <table id="typesTable"
                   class="table table-striped table-bordered">
                <thead>
                <tr class="mjk">
                    <th class="tName_th">اسم النوع</th>
                    <th class="state_th">الحالة</th>
                    <th class="action_th">الاجراء</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script>$( document ).ready( function () {

        let types = <?php echo $data['types']; ?>;
        let sizes = <?php echo $data['sizes']; ?>;

        addManage( 'addSize', 1 );
        addManage( 'addType', 2 );

        function addManage(formId, manageId) {

            $( "#" + formId ).submit( function (event) {

                    const form = $( "#" + formId );
                    var params = form.serializeArray();
                    var formData = new FormData();
                    $( params ).each( function (index, element) {
                        formData.append( element.name, element.value );
                    } );
                    $.ajax( {
                        url: '<?php echo URLROOT . "/manages/add";?>' + "/" + manageId,
                        method: "post",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            // window.location.replace( "print.php" );
                            const json = $.parseJSON( response );
                            if (json == "200") {
                                showAlert( "success", "تمت الاضافة بنجاح" );
                                $( "#" + formId ).trigger( "reset" );
                                $( "#submit" ).attr( "disabled", false );
                                $( "#submit" ).val( "حفظ" );
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert( "Status: " + textStatus );
                            alert( "خظأ: " + errorThrown );
                        }
                    } );
                    return false;
                }
            );
        }

        var sizeTable = $( '#sizeTable' ).DataTable( {
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,
            'ajax': {
                'url': '<?php echo URLROOT . "/manages/getSizes" ?>',
                "type": 'POST',
            },
            columns: [
                {data: 'sName'},
                {data: 'isActive'},
                {
                    data: 'sId',
                    render: function (data, type, row) {
                        return '<div style="margin-top: 5px">' +
                            '                            <button style="transition: all 0.3s; background: #EDEDED;color: red;" id="delete-item-sp-' + data + '" data-toggle="tooltip" title="حذف السجل الحالي"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-trash"></i>' +
                            '                            </button>' +
                            '                       ' +
                            '                    </div>';
                    }
                },
            ],

            columnDefs: [
                {
                    targets: "state_th",
                    render: function (data, type, row) {
                        return '<a class="isActive" id="isActive" data-name="isActive"  data-type="select" data-pk=' + row['sId'] + '>' + activeStates.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
                {
                    targets: "sName_th",
                    render: function (data, type, row) {
                        return '<a class="sName_" id="sName" data-name="sName"  data-type="text" data-pk=' + row['sId'] + '>' + data + '</a>'
                    }
                },
            ],
        } )

        sizeTable.on( 'draw', function () {
            <?php if (checkPermission($data['permissions'], 'ManagePage'))  : ?>
            make_editable_x( '.sName_', "<?php echo URLROOT . "/manages/edit/1";?>" );
            selectFromSource( ".isActive", "<?php echo URLROOT . "/manages/edit/1";?>", activeStates );
            <?php endif;?>
        } )

        var typesTable = $( '#typesTable' ).DataTable( {
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,
            'ajax': {
                'url': '<?php echo URLROOT . "/manages/getTypes" ?>',
                "type": 'POST',
            },

            columns: [
                {data: 'tName'},
                {data: 'isActive'},
                {
                    data: 'tId',
                    render: function (data, type, row) {
                        return '<div style="margin-top: 5px">' +

                            '                            <button style="transition: all 0.3s; background: #EDEDED;color: red;" id="delete-item-type-' + data + '" data-toggle="tooltip" title="حذف السجل الحالي"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-trash"></i>' +
                            '                            </button>' +
                            '                       ' +
                            '                    </div>';
                    }
                },
            ],
            columnDefs: [
                {
                    targets: "tName_th",
                    render: function (data, type, row) {
                        return '<a class="tName_" id="tName" data-name="tName"  data-type="text" data-pk=' + row['tId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "state_th",
                    render: function (data, type, row) {
                        return '<a class="isActive" id="isActive" data-name="isActive"  data-type="select" data-pk=' + row['exId'] + '>' + activeStates.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
            ],
            fnInitComplete: function () {
                addSearchControl();
            }
        } )

        typesTable.on( 'draw', function () {
            <?php if (checkPermission($data['permissions'], 'ManagePage'))  : ?>
            make_editable_x( '.tName_', "<?php echo URLROOT . "/manages/edit/2";?>" );
            selectFromSource( ".isActive", "<?php echo URLROOT . "/manages/edit/2";?>", activeStates );
            <?php endif;?>
        } )

        function addSearchControl() {
            $( "#typesTable thead" ).append( $( "#typesTable thead tr:first" ).clone() );
            $( "#typesTable thead tr:eq(1) th" ).each( function (index) {
                addFilterTextToDataTable( typesTable, index, this, "tName_th", "typesTable" );
                $( this ).replaceWith( "<th></th>" );
            } );
        }

        $( document ).on( 'click', '[id^="delete-item-sp-"]', function () {
            let button = $( this );
            let id = this.id.split( '-' ).pop();
            deleteFunction( "حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/manages/edit/1";?>", id, sizeTable, button );
        } );

        $( document ).on( 'click', '[id^="delete-item-type-"]', function () {
            let button = $( this );
            let id = this.id.split( '-' ).pop();
            deleteFunction( "حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/manages/edit/2";?>", id, typesTable, button );
        } );

        $( document ).on( 'click', '[id^="delete-item-cash-"]', function () {
            let button = $( this );
            let id = this.id.split( '-' ).pop();
            deleteFunction( "حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/manages/edit/3";?>", id, cashTable, button );
        } );

    } );
</script>

<script>
    $( "#add-type-btn" ).on( 'click', function () {
        $( "#add-type-model" ).addClass( 'model-open' );
    } );
    $( ".close-btn, .bg-overlay" ).click( function () {
        $( "#add-type-model" ).removeClass( 'model-open' );
    } );

    $( "#add-sp-btn" ).on( 'click', function () {
        $( "#add-size-model" ).addClass( 'model-open' );
    } );
    $( "#close-btn-sp, .bg-overlay-sp" ).click( function () {
        $( "#add-size-model" ).removeClass( 'model-open' );
    } );

    $( "#add-cash-btn" ).on( 'click', function () {
        $( "#add-cash-model" ).addClass( 'model-open' );
    } );
    $( "#close-btn-cash, .bg-overlay-sp" ).click( function () {
        $( "#add-cash-model" ).removeClass( 'model-open' );
    } );


</script>
