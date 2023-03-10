





function showAlert(type,title) {
    const Toast = Swal.mixin( {
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    } );
    setTimeout( () => {
        Toast.fire( {
            type: type,
            title:title
        } )
    }, 1500 );
}

function showAlertWithCompletion(type,title,completion) {
    const Toast = Swal.mixin( {
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    } );
    setTimeout( () => {
        Toast.fire( {
            type: type,
            title:title
        } )
    }, 1500 );
    completion()
}
function populate(select,dataSource)
{
    for (let i = 0; i < dataSource.length; i++) {
        var opt = dataSource[i]['text'];
        let el = document.createElement("option");
        el.textContent = opt;
        el.value = dataSource[i]['value'];
        select.appendChild(el);
    }
}

function populateSelectFromDs(c_selector, dataSource) {
    let select = document.getElementById(c_selector);
    for (let i = 0; i < dataSource.length; i++) {
        var opt = dataSource[i]['text'];
        let el = document.createElement("option");
        el.textContent = opt;
        el.value = dataSource[i]['value'];
        select.appendChild(el);
    }
}


function setValidationMSG(c_selector, message) {
    // var element = $("#city")[0];
    // element.setCustomValidity('The email address entered is already registerd.');

    $(c_selector)[0].setCustomValidity(message);
    $(c_selector)[0].validity.customError;
}

function selectFromSourceTB(table_selector, column_selector, ajax_url, listSource, title) {

    $(table_selector).editable({
        source: listSource,
        selector: column_selector,
        url: ajax_url,
        ajaxOptions: {
            type: 'post'
        },
        title: title,
        type: "POST",
        dataType: 'json'
    });
    $.fn.editable.defaults.mode = 'inline';
}

function selectFromSource(column_selector, ajax_url, listSource) {

    $(column_selector).editable({
        mode: 'inline',
        source: listSource,
        url: ajax_url,
        type: "POST",
        dataType: 'json'
    });
}

//Make Editable
function make_editable_x(column_selector, ajax_url) {
    $( column_selector ).editable( {
        url:ajax_url,
        type: "POST",
        dataType: 'json',
        mode: 'inline',
        success: function (response, value) {

            var json = $.parseJSON(response);

            if (json == "err") {
                showAlert("error", '???????? ???????????? ???? ???????????????? ??????????????')
            }else {
                showAlert("success",  '  ???? ?????????????? ??????????')
            }
        }
    } );
}

function isNumberKey(txt, evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.value.indexOf('.') === -1) {
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

function replaceImage(id, name, ajaxUrl,imgId,uploadName = "img") {

    Swal.fire({
        title: "<b>?????????? ???????????? </b>",
        html: "???? ?????? ?????? ???????? ?????????? ????  <b>" + name + "?? </b>" +
            "<style>.bInput{border: 1px solid #ddd; border-radius: 5px; padding: 5px;margin: 5px}</style>" +
            "<div class='panel panel-default'> <div class='panel-heading'> ???? ?????????????? ???????????? " +
            "</div><div class='panel-body'>" +
            " <form enctype='multipart/form-data' name='addProgForm' method='post' id='imageUploadForm'>" +
            " <input  id='img' type='file'  accept='image/*' name='img'  " +
            ">" +
            "</form>" +
            "</div></div>",

        showCancelButton: true,
        confirmButtonText: "<u>??????</u>",
        cancelButtonText: "??????????",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#ec6c62",
        cancelButtonColor: '#d33',
        preConfirm: () => {


            //getting form into Jquery Wrapper Instance to enable JQuery Functions on form

            var files = $("#img")[0].files;
            //Declaring new Form Data Instance
            var formData = new FormData();
            //Looping through uploaded files collection in case there is a Multi File Upload. This also works for single i.e simply remove MULTIPLE attribute from file control in HTML.
            for (var i = 0; i < files.length; i++) {
                formData.append(uploadName, files[i]);
            }
            formData.append("id", id);
            var btn = $(this);
            btn.val("?????? ??????????????...");
            btn.prop("disabled", true);
            $.ajax({
                url: ajaxUrl,
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    //Firing event if File Upload is completed!
                    btn.prop("disabled", false);
                    btn.val("??????");
                    $("#img").val("");
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    swal.close();
                    showAlert('error',"??????: " + errorThrown)
                }
            })
                .then(response =>
                {
                    try {
                        response = $.parseJSON(response);
                        if (response == "err") {
                            throw new Error("???? ?????? ??????????????, ?????? ?????? ????")
                        }
                        if (response == "50") {
                            throw new Error('???????? ???????????? ?????? ???? ?????? ????????');
                        }

                        return response
                    } catch (error)
                    {
                        swal.close();
                        showAlert('error',` ${error.message}`)
                    }
                });

        },

        allowOutsideClick: () => !swal.isLoading()
    })
        .then( (result) => {
            if (result.value) {
                swal.close();
                showAlert('success','???? ???????? ???????????? ??????????');
                readURL('#img',imgId)
            }
        });

}


var checkStates = [
    {value: 0, text: '?????? ????????'},
    {value: 1, text: '????????'},
    {value: 2, text: '???? ????????'},];

var states = [{value: 1, text: '????????'},
    {value: 2, text: '????????'},];

var activeStates = [{value: 1, text: '????????'},
    {value: 0, text: '?????? ????????'},];

var gWeights = [
    {value: 0, text: '?????? ????????'},
    {value: 1, text: '???????? ??'},
    {value: 2, text: '???????? ????'},
    {value: 3, text: '???????? ????'},
    {value: 4, text: '???????? ????'},
    {value: 5, text: '???????? ????'},
    {value: 6, text: '???????? ????'},
    {value: 7, text: '???????? ????'},
    {value: 8, text: '???????? ????'},
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
