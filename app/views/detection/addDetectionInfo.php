<?php require APPROOT . '/views/inc/header.php'; ?>


<script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">


<div class="MA-vistitem">

    <?php
    $currentExting = $data['currentExting'];
    $currentDetection = $data['currentDetection'];
    $currentDetectionId = encrypt_decrypt($currentDetection->dId);
    ?>
    <div class="ma-left">
        <form id="addDetectionInfo" class="nameFoo so" method="post" name="addDetectionInfo">
            <div class="ma-header">
                <div class="ma-back"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة معلومات كشف عن مطفأة</span>
                <span><?php echo $currentDetection->dName ?></span>
                <span><?php echo $currentExting->exName ?> /<?php echo $currentExting->tName ?> /<?php echo $currentExting->exSize ?>  </span>
                <input type="hidden" name="currentDetectionId" value="<?php echo $currentDetectionId?>">
            </div>


            <table class="qw" border="0">

                <tr>
                    <td class="rowone2">هل المطفأة موجودة</td>
                    <td style="justify-content: center;display: flex;">
                        <input type="radio" name="isThere" id="yes" value="1" required>
                        <label for="yes">نعم </label>
                        <input type="radio" name="isThere" id="no" value="2">
                        <label for="no"> لا </label>
                    </td>
                </tr>

                <tr>
                    <td class="rowone2">هل حالة البسمار جيدة؟</td>
                    <td style="justify-content: center;display: flex;">
                        <input type="radio" name="lockIsGood" id="lyes" value="1" required>
                        <label for="lyes">نعم</label>
                        <input type="radio" name="lockIsGood" id="lno" value="2">
                        <label for="lno">لا</label>
                    </td>
                </tr>


                <tr>
                    <td class="rowone2">هل حالة العداد جيدة؟</td>
                    <td style="justify-content: center;display: flex;">
                        <input type="radio" name="gageIsGood" id="gyes" value="1" required>
                        <label for="gyes">نعم</label>
                        <input type="radio" name="gageIsGood" id="gno" value="2">
                        <label for="gno">لا</label>
                    </td>
                </tr>


                <tr>
                    <td class="rowone2">هل حالة الخرطوم جيدة؟</td>
                    <td style="justify-content: center;display: flex;">
                        <input type="radio" name="jetIsGood" id="jyes" value="1" required>
                        <label for="jyes">نعم</label>
                        <input type="radio" name="jetIsGood" id="jno" value="2">
                        <label for="jno">لا</label>
                    </td>
                </tr>

                <tr>
                    <td class="rowone2">هل حالة المقبض جيدة؟</td>
                    <td style="justify-content: center;display: flex;">
                        <input type="radio" name="handleIsGood" id="hyes" value="1" required>
                        <label for="hyes">نعم</label>
                        <input type="radio" name="handleIsGood" id="hno" value="2">
                        <label for="hno">لا</label>
                    </td>
                </tr>


                <tr>
                    <td class="rowone2">هل المطفئة مستخدمة؟</td>
                    <td style="justify-content: center;display: flex;">
                        <input type="radio" name="isUsed" id="iyes" value="1" required>
                        <label for="iyes">نعم</label>
                        <input type="radio" name="isUsed" id="ino" value="2">
                        <label for="ino">لا</label>
                    </td>
                </tr>


                <tr>
                    <td class="rowone">الملاحظات</td>
                    <td><input placeholder="الملاحظات" type="text" name="notes" id="notes" required></td>
                </tr>
            </table>

            <div class="ma-tu">

                <?php if (
                        checkPermission($data['permissions'], 'AddGift') ||
                        checkPermission($data['permissions'], 'StatementViewUser')
                ): ?>
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

        <?php if (checkPermission($data['permissions'], 'AddGift')): ?>

        function addDetectionInfo(formId) {
            $( "#" + formId ).submit( function (event) {
                    const form = $( "#" + formId );
                    var params = form.serializeArray();
                    var formData = new FormData();

                    $( params ).each( function (index, element) {
                        formData.append( element.name, element.value );
                    } );
                    const pathValues = location.pathname.split( "/" );
                    const lastComponents = pathValues.slice( -1 ).join( "/" );

                    //disabling Submit Button so that user cannot press Submit Multiple times
                    $( "#submit" ).val( "جار الحفظ..." );
                    $( "#submit" ).attr( "disabled", true );
                    $.ajax( {
                        url: '<?php echo URLROOT . "/Detections/addDetectionInfo/{$currentDetectionId}/";?>' + lastComponents,
                        method: "post",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            const json = $.parseJSON( response );
                            console.log( json );

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

        addDetectionInfo( 'addDetectionInfo' )

        <?php endif;?>
    } );
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>
