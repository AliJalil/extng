$.extend( $.fn.dataTable.defaults, {

    dom: '<"html5buttons"B>lTgitpr',
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
        "processing": "جار المعالجة...",

        "zeroRecords": "لا توجد بيانات مطابقة للبحث",
        "paginate":
            {
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
    buttons: [
        {
            extend: 'copy',
            text: 'نسخ الى الحافظة',
            className: 'exportExcel',
            exportOptions: {
                modifier: {
                    search: 'applied',
                    order: 'applied'
                },
                columns: ':visible'
            }
        },
        {
            extend: 'excel',
            text: 'تصدير ملف اكسل',
            exportOptions: {
                modifier: {
                    search: 'applied',
                    order: 'applied'
                },
                columns: ':visible'
            }
        },
        {
            extend: 'csv',
            text: 'تصدير ملف CVS',

            exportOptions: {
                modifier: {
                    search: 'applied',
                    order: 'applied'
                },
                columns: ':visible'
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
                columns: ':visible'
            }
        },
    ],

    lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "الكل"]],
    pageLength: 5,
});

function addFilterDropDownToDataTable(dataTable, dropdownDataSource, index, th, thClassName,tableId) {
    if ($( th ).hasClass( thClassName )) {
        // const y = dropdownDataSource.map( dropdownDataSource => dropdownDataSource.text );
        const selectDropDown = $( "<select  class='form-control' id='"+thClassName+"'/>" );
        selectDropDown.append( $( "<option/>" ).attr( "value", "" ).text( 'اختر' ) );

        $.each(dropdownDataSource, function(key, value) {
            selectDropDown
                .append( $( "<option></option>" )
                    .attr( "value", value.value )
                    .text( value.text ) );
        });

        $( th ).replaceWith( "<th>" + selectDropDown.prop( "outerHTML" ) + "</th>" );
        const dropControl = $( "#"+tableId+" thead tr:eq(1) th:eq('" + index + "') select" );
        dropControl.on( "change",
            function () {
                dataTable.column( index ).search( dropControl.val() ).draw();
            } );
    }
}

function addFilterTextToDataTable(dataTable, index, th, thClassName,tableId) {

    if ($( th ).hasClass( thClassName )) {
        $( th ).replaceWith( "<th><input type='text' class='form-control' placeholder='ابحث'></input></th>'" );
        var searchControl = $( "#"+tableId+" thead tr:eq(1) th:eq('" + index + "') input" );
        searchControl.on( "keyup",
            function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    // Do something
                    dataTable.column( index ).search( searchControl.val() ).draw();
                }
            } );
    }
}

function deleteFunction(title, msg, url, id, dataTable, button) {

    Swal.fire( {
        title: title,
        text: msg,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "نعم",
        cancelButtonText: "لا",
        confirmButtonColor: "#ec6c62",
        cancelButtonColor: '#d33',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return $.ajax( {
                url: url,
                type: "POST",
                data: {
                    'value': '1',
                    'name': 'isDeleted',
                    "pk": id
                },
                success: function () {
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert( "Status: " + textStatus );
                    alert( "خظأ: " + errorThrown );
                }
            } )
                .then( response => {
                    try {
                        response = $.parseJSON( response );
                        if (response == "err") {
                            throw new Error( "لم يتم الحذف, حدث خطأ ما" )
                        }
                        return response
                    } catch (error) {
                        swal.close();
                        showAlert( 'error', ` ${error.message}` );
                    }
                } )
        },
        allowOutsideClick: () => !swal.isLoading()
    } ).then( (result) => {
        if (result.value) {
            dataTable.row( $( button ).parents( 'tr' ) ).remove().draw();
            swal.close();
            showAlert( 'success', 'تم الحذف بنجاح' );
        }
    } );
}

jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }

        return a + b;
    }, 0 );
} );




