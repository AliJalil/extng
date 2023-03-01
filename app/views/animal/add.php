<?php require APPROOT . '/views/inc/header.php'; ?>
<script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">

<div class="MA-vistitem">

    <div class="ma-left1">
        <form class="nameFoo3 so" method="post" id="addAnimal" name="form1">
            <div class="ma-header">
                <div class="ma-back"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة تبرع</span></div>
            <table class="qw" width="25%" border="0">
                <tr>
                    <td class="rowone">اسم المتبرع</td>
                    <td><input placeholder="اسم المتبرع" type="text" id="dName" name="dName" required></td>
                </tr>
                <tr>
                    <td class="rowone">النوع</td>
                    <td>
                        <select class="ma-forplace" type="text" id="animalTId" name="tId"
                                required>
                            <option value="">اختر النوع</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="rowone">العدد</td>
                    <td><input onkeypress="return isNumberKey(this, event);" placeholder=" العدد" type="text"
                               id="amount" name="amount" required>

                    </td>
                </tr>
            </table>
            <div class="ma-tu">
                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                    <input id="submit" class="ma-add" type="submit" name="Submit" value="حفظ">
                <?php endif; ?>
                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                    (checkPermission($data['permissions'], 'EditGift')) ||
                    (checkPermission($data['permissions'], 'Checker'))): ?>
                    <a href="<?php echo URLROOT . "/main/details/4" ?>"><input class="ma-add two" value="جدول الانعام">
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

        $( ".ma-forplace" ).select2();
        <?php if (checkPermission($data['permissions'], 'AddGift')): ?>

        let types = <?php echo $data['types']; ?>;
        const animalTypes = types.filter( type => type.dType == 4 )
        populateSelectFromDs( "animalTId", animalTypes );

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

        addGift( 'addAnimal', 0, 'animal' )
        <?php endif;?>
    } );
</script>


