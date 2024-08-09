function showAlert(type, title) {
    const Toast = Swal.mixin( {
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    } );
    setTimeout( () => {
        Toast.fire( {
            type: type,
            title: title
        } )
    }, 1500 );
}

function showAlertWithCompletion(type, title, completion) {
    const Toast = Swal.mixin( {
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    } );
    setTimeout( () => {
        Toast.fire( {
            type: type,
            title: title
        } )
    }, 1500 );
    completion()
}

function populate(select, dataSource) {
    for (let i = 0; i < dataSource.length; i++) {
        var opt = dataSource[i]['text'];
        let el = document.createElement( "option" );
        el.textContent = opt;
        el.value = dataSource[i]['value'];
        select.appendChild( el );
    }
}

function populateSelectFromDs(c_selector, dataSource) {
    let select = document.getElementById( c_selector );
    for (let i = 0; i < dataSource.length; i++) {
        var opt = dataSource[i]['text'];
        let el = document.createElement( "option" );
        el.textContent = opt;
        el.value = dataSource[i]['value'];
        select.appendChild( el );
    }
}

function setValidationMSG(c_selector, message) {
    // var element = $("#city")[0];
    // element.setCustomValidity('The email address entered is already registerd.');

    $( c_selector )[0].setCustomValidity( message );
    $( c_selector )[0].validity.customError;
}

function selectFromSourceTB(table_selector, column_selector, ajax_url, listSource, title) {

    $( table_selector ).editable( {
        source: listSource,
        selector: column_selector,
        url: ajax_url,
        ajaxOptions: {
            type: 'post'
        },
        title: title,
        type: "POST",
        dataType: 'json'
    } );
    $.fn.editable.defaults.mode = 'inline';
}

function selectFromSource(column_selector, ajax_url, listSource) {

    $( column_selector ).editable( {
        mode: 'inline',
        source: listSource,
        url: ajax_url,
        type: "POST",
        dataType: 'json'
    } );
}

//Make Editable
function make_editable_x(column_selector, ajax_url) {
    $( column_selector ).editable( {
        url: ajax_url,
        type: "POST",
        dataType: 'json',
        mode: 'inline',
        success: function (response, value) {

            var json = $.parseJSON( response );

            if (json == "err") {
                showAlert( "error", 'يرجى التاكد من البيانات المدخلة' )
            } else {
                showAlert( "success", '  تم التعديل بنجاح' )
            }
        }
    } );
}

function isNumberKey(txt, evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.value.indexOf( '.' ) === -1) {
            return true;
        } else {
            return false;
        }
    } else {
        if (charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
    }
    return true;
}

function replaceImage(id, name, ajaxUrl, imgId, uploadName = "img") {

    Swal.fire( {
        title: "<b>تغيير الصورة </b>",
        html: "هل تود رفع صورة جديدة لـ  <b>" + name + "؟ </b>" +
            "<style>.bInput{border: 1px solid #ddd; border-radius: 5px; padding: 5px;margin: 5px}</style>" +
            "<div class='panel panel-default'> <div class='panel-heading'> قم باختيار الصورة " +
            "</div><div class='panel-body'>" +
            " <form enctype='multipart/form-data' name='addProgForm' method='post' id='imageUploadForm'>" +
            " <input  id='img' type='file'  accept='image/*' name='img'  " +
            ">" +
            "</form>" +
            "</div></div>",

        showCancelButton: true,
        confirmButtonText: "<u>رفع</u>",
        cancelButtonText: "الغاء",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#ec6c62",
        cancelButtonColor: '#d33',
        preConfirm: () => {


            //getting form into Jquery Wrapper Instance to enable JQuery Functions on form

            var files = $( "#img" )[0].files;
            //Declaring new Form Data Instance
            var formData = new FormData();
            //Looping through uploaded files collection in case there is a Multi File Upload. This also works for single i.e simply remove MULTIPLE attribute from file control in HTML.
            for (var i = 0; i < files.length; i++) {
                formData.append( uploadName, files[i] );
            }
            formData.append( "id", id );
            var btn = $( this );
            btn.val( "جار التحميل..." );
            btn.prop( "disabled", true );
            $.ajax( {
                url: ajaxUrl,
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    //Firing event if File Upload is completed!
                    btn.prop( "disabled", false );
                    btn.val( "حفظ" );
                    $( "#img" ).val( "" );
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    swal.close();
                    showAlert( 'error', "خظأ: " + errorThrown )
                }
            } )
                .then( response => {
                    try {
                        response = $.parseJSON( response );
                        if (response == "err") {
                            throw new Error( "لم يتم التعديل, حصل خطأ ما" )
                        }
                        if (response == "50") {
                            throw new Error( 'يرجى اختيار ملف من نوع صورة' );
                        }

                        return response
                    } catch (error) {
                        swal.close();
                        showAlert( 'error', ` ${error.message}` )
                    }
                } );

        },

        allowOutsideClick: () => !swal.isLoading()
    } )
        .then( (result) => {
            if (result.value) {
                swal.close();
                showAlert( 'success', 'تم تغير الصورة بنجاح' );
                readURL( '#img', imgId )
            }
        } );

}


var checkStates = [
    {value: 0, text: 'غير مدخل'},
    {value: 1, text: 'دققت'},
    {value: 2, text: 'لم تدقق'},];

var states = [
    {value: 0, text: 'غير محدد'},
    {value: 1, text: 'نعم'},
    {value: 2, text: 'لا'},];

var activeStates = [{value: 1, text: 'فعال'},
    {value: 0, text: 'غير فعال'},];

var gWeights = [
    {value: 0, text: 'غير مدخل'},
    {value: 1, text: 'عيار ٩'},
    {value: 2, text: 'عيار ١٢'},
    {value: 3, text: 'عيار ١٤'},
    {value: 4, text: 'عيار ١٧'},
    {value: 5, text: 'عيار ١٨'},
    {value: 6, text: 'عيار ٢١'},
    {value: 7, text: 'عيار ٢٢'},
    {value: 8, text: 'عيار ٢٤'},
];

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

function itemInfoFunction(data = "",) {

    swal.fire({
        title: "طباعة الباركود",
        text: "قم بالضغط على طباعة",
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'طباعة',
        cancelButtonText: "الغاء",
        html: "<b>" + name + " </b>" +
            "<table id='pointsTable' style='border: none' class='table table-hover table-bordered table-striped table-resource-list table-databases' width='100%'" +
            "       cellspacing='10px' >" +
            "    <tr>" +
            "<td>" +
            "<div style=' display: flex;" +
            "  justify-content: center;'  id='qrcode'></div>" +
            "</td>" +
            "    </tr>" +
            "</table>",
    }).then((result) => {
        if (result.isConfirmed) {
            printData()
        }
    });

    if (data) {
        var txt = "";
        var qrcode = new QRCode( document.getElementById( "qrcode" ), {
            text: data,
            width: 250,
            height: 250,
            colorDark: "#E93C3C",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        } );
    }
}

function printData() {
    var divToPrint = document.getElementById( "qrcode" );
    newWin = window.open( "" );
    newWin.document.write( divToPrint.outerHTML );
    newWin.print();
    newWin.close();
}

