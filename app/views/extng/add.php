<?php require APPROOT . '/views/inc/header.php'; ?>

<script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">


<div class="MA-vistitem">


    <div class="ma-left">
        <form id="addExtinguisher" class="nameFoo so" method="post" name="addExtinguisher">
            <div class="ma-header">
                <div class="ma-back"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة معلومات مطفئة</span></div>
            <table class="qw" border="0">

                <tr>
                    <td class="rowone">التسلسل</td>
                    <td><input placeholder="التسلسل" type="number" name="exSeq" id="exSeq" required></td>
                </tr>
                <tr>
                    <td class="rowone">الرقم</td>
                    <td><input placeholder="الرقم" type="number" name="exNo" id="exNo" required></td>
                </tr>
                <tr>
                    <td class="rowone">الاسم</td>
                    <td><input placeholder="الاسم" type="text" name="exName" id="exName" required></td>
                </tr>

                <tr>
                    <td class="rowone">النوع</td>
                    <td>
                        <select class="ma-forplace" name="exType" id="exType"
                                required>
                            <option value="">اختر النوع</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="rowone">الحجم</td>
                    <td>
                        <select class="ma-forplace" name="exSize" id="exSize"
                                required>
                            <option value="">اختر الحجم</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="rowone">المكان</td>
                    <td><input placeholder="المكان" type="text" name="exPlace" id="exPlace" required></td>
                </tr>

                <tr>
                    <td class="rowone">الملاحظات</td>
                    <td><input placeholder="الملاحظات" type="text" name="notes" id="notes" required></td>
                </tr>
            </table>

            <div class="ma-tu">

                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                    <input id="submit" class="ma-add" type="submit" name="Submit" value="حفظ">
                <?php endif; ?>
                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                    (checkPermission($data['permissions'], 'EditGift'))): ?>
                    <a href="<?php echo URLROOT . "/main/details/1" ?>"><input class="ma-add two"
                                                                               value="معلومات المطافئ"></a>
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

        let sizes = <?php echo $data['sizes']; ?>;
        populateSelectFromDs( "exSize", sizes );

        let types = <?php echo $data['types']; ?>;
        populateSelectFromDs( "exType", types );

        function addExtinguisher(formId) {
            $( "#" + formId ).submit( function (event) {
                    const form = $( "#" + formId );
                    var params = form.serializeArray();
                    var formData = new FormData();

                    $( params ).each( function (index, element) {
                        formData.append( element.name, element.value );
                    } );

                    //disabling Submit Button so that user cannot press Submit Multiple times
                    $( "#submit" ).val( "جار الحفظ..." );
                    $( "#submit" ).attr( "disabled", true );
                    $.ajax( {
                        url: '<?php echo URLROOT . "/main/index";?>',
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

        addExtinguisher( 'addExtinguisher' )

        <?php endif;?>
    } );
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>
