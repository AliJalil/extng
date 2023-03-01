<?php require APPROOT . '/views/inc/header.php'; ?>
<script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
<link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">

<div class="MA-vistitem">


    <div class="ma-span">اختر نوع التبرع</div>
    <div id="selectlist" class="dropdown-list territory" name="territory">

        <div class="ma-op">
            <?php if ((checkPermission($data['permissions'], 'AddGift')) ||
                (checkPermission($data['permissions'], 'Checker'))) : ?>
                <button id="button" class="btn1 ma-rt" name="territory" value="1" data-territory="1">
                    <i class="fas fa-money-bill-wave ma-icon"></i>نقد
                </button>
            <?php endif; ?>
            <?php if ((checkPermission($data['permissions'], 'AddGift')) ||
                (checkPermission($data['permissions'], 'Checker')) ||
                checkPermission($data['permissions'], 'GoldExpert'))  : ?>
                <button class="btn2 ma-rt" value="2" data-territory="2">
                    <i class="fas fa-ring ma-icon"></i> الذهب والفضة
                </button>
            <?php endif; ?>
        </div>

        <?php if ((checkPermission($data['permissions'], 'AddGift')) ||
            (checkPermission($data['permissions'], 'Checker'))) : ?>
            <div class="ma-op">
                <button class="btn3 ma-rt" value="3" data-territory="3">
                    <i class="fas fa-chair  ma-icon"></i>العينية
                </button>
                <button class="btn4 ma-rt" value="4" data-territory="4">
                    <i class="fas fa-sheep ma-icon"></i>الانعام
                </button>
            </div>
        <?php endif; ?>
    </div>


    <div class="ma-left" style="display: none">
        <form id="addMoney" class="nameFoo so" method="post" name="addMoney">
            <div class="ma-header">
                <div class="ma-back"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة تبرع</span></div>
            <table class="qw" border="0">

                <tr>
                    <td class="rowone">اسم المتبرع</td>
                    <td><input placeholder="اسم المتبرع" type="text" name="dName" id="dName" required></td>
                </tr>

                <tr>
                    <td class="rowone">العملة</td>
                    <td>
                        <select class="ma-forplace" placeholder="العملة" type="text" name="tId" id="moneyTId"
                                required>
                            <option value="">اختر العملة</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td class="rowone">المبلغ</td>
                    <td><input type="text"
                               placeholder="ادخل المبلغ"
                               autocomplete="off"
                               type="text" name="amount"
                               id="amount" required>
                        <div id="output"
                             style="font-weight:bold; margin-bottom: 18px;    color:  #007F60;  font-size: 17px;"></div>
                    </td>


                </tr>

                <tr>
                    <td class="rowone">التخصيص</td>
                    <td>
                        <select class="ma-forplace sId" placeholder="التخصيص" type="text" name="sId" id="sId" required>
                            <option value="">اختر التخصيص</option>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="ma-tu">

                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                    <input id="submit" class="ma-add" type="submit" name="Submit" value="حفظ">
                    <input class="btn5 ma-add two " value="النقد السريع  ">
                <?php endif; ?>
                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                    (checkPermission($data['permissions'], 'EditGift')) ||
                    (checkPermission($data['permissions'], 'Checker'))): ?>

                    <a href="<?php echo URLROOT . "/main/details/1" ?>"><input class="ma-add two" value="جدول النقد">
                    </a>
                <?php endif; ?>
            </div>

            <div>


            </div>
        </form>
    </div>

    <div class="ma-left1" style="display: none">
        <form class="nameFoo1 so" method="post" id="addGold" name="form">
            <div class="ma-header">
                <div class="ma-back1"><i class="fas fa-home firstpage"></i></div>
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
                               id="amountExtra" name="amountExtra" required></td>
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

    <div class="ma-left2" style="display: none">
        <form class="nameFoo2 so" method="post" name="addItem" id="addItem">
            <div class="ma-header">
                <div class="ma-back2"><i class="fas fa-home firstpage"></i></div>
                <span>اضافة تبرع</span></div>
            <table class="sd" width="25%" border="0">
                <tr>
                    <td class="rowone">اسم المتبرع</td>
                    <td><input placeholder="اسم المتبرع" type="text" id="dName" name="dName" required></td>
                </tr>
                <tr>
                    <td class="rowone">التفاصيل</td>
                    <td><input placeholder="التفاصيل" type="text" id="details" name="details" required></td>
                </tr>
                <tr>
                    <td class="rowone">العدد</td>
                    <td><input onkeypress="return isNumberKey(this, event);" placeholder="العدد" type="text" id="amount"
                               name="amount" required>
                    </td>
                </tr>

                <tr>
                    <td class="rowone">وحدة القياس</td>
                    <td><select class="ma-forplace" type="text" id="itemTId" name="tId"
                                required>
                            <option value="">اختر وحدة القياس</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="rowone">التخصيص</td>
                    <td><select class="ma-forplace" placeholder="التخصيص" type="text" id="itemSId" name="sId">
                            <option value="">اختر التخصيص</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="rowone">الجهة المستفيدة</td>
                    <td><input placeholder="الجهة المستفيدة" type="text" id="benefitSide" name="benefitSide"
                        ></td>
                </tr>
                <tr>
                    <td class="rowone">اسم المخول</td>
                    <td>
                        <input placeholder="اسم المخول" type="text" id="authorizedName" name="authorizedName">
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
                    <a href="<?php echo URLROOT . "/main/details/3" ?>"><input class="ma-add two" value="جدول العينية">
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="ma-left3" style="display: none">
        <form class="nameFoo3 so" method="post" id="addAnimal" name="form1">
            <div class="ma-header">
                <div class="ma-back3"><i class="fas fa-home firstpage"></i></div>
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


    <script>
        $( document ).ready( function () {

            let coinsCods = <?php echo $data['coinsCods']; ?>;
            var coinCode = "IQD";
            $( '#moneyTId' ).on( 'change', function () {
                coinCode = coinsCods.filter( item => item.value == this.value )[0].text;
            } );

            let x;
            $( '#amount' ).on( 'input', function (e) {
                if (/\D/g.test( this.value )) this.value = this.value.replace( /\D/g, '' );
                output.innerHTML = tafqeet( removeCommas( this.value ), coinCode )
                if (this.value === "") {
                    return;
                }
                x = removeCommas( this.value );
                this.value = addCommas( x );
            } );

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

            function removeCommas(value) {
                value = value.replace( /\,/g, '' );
                value = parseInt( value, 10 );
                return value;
            }


            $( ".ma-forplace" ).select2();
            <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
            let specifications = <?php echo $data['specifications']; ?>;
            populateSelectFromDs( "sId", specifications );
            populateSelectFromDs( "goldSId", specifications );
            populateSelectFromDs( "itemSId", specifications );


            let types = <?php echo $data['types']; ?>;
            const moneyTypes = types.filter( type => type.dType == 1 )

            const goldTypes = types.filter( type => type.dType == 2 )
            const itemTypes = types.filter( type => type.dType == 3 )
            const animalTypes = types.filter( type => type.dType == 4 )

            populateSelectFromDs( "moneyTId", moneyTypes );
            populateSelectFromDs( "goldTId", goldTypes );
            populateSelectFromDs( "itemTId", itemTypes );
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
                                            output.innerHTML = "";
                                            window.open( '<?php echo URLROOT . "/main/";?>' + printPage + "/" + json, '_blank' );
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

            addGift( 'addMoney', 0, 'print' )
            addGift( 'addGold', 0, 'gold' )
            addGift( 'addItem', 0, 'item' )
            addGift( 'addAnimal', 0, 'animal' )
            <?php endif;?>
        } );
    </script>


</div>

<div class="ma-left4" style="display: none; width: 95%;
    background-color: white;
    border-radius: 25px;
    box-shadow: 0px 0px 6px 1px rgb(100 98 98 / 30%); margin: auto; padding-bottom: 12px; margin-bottom: 60px">
    <form id="form1" class="nameFoo so" method="post" name="form1">
        <div class="nmbjiu2">
            <div class="ma-header" style="
    direction: rtl">
                <div class="ma-back4" style="display: inline-block;"><i class="fas fa-home firstpage"
                                                                        style="    padding: 12px;
   background-color: #EEF0F2;
    border-radius: 34px;
    margin-left: 12px;"></i></div>
                <span style="display: inline-block;">اضافة تبرع</span></div>
        </div>
        <div id="selectlist2" class="dropdown-list territory zaq" name="territory">
            <div id="cashDiv" class="ma-op">
            </div>
        </div>
    </form>
</div>

<script>

    let cash = <?php echo $data['cash'];?>;
    cash.forEach( item => {
        let html = '<a href="<?php echo URLROOT . '/main/cash/';?>' + item.value + '" style="vertical-align: bottom" class="btn1 ma-rt ty">' + item.text + '</a>';
        $( '#cashDiv' ).append( html )
    } )

    $( document ).ready( function () {
        $( ".btn1" ).click( function () {
            $( ".ma-left" ).fadeIn()
            window.location = '<?php echo URLROOT . "/main/1" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back" ).click( function () {
            // $( ".ma-left" ).fadeOut()
            window.location = '<?php echo URLROOT . "/main" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".btn2" ).click( function () {
            // $( ".ma-left1" ).fadeIn()
            <?php if (checkPermission($data['permissions'], 'GoldExpert')): ?>
            window.location = '<?php echo URLROOT . "/main/details/2" ?>';
            <?php else: ?>
            window.location = '<?php echo URLROOT . "/main/2" ?>';
            <?php endif; ?>

        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back1" ).click( function () {
            // $( ".ma-left1" ).fadeOut()
            window.location = '<?php echo URLROOT . "/main" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".btn3" ).click( function () {
            // $( ".ma-left2" ).fadeIn()
            window.location = '<?php echo URLROOT . "/main/3" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back2" ).click( function () {
            $( ".ma-left2" ).fadeOut()
        } );
    } );
    $( document ).ready( function () {
        $( ".btn4" ).click( function () {
            // $( ".ma-left3" ).fadeIn()
            window.location = '<?php echo URLROOT . "/main/4" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back3" ).click( function () {
            $( ".ma-left3" ).fadeOut()
            window.location = '<?php echo URLROOT . "/main" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".btn5" ).click( function () {
            // $( ".ma-left4" ).fadeIn()
            // $( ".MA-vistitem" ).fadeOut()
            window.location = '<?php echo URLROOT . "/main/5" ?>';
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back4" ).click( function () {
            // $( ".ma-left4" ).fadeOut()
            // $( ".MA-vistitem" ).fadeIn()
            window.location = '<?php echo URLROOT . "/main" ?>';
        } );
    } );
</script>

<script>

    $( ".printbtn" ).click( function () {
        //Hide all other elements other than printarea.
        $( ".printbtn" ).hide();
        $( ".dropdown-list" ).hide();
        $( ".ma-span" ).hide();

        $( ".nhg" ).show();
        $( ".ma-header" ).hide();
        $( ".ma-iu" ).hide();
        window.print();
        $( ".ma-iu" ).show();
        $( ".printbtn" ).show();
        $( ".dropdown-list" ).show();
        $( ".ma-span" ).show();

        $( ".nhg" ).hide();
        $( ".ma-header" ).show();
    } );

</script>

<script>
    $( 'ul li.dropdown' ).hover( function () {
        $( this ).find( '.dropdown-menu' ).stop( true, true ).delay( 100 ).fadeIn( 200 );
    }, function () {
        $( this ).find( '.dropdown-menu' ).stop( true, true ).delay( 100 ).fadeOut( 200 );
    } );
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
