<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<script src="<?php echo URLROOT . "/public/vendor/qrcode.min.js" ?>"></script>
<script src="<?php echo URLROOT . "/public/vendor/lazysizes.min.js" ?>"></script>

<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<div class="ma-alltable">

    <div class="nmbjiu"><a href="<?php echo URLROOT . "/main/"; ?>">
            <button class="ma-back"><i class="fas fa-home"></i></button>
        </a></div>
    <div class="container">
        <div class="ma-header yu"><h3 class="gh" align="center">معلومات المطافئ</h3></div>

        <div class="table-responsive">
            <table id="detailsTable"
                   class="table table-striped table-bordered">
                <thead>
                <tr class="mjk" pcolor=#CCCCCC>
                    <th class="exSeq_th">التسلسل</th>
                    <th class="exNo_th">الرقم</th>
                    <th class="exName_th">الاسم</th>
                    <th class="exType_th">النوع</th>
                    <th class="exSize_th">الحجم</th>
                    <th class="exPlace_th">المكان</th>
                    <th class="exNotes_th">الملاحظات</th>
                    <th class="exState_th">الحالة</th>
                    <th class="action_th">الاجراء</th>
                </tr>

                </thead>
                <!--End of Header-->
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        let sizes = <?php echo $data['sizes']; ?>;
        let types = <?php echo $data['types']; ?>;

        var emTable = $('#detailsTable').DataTable({
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,

            'ajax': {
                'url': '<?php echo URLROOT . "/main/details" ?>',
                "type": 'POST',
                "data": function (data) {
                },
            },
            columns: [
                {data: 'exSeq'},
                {data: 'exNo'},
                {data: 'exName'},
                {data: 'exType'},
                {data: 'exSize'},
                {data: 'exPlace'},
                {data: 'notes'},
                {
                    data: 'state',
                    render: function (data, type, row) {
                        var state = "صالح";
                        var txt = "";
                        if (row['state'] == 2) {
                            state = 'تالف';
                        }
                        return '<a class="state" id="state" data-name="state"  data-type="select" data-emptytext="فارغ" data-pk=' + row['exId'] + '>' + state + '</a>' +
                            txt +
                            '</div>';
                    }
                },
                {
                    data: 'exId',
                    render: function (data, type, row) {
                        return '<div style="margin-top: 5px">' +
                            '                             <a target="_blank" href="<?php

                                echo URLROOT . "/detections/details/0/"; ?>' + row['exId'] + '/0"style="transition: all 0.3s; background: #EDEDED;color: red;" data-toggle="tooltip" title="معاينة الكشف"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-eye"></i>' +
                            '                            </a>' +
                            '                             <a href="<?php echo URLROOT . "/detections/addDetectionInfo/0/"; ?>' + row['exId'] + '"style="transition: all 0.3s; background: #EDEDED;color: red;" data-toggle="tooltip" title="اضافة كشف للمطفئة"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-sensor-fire"></i>' +
                            '                            </a>' +

                            '                            <button style="transition: all 0.3s; background: #EDEDED;color: red;" id="QR-item-' + data + '" data-toggle="tooltip" title="طباعة QR"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-qrcode" style="color: #717884;"></i>' +
                            '                            </button>' +
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
                    targets: "exSeq_th",
                    render: function (data, type, row) {
                        return '<a class="exSeq" id="exSeq" data-name="exNo"  data-type="text" data-pk=' + row['exId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "exNo_th",
                    render: function (data, type, row) {
                        return '<a class="exNo" id="exNo" data-name="exNo"  data-type="text" data-pk=' + row['exId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "exType_th",
                    render: function (data, type, row) {
                        return '<a class="exType" id="exType" data-name="exType"  data-type="select" data-pk=' + row['exId'] + '>' + types.filter(state => state.value == data)[0].text + '</a>'
                    }
                },
                {
                    targets: "exSize_th",
                    render: function (data, type, row) {
                        return '<a class="exSize" id="exSize" data-name="exSize"  data-type="select" data-pk=' + row['exId'] + '>' + sizes.filter(state => state.value == data)[0].text + '</a>'
                    }
                },

                {
                    targets: "exState_th",
                    render: function (data, type, row) {
                        return '<a class="state" id="state" data-name="state"  data-type="select" data-pk=' + row['exId'] + '>' + states.filter(state => state.value == data)[0].text + '</a>'
                    }
                },

                {
                    targets: "exName_th",
                    render: function (data, type, row) {
                        return '<a class="exName" id="exName" data-name="exName"  data-type="text" data-pk=' + row['exId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "exPlace_th",
                    render: function (data, type, row) {
                        return '<a class="exPlace" id="exPlace" data-name="exPlace"  data-type="text" data-pk=' + row['exId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "exNotes_th",
                    render: function (data, type, row) {
                        return '<a class="notes" id="notes" data-name="notes"  data-type="text" data-pk=' + row['exId'] + '>' + data + '</a>'
                    }
                },
            ],
            fnInitComplete: function () {
                addSearchControl();
                $("#exSize_th").select2();
                $("#exType_th").select2();
            }
        })

        emTable.on('draw', function () {

            <?php if (checkPermission($data['permissions'], 'EditGift')):?>
            selectFromSource(".state", "<?php echo URLROOT . "/main/edit";?>", states);
            selectFromSource(".exType", "<?php echo URLROOT . "/main/edit";?>", types);
            selectFromSource(".exSize", "<?php echo URLROOT . "/main/edit";?>", sizes);
            make_editable_x('.exSeq', "<?php echo URLROOT . "/main/edit";?>");
            make_editable_x('.exNo', "<?php echo URLROOT . "/main/edit";?>");
            make_editable_x('.exName', "<?php echo URLROOT . "/main/edit";?>");
            make_editable_x('.exPlace', "<?php echo URLROOT . "/main/edit";?>");
            make_editable_x('.notes', "<?php echo URLROOT . "/main/edit";?>");

            <?php endif;?>
        })

        $(document).on('click', '[id^="infoItem-"]', function () {
            const id = this.id.split('-').pop();
            itemInfoFunction('<?php echo URLROOT . "/users/getUserById/";?>' + id);
        });

        function addSearchControl() {

            $("#detailsTable thead").append($("#detailsTable thead tr:first").clone());
            $("#detailsTable thead tr:eq(1) th").each(function (index) {

                addFilterDropDownToDataTable(emTable, sizes, index, this, "exSize_th", "detailsTable");
                addFilterDropDownToDataTable(emTable, types, index, this, "exType_th", "detailsTable");
                addFilterDropDownToDataTable(emTable, checkStates, index, this, "check_th", "detailsTable");
                addFilterDropDownToDataTable(emTable, states, index, this, "exState_th", "detailsTable");

                addFilterTextToDataTable(emTable, index, this, "exName_th", "detailsTable");
                addFilterTextToDataTable(emTable, index, this, "exNotes_th", "detailsTable");
                addFilterTextToDataTable(emTable, index, this, "exPlace_th", "detailsTable");
                $(this).replaceWith("<th></th>");
            });
        }

        $('#min, #max').on('change', function () {
            emTable.draw();
        });

        $(document).on('click', '[id^="delete-item-"]', function () {
            var button = $(this);
            var id = this.id.split('-').pop();
            deleteFunction("حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/main/edit";?>", id, emTable, button);
        });


        $(document).on('click', '[id^="QR-item-"]', function () {
            var id = this.id.split('-').pop();
            console.log(id);
            itemInfoFunction(id);
        });

    });


</script>


