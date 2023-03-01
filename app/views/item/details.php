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
        <div class="ma-header yu"><h3 class="gh" align="center">جدول العينية</h3></div>
        <div class="table-responsive">
            <div class="ma-kl">
                <label style="margin-left: 18px; color: #2E8B57; font-size: 17px; font-weight: 500;">التاريخ</label>
                <label class="wqe">من</label>
                <input class="ma-ytr" type="datetime-local" id="min" name="min" value="<?= date('Y-m-01 07:00') ?>">
            </div>

            <div class="ma-kl">
                <label class="wqe">الى</label>
                <input class="ma-ytr" type="datetime-local" id="max" name="max" value="<?= date('Y-m-d H:i') ?>">
            </div>


            <table id="detailsTable"
                   class="table table-striped table-bordered">
                <thead>
                <tr class="mjk" pcolor=#CCCCCC>
                    <th class="vId_th">رقم الوصل</th>
                    <th class="dName_th">اسم المتبرع</th>
                    <th class="type_th">وحدة القياس</th>
                    <th class="amount_th">العدد</th>


                    <th class="details_th">التفاصيل</th>
                    <th class="benefit_th">الجهة المستفيدة</th>
                    <th class="authorized_th">اسم المخول</th>


                    <th class="sp_th">التخصيص</th>
                    <th>الوقت والتاريخ</th>
                    <th class="user_th">اسم مدخل البيانات</th>
                    <th class="state_th">الحالة</th>

                    <th class="check_th">التدقيق</th>
                    <?php if (checkPermission($data['permissions'], 'Checker'))  : ?>
                        <th class="checker_th">دققه</th>
                    <?php endif; ?>
                    <th class="action_th">الاجراء</th>
                </tr>

                </thead>
                <!--End of Header-->
            </table>
        </div>
    </div>
</div>

<script>$( document ).ready( function () {

        let specifications = <?php echo $data['specifications']; ?>;
        let types = <?php echo $data['types']; ?>;
        const moneyTypes = types.filter( type => type.dType == 3 )
        var emTable = $( '#detailsTable' ).DataTable( {
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,

            'ajax': {
                'url': '<?php echo URLROOT . "/main/details/3" ?>',
                "type": 'POST',
                "data": function (data) {
                    data.from_date = $( "#min" ).val(),
                        data.to_date = $( "#max" ).val()
                },
            },
            columns: [
                {data: 'vId'},
                {data: 'dName'},
                {data: 'tId'},
                {data: 'amount'},
                {data: 'details'},

                {data: 'benefitSide'},
                {data: 'authorizedName'},
                {data: 'sId'},
                {data: 'createdAt'},

                {data: 'name'},
                {
                    data: 'state',
                    render: function (data, type, row) {
                        var state = "صالح";
                        var txt = "";
                        if (row['state'] == 2) {
                            state = 'باطل';
                            txt += '                        <br>' +
                                '                       <div style="margin-top: 5px">' +
                                '                            <button style="transition: all 0.3s; background: #EDEDED;color: #007f60;" id="infoItem-' + row['ignoreBy'] + '" data-toggle="tooltip" title="ابطله المستخدم"' +
                                '                                class="btn btn-sm">' +
                                '                            <i class="fas fa-info-square"></i>' +
                                '                        </button>';
                        }
                        return '<a class="state" id="state" data-name="state"  data-type="select" data-emptytext="فارغ" data-pk=' + row['gId'] + '>' + state + '</a>' +
                            txt +
                            '</div>';
                    }
                },

                {data: 'isChecked'},
                <?php if (checkPermission($data['permissions'], 'Checker'))  : ?>
                {data: 'checker'},
                <?php endif;?>
                {
                    data: 'gId',
                    render: function (data, type, row) {
                        return '<div style="margin-top: 5px">' +
                            '                             <a target="_blank" href="<?php echo URLROOT . "/main/item/"; ?>' + row['gGId'] + '"style="transition: all 0.3s; background: #EDEDED;color: red;" data-toggle="tooltip" title="معاينة الوصل"' +
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
                            '                       ';
                    }
                },
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
                    targets: "state_th",
                    render: function (data, type, row) {
                        return '<a class="state" id="state" data-name="state"  data-type="select" data-pk=' + row['gId'] + '>' + states.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
                {
                    targets: "check_th",
                    render: function (data, type, row) {
                        return '<a class="isChecked" id="isChecked" data-name="isChecked"  data-type="select" data-pk=' + row['gId'] + '>' + checkStates.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
                {
                    targets: "dName_th",
                    render: function (data, type, row) {
                        return '<a class="dName" id="dName" data-name="dName"  data-type="text" data-pk=' + row['gId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "benefit_th",
                    render: function (data, type, row) {
                        return '<a class="benefitSide" id="benefitSide" data-name="benefitSide"  data-type="text" data-pk=' + row['gId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "authorized_th",
                    render: function (data, type, row) {
                        return '<a class="authorizedName" id="authorizedName" data-name="authorizedName"  data-type="text" data-pk=' + row['gId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "details_th",
                    render: function (data, type, row) {
                        return '<a class="details" id="details" data-name="details"  data-type="text" data-pk=' + row['gId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "amount_th",
                    render: function (data, type, row) {
                        return '<a class="amount" id="amount" data-name="amount"  data-type="text" data-pk=' + row['gId'] + '>' + data + '</a>'
                    }
                },
            ],
            fnInitComplete:

                function () {

                    addSearchControl();
                    $( "#sp_th" ).select2();
                    $( "#type_th" ).select2();

                }
        } )
        emTable.on( 'draw', function () {
            <?php if (checkPermission($data['permissions'], 'StateChange'))  : ?>
            selectFromSource( ".state", "<?php echo URLROOT . "/main/edit";?>", states );
            <?php endif;?>
            <?php if (checkPermission($data['permissions'], 'Checker'))  : ?>
            selectFromSource( ".isChecked", "<?php echo URLROOT . "/main/edit";?>", checkStates );
            <?php endif;?>

            <?php if (checkPermission($data['permissions'], 'EditGift')):?>
            selectFromSource( ".tId", "<?php echo URLROOT . "/main/edit";?>", moneyTypes );
            selectFromSource( ".sId", "<?php echo URLROOT . "/main/edit";?>", specifications );

            make_editable_x( '.dName', "<?php echo URLROOT . "/main/edit";?>" );
            make_editable_x( '.amount', "<?php echo URLROOT . "/main/edit";?>" );
            make_editable_x( '.details', "<?php echo URLROOT . "/main/edit";?>" );

            <?php endif;?>
            <?php if (checkPermission($data['permissions'], 'EditGift') || checkPermission($data['permissions'], 'SubEdit')):?>
            make_editable_x( '.benefitSide', "<?php echo URLROOT . "/main/edit";?>" );
            make_editable_x( '.authorizedName', "<?php echo URLROOT . "/main/edit";?>" );
            <?php endif;?>
        } )

        function addSearchControl() {

            $( "#detailsTable thead" ).append( $( "#detailsTable thead tr:first" ).clone() );
            $( "#detailsTable thead tr:eq(1) th" ).each( function (index) {

                addFilterDropDownToDataTable( emTable, specifications, index, this, "sp_th", "detailsTable" );
                addFilterDropDownToDataTable( emTable, moneyTypes, index, this, "type_th", "detailsTable" );
                addFilterDropDownToDataTable( emTable, checkStates, index, this, "check_th", "detailsTable" );
                addFilterDropDownToDataTable( emTable, states, index, this, "state_th", "detailsTable" );

                addFilterTextToDataTable( emTable, index, this, "dName_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "amount_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "user_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "details_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "benefit_th", "detailsTable" );
                addFilterTextToDataTable( emTable, index, this, "authorized_th", "detailsTable" );
                $( this ).replaceWith( "<th></th>" );
            } );
        }

        $( '#min, #max' ).on( 'change', function () {
            emTable.draw();
        } );

        $( document ).on( 'click', '[id^="infoItem-"]', function () {
            const id = this.id.split( '-' ).pop();
            itemInfoFunction( '<?php echo URLROOT . "/users/getUserById/";?>' + id );
        } );
        $( document ).on( 'click', '[id^="delete-item-"]', function () {
            var button = $( this );
            var id = this.id.split( '-' ).pop();

            deleteFunction( "حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/main/edit";?>", id, emTable, button );

        } );
    } );


</script>


