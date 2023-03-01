<?php require APPROOT . '/views/inc/header.php'; ?>
<script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">

<div class="MA-vistitem">

    <div class="ma-left1">
        <form class="nameFoo1 so" method="post" id="addGold" name="form">
            <div class="ma-header">
                <div class="ma-back"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة تبرع</span></div>
            <table class="qw jo" width="25%" border="0">
                <tr>
                    <td class="rowone">اسم المتبرع</td>
                    <td><input placeholder="اسم المتبرع" type="text" id="dName" name="dName" required></td>
                </tr>
                <tr>
                    <td class="rowone">التفاصيل</td>
                    <td><input placeholder="التفاصيل" type="text" id="details" name="details" required></td>
                </tr>
                <tr>
                    <td class="rowone">المادة</td>
                    <td><select class="ma-forplace" type="text" id="goldTId" name="tId"
                                required>
                            <option value="">اختر المادة</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="rowone">الوزن</td>
                    <td><input placeholder="الوزن بالغرام" type=number step=any
                               id="amountExtra" name="amountExtra" required>
                        <div id="output"
                             style="font-weight:bold; margin-bottom: 18px;    color:  #007F60;  font-size: 17px;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="rowone">التخصيص</td>
                    <td><select class="ma-forplace sId" placeholder="التخصيص" type="text" id="goldSId" name="sId"
                                required>
                            <option value="">اختر التخصيص</option>
                        </select>
                    </td>
                </tr>

            </table>

            <div class="ma-tu cv">

                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                    <input id="submit" class="ma-add" type="submit" name="Submit" value="حفظ">
                <?php endif; ?>
                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                    (checkPermission($data['permissions'], 'EditGift')) ||
                    (checkPermission($data['permissions'], 'GoldExpert')) ||
                    (checkPermission($data['permissions'], 'Checker'))): ?>
                    <a href="<?php echo URLROOT . "/main/details/2" ?>"><input class="ma-add two" value="جدول الذهب">
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
    $( document ).ready( function () {
        $( ".ma-back" ).click( function () {
            window.location='<?php echo URLROOT . "/main" ?>';
        } );
        $( '#amountExtra' ).on( 'input', function (e) {
            output.innerHTML = tafqeet( this.value, 'WEIGHT' )
        } );

        $( ".ma-forplace" ).select2();
        <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
        let specifications = <?php echo $data['specifications']; ?>;
        populateSelectFromDs( "goldSId", specifications );
        let types = <?php echo $data['types']; ?>;
        const goldTypes = types.filter( type => type.dType == 2 )
        populateSelectFromDs( "goldTId", goldTypes );

        function addGift(formId, sId, printPage) {
            $( "#" + formId ).submit( function (event) {
                    const form = $( "#" + formId );
                    var params = form.serializeArray();
                    var formData = new FormData();
                    formData.append( "sId", sId );
                    $( params ).each( function (index, element) {
                        formData.append( element.name, element.value );
                    } );
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
                                        //window.location =  '<?php //echo URLROOT . "/main/";?>//' + printPage + "/" + json + "/y";
                                        window.open('<?php echo URLROOT . "/main/";?>' + printPage + "/" + json + "/y", "_blank");
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

        addGift( 'addGold', 0, 'gold' )
        <?php endif;?>
    } );
</script>
