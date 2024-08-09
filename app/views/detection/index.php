<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>

<div class="ma-alltable">

    <div class="nmbjiu"><a href="<?php echo URLROOT . "/main/"; ?>">
            <button class="ma-back"><i class="fas fa-home"></i></button>
        </a></div>
    <div class="container">
        <div class="ma-header yu"><h3 class="gh" align="center">معلومات الكشوفات</h3></div>

        <div class="table-responsive">
            <table id="detailsTable"
                   class="table table-striped table-bordered">
                <thead>
                <tr class="mjk" pcolor=#CCCCCC>
                    <th class="dName_th">اسم الكشف</th>
                    <th class="startIn_th">تأريخ البدأ</th>
                    <th class="endAt_th">تأريخ الانتهاء</th>
                    <th class="notes_th">الملاحظات</th>
                    <th class="isCurrent_th">الكشف الحالي</th>
                    <th class="isActive_th">فعال</th>
                    <th class="action_th">الاجراء</th>
                </tr>

                </thead>
                <!--End of Header-->
            </table>
        </div>
    </div>
</div>

<script>
    $( document ).ready( function () {

        var emTable = $( '#detailsTable' ).DataTable( {
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,

            'ajax': {
                'url': '<?php echo URLROOT . "/detections/index" ?>',
                "type": 'POST',
                "data": function (data) {
                },
            },
            columns: [
                {data: 'dName'},
                {data: 'startIn'},
                {data: 'endAt'},
                {data: 'notes'},
                {data: 'isCurrent'},
                {data: 'isActive'},
                {
                    data: 'dId',
                    render: function (data, type, row) {
                        return '<div style="margin-top: 5px">' +
                            '                             <a  href="<?php echo URLROOT . "/detections/details/"; ?>' + row['dId'] + '"style="transition: all 0.3s; background: #EDEDED;color: red;" data-toggle="tooltip" title="معاينة الكشف"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-eye"></i>' +
                            '                            </a>' +
                            <?php if (checkPermission($data['permissions'], 'DeleteGift'))  : ?>
                            '                            <button style="transition: all 0.3s; background: #EDEDED;color: red;" id="delete-item-' + data + '" data-toggle="tooltip" title="حذف السجل الحالي"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-trash"></i>' +
                            '                            </button>' +
                            <?php endif;?>
                            '</div>' +
                            '';
                    }
                },

            ],

            columnDefs: [
                {
                    targets: "dName_th",
                    render: function (data, type, row) {
                        return '<a class="dName" id="dName" data-name="dName"  data-type="text" data-pk=' + row['dId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "startIn_th",
                    render: function (data, type, row) {
                        return '<a class="startIn" id="startIn" data-name="startIn"  data-type="text" data-pk=' + row['dId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "endAt_th",
                    render: function (data, type, row) {
                        return '<a class="endAt" id="endAt" data-name="endAt"  data-type="text" data-pk=' + row['dId'] + '>' +  data + '</a>'
                    }
                },
                {
                    targets: "notes_th",
                    render: function (data, type, row) {
                        return '<a class="notes" id="notes" data-name="notes"  data-type="text" data-pk=' + row['dId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "isCurrent_th",
                    render: function (data, type, row) {
                        return '<a class="isCurrent" id="isCurrent" data-name="isCurrent"  data-type="select" data-pk=' + row['dId'] + '>' + states.filter( state => state.value == data )[0].text + '</a>'
                    }
                },

                {
                    targets: "isActive_th",
                    render: function (data, type, row) {
                        return '<a class="isActive" id="isActive" data-name="isActive"  data-type="select" data-pk=' + row['dId'] + '>' + activeStates.filter( state => state.value == data )[0].text + '</a>'
                    }
                },

            ],
            fnInitComplete: function () {
                addSearchControl();
                $( "#isActive_th" ).select2();
                $( "#isCurrent_th" ).select2();
            }
        } )
        emTable.on( 'draw', function () {

            <?php if (checkPermission($data['permissions'], 'EditGift')):?>
            selectFromSource( ".isActive", "<?php echo URLROOT . "/detections/edit";?>", activeStates );
            selectFromSource( ".isCurrent", "<?php echo URLROOT . "/detections/edit";?>", states );

            make_editable_x( '.startIn', "<?php echo URLROOT . "/detections/edit";?>" );
            make_editable_x( '.endAt', "<?php echo URLROOT . "/detections/edit";?>" );
            make_editable_x( '.notes', "<?php echo URLROOT . "/detections/edit";?>" );

            <?php endif;?>
        } )

        function addSearchControl() {

            $( "#detailsTable thead" ).append( $( "#detailsTable thead tr:first" ).clone() );
            $( "#detailsTable thead tr:eq(1) th" ).each( function (index) {
                addFilterDropDownToDataTable( emTable, activeStates, index, this, "isActive_th", "detailsTable" );
                addFilterDropDownToDataTable( emTable, states, index, this, "isCurrent_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "dName_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "notes_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "startIn_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "endAt_th", "detailsTable" );

                $( this ).replaceWith( "<th></th>" );
            } );
        }

        $( '#min, #max' ).on( 'change', function () {
            emTable.draw();
        } );
        $( document ).on( 'click', '[id^="delete-item-"]', function () {
            var button = $( this );
            var id = this.id.split( '-' ).pop();

            deleteFunction( "حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/detections/edit";?>", id, emTable, button );

        } );
    } );


</script>


