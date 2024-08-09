<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/detectPage.css" ?>" crossorigin="anonymous">
<div class="row parentDiv">

    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label" style="text-align: center;font-size: 20px">قم باضافة المطافئ لمنتسب
                <!--                 --><?php //echo $data['extinguishersSelected']->zName ?>
            </label><br>
            <input type="hidden" id="dId" value="1">
        </div>
    </div>


    <tr>
        <td>
            <select class="ma-forplace" name="userId" id="userId"
                    required>
                <option value="">اختر المنتسب</option>
            </select>
        </td>
    </tr>

    <div class="tab col-md-6 detectDiv">
        <label  style="text-align: center;font-size: 15px">المطافئ الموزعة</label><br>
        <table id="table2"
               class="table table-hover table-bordered table-striped table-resource-list table-databases" width="100%"
               cellspacing="10px">
            <thead>
            <tr class="header-back-ground">
                <th class="header-label"></th>
                <th class="header-label"></th>
                <th class="header-label first-header-lbl"> رقم المطفئة</th>
                <th class="header-label">اسم المطفئة</th>
                <th class="header-label last-header-lbl">اسم المنتسب</th>
            </tr>
            </thead>
            <?php foreach ($data['extinguishersSelected'] as $extinguir) :
                $exId = $extinguir->exId;
                ?>
                <tr>
                    <td> <?php echo $exId ?> </td>
                    <td> <?php echo $extinguir->userId ?> </td>

                    <td> <?php echo $extinguir->exNo ?> </td>
                    <td> <?php echo $extinguir->exName ?> </td>
                    <td> <?php echo $extinguir->name ?> </td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tab col-md-6 detectDiv">

        <label class="control-label" style="text-align: center;font-size: 15px">المطافئ المتوفرة</label><br>

        <table id="table1"
               class="table table-hover table-bordered table-striped table-resource-list table-databases" width="100%"
               cellspacing="10px">
            <thead>
            <tr class="header-back-ground">
                <th class="header-label"></th>
                <th class="header-label first-header-lbl"> رقم المطفئة</th>
                <th class="header-label last-header-lbl">اسم المطفئة</th>
            </tr>
            </thead>
            <?php foreach ($data['extinguishersNotSelected'] as $extinguir) :
                $exId = $extinguir->exId; ?>
                <tr>
                    <td> <?php echo $exId ?> </td>
                    <td> <?php echo $extinguir->exNo ?> </td>
                    <td> <?php echo $extinguir->exName ?> </td>
                </tr>
                </tr>
            <?php endforeach; ?>
            <!--End of Header-->
        </table>
    </div>

    <div class="tab col-md-12">
        <button onclick="addEmpsToDetection()" class="ma-add" style="width: 100%;margin-bottom: 64px;margin-top: 20px">حفظ</button>
    </div>
</div>

<script>
    // var userIds = [];
    // var exIds = [];

    let users = <?php echo $data['users']; ?>;
    populateSelectFromDs( "userId", users );
    $( ".userId" ).select2();


    var table1 = $( '#table1' ).DataTable( {
            dom: '<"html5buttons"B>flTgitpr',
            language: {
                search: "_INPUT_", //To remove Search Label
                searchPlaceholder: "ابحث هنا...",
                "infoFiltered": "(  المجموع الكلي للسجلات المدخلة _MAX_ )",
                "lengthMenu": "عرض _MENU_ سجل",
                "decimal": "",
                "emptyTable": "لا توجد بيانات لعرضها",
                "info": "عرض من _START_ الى _END_ من مجموع _TOTAL_ سجل",
                "infoEmpty": "عرض 0 من 0 مدخل",
                "infoPostFix": "",
                "thousands": "",
                "loadingRecords": "جار التحميل ...",
                "processing": "جار المعالجة...",
                "zeroRecords": "لا توجد بيانات مطابقة للبحث",
                "paginate": {
                    "first": "الاولى",
                    "last": "الاخيرة",
                    "next": "التالية",
                    "previous": "السابقة"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false,
                    "width": "0%"
                }
            ],
            buttons: [
                {
                    extend: 'excel',
                    text: 'تصدير ملف اكسل',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        },
                        columns: [0, 2, 3]
                    }
                },
                {
                    extend: 'print',
                    text: 'طباعة',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        },
                        columns: [0, 2, 3]
                    }
                },
            ]
        }
    );

    var table2 = $( '#table2' ).DataTable( {
        dom: '<"html5buttons"B>flTgitpr',
        language: {
            search: "_INPUT_", //To remove Search Label
            searchPlaceholder: "ابحث هنا...",
            "infoFiltered": "(  المجموع الكلي للسجلات المدخلة _MAX_ )",
            "lengthMenu": "عرض _MENU_ سجل",
            "decimal": "",
            "emptyTable": "لا توجد بيانات لعرضها",
            "info": "عرض من _START_ الى _END_ من مجموع _TOTAL_ سجل",
            "infoEmpty": "عرض 0 من 0 مدخل",
            "infoPostFix": "",
            "thousands": "",
            "loadingRecords": "جار التحميل ...",
            "processing": "جار المعالجة...",
            "zeroRecords": "لا توجد بيانات مطابقة للبحث",
            "paginate": {
                "first": "الاولى",
                "last": "الاخيرة",
                "next": "التالية",
                "previous": "السابقة"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        columnDefs: [
            {
                "targets": [0],
                "visible": false,
                "searchable": false,
                "width": "0%"
            }, {
                "targets": [1],
                "visible": false,
                "searchable": false,
                "width": "0%"
            }
        ],
        buttons: [
            {
                extend: 'excel',
                text: 'تصدير ملف اكسل',
                exportOptions: {
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    },
                    columns: [0, 2]
                }
            },
            {
                extend: 'print',
                text: 'طباعة',
                exportOptions: {
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    },
                    columns: [0, 2,]
                }
            },
        ]
    } );


    table1.on( 'click', 'tbody tr', function () {
        const row = $( this );
        const rowData = table1.row( row ).data();
        const selectedOption = $( '#userId option:selected' );
        if (selectedOption.val()) { // check if selected option has a value
            rowData.push( selectedOption.text() ); // append selected option text to the row data
            rowData.splice(1, 0,  selectedOption.val());//push selectedOption into the second index of the rowData
            table2.row.add( rowData ).draw(); // add row to second table
            table1.row( row ).remove().draw(); // remove row from first table
        } else {
            showAlert( "warning", 'يرجى اختيار منتسب اولا' );
            $( '#userId' ).focus();
        }
    } );

    table2.on( 'click', 'tbody tr', function () {
        const $row = $( this );
        const addRow = table2.row( $row );
        const rowData = addRow.data();
        const dataCount = table2.data().length;

        if (dataCount > 0) {
            rowData.splice(1, 1); // remove the element at index 1 of the rowData array
            table1.row.add( rowData ).draw();
            addRow.remove().draw();
        }
    } );

    function get1DArray(arr) {
        return arr.join().split( "," );
    }

    function addEmpsToDetection() {

        var userIds = [];
        var exIds = [];
        table2.rows().every( function () {
            userIds.push( table2.cells( this, [1] ).data().toArray() );
            exIds.push( table2.cells( this, [0] ).data().toArray() );
        } );

        if (userIds.length === 0) {
            showAlert( "warning", "يرجى ملء بيانات الكشف اولا" )
            return;
        }
        var dId = $( '#dId' ).val() ? $( '#dId' ).val() : "-1";
        var formData = new FormData;
        formData.append( "dId", dId );
        formData.append( "exIds", JSON.stringify(get1DArray(exIds) ));
        formData.append( "userIds", JSON.stringify(get1DArray(userIds)));
        $( "#submit" ).val( "جار الحفظ..." );
        $( "#submit" ).attr( "disabled", true );

        $.ajax( {
            url: '<?php echo URLROOT . "/detections/detect";?>',
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                //Firing event if File Upload is completed!
                $( "#submit" ).val( "حفظ" );
                $( "#submit" ).attr( "disabled", false );
                showAlert( "success", "تمت الاضافة بنجاح" )
                $( '#addCenter' ).trigger( "reset" );

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert( "Status: " + textStatus );
                alert( "خظأ: " + errorThrown );
            }
        } );

        return false;
    }

</script>

</body>
</html>
