<?php require APPROOT . '/views/inc/header.php'; ?>


<script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">

<div class="MA-vistitem">

    <div class="ma-left1">
        <form class="nameFoo2 so" method="post" name="addItem" id="addItem">
            <div class="ma-header">
                <div class="ma-back"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة كشف</span></div>
            <table class="sd" width="25%" border="0">
                <tr>
                    <td class="rowone">اسم الكشف</td>
                    <td><input placeholder="اسم الكشف" type="text" id="dName" name="dName" required></td>
                </tr>
                <tr>
                    <td class="rowone">تأريخ بدأ الكشف</td>
                    <td><input type="date" id="startIn" name="startIn" value="<?= date('Y-m-01') ?>"></td>
                </tr>
                <tr>
                    <td class="rowone">تأريخ انتهاء الكشف</td>
                    <td><input type="date" id="endAt" name="endAt" value="<?= date('Y-m-d') ?>"></td>
                </tr>

                <tr>
                    <td class="rowone">الملاحظات</td>
                    <td><input placeholder="الملاحظات" type="text" id="notes" name="notes" required></td>
                </tr>

            </table>
            <div class="ma-tu">

                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                    <input id="submit" class="ma-add" type="submit" name="Submit" value="حفظ">
                <?php endif; ?>
                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                    (checkPermission($data['permissions'], 'EditGift'))): ?>
                    <a href="<?php echo URLROOT . "/main/details/3" ?>"><input class="ma-add two" value="جدول الكشوفات">
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
    $( document ).ready( function () {

        $( ".ma-back" ).click( function () {
            window.location = '<?php echo URLROOT . "/main" ?>';
        } );
        $( ".ma-forplace" ).select2();
        <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
        function addDetection(formId) {
            $( "#" + formId ).submit( function (event) {
                    const form = $( "#" + formId );
                    var params = form.serializeArray();
                    var formData = new FormData();
                    $( params ).each( function (index, element) {
                        formData.append( element.name, element.value );
                    } );
                    $( "#submit" ).val( "جار الحفظ..." );
                    $( "#submit" ).attr( "disabled", true );
                    $.ajax( {
                        url: '<?php echo URLROOT . "/detections/add";?>',
                        method: "post",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            const json = $.parseJSON( response );
                            if (json != "err") {
                                showAlertWithCompletion( "success", "تمت الاضافة بنجاح",
                                    () => {
                                        $( "#" + formId ).trigger( "reset" );
                                        $( "#submit" ).attr( "disabled", false );
                                        $( "#submit" ).val( "حفظ" );
                                    }
                                )
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

        addDetection( 'addItem', 0, 'item' )
        <?php endif;?>
    } );
</script>


