<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/print.css"; ?>">
<link rel="stylesheet" href="<?php echo URLROOT . "/public/css/style.css"; ?>">
<div class="MA-vistitem edit1 print1 ">
    <?php $gift = $data['gift'];; ?>
    <div class="ma-left print ">
        <img src=<?php echo URLROOT . "/public/images/statics/printBg.jpg" ?>>
        <table class="erprint ttttt">
            <tr>
                <td>
                    <label>تبرك جناب الموفق</label>
                    <?php echo $gift->dName; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>بتقديم </label>
                    <?php echo $gift->details; ?>
                </td>
            </tr>
            </tr>
            <tr>
                <td>
                    <label>العدد</label>
                    <?php echo $gift->amount . " " . $gift->gName; ?>
                </td>
            </tr>

            <tr>
                <td>
                    <label>التخصيص</label>
                    <?php echo $gift->sName; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>الجهة المستفيدة</label>
                    <?php echo $gift->benefitSide; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>اسم المخول </label>
                    <?php echo $gift->authorizedName; ?>
                </td>
                `
            </tr>
            <tr>
                <td>
                    <label>التاريخ</label>
                    <?php echo $gift->createdAt; ?>
                </td>
            </tr>

            <tr>
                <td id="amountWriting">
                </td>
            </tr>
            <tr>
                <td class="ma-tu">
                    <button style=" background-color: #2E8B57;     margin-top: 40px;" class="ma-add printbtn">
                        طباعة
                    </button>
                </td>
            </tr>
            <tr class="ma-recive">
                <?php $imgSrc = URLROOT . "/public/images/statics/noimageicon.png";
                if ($data['user']->img != null) {
                    $imgSrc = URLROOT . "/public/images/uploads/users/" . $data['user']->img;
                } ?>

                <td>
                    <img style="position: relative; width: 180px; margin-bottom: 25px"
                         src="<?php echo $imgSrc; ?>">
                    <label class="ma-recive2">المستلم</label>
                    <?php echo $data['user']->name; ?>
                </td>
            </tr>
        </table>
        <table class="erprint dolift">
            <tr>
                <td>
                    <label>العدد</label>
                    <?php echo $gift->vId; ?>
                </td>
            </tr>
        </table>

    </div>
</div>

<script>
    $( document ).ready( function () {
        const path = location.pathname.substring( location.pathname.lastIndexOf( '/' ) + 1 );
        if (path !== 'y') {
            $( ".printbtn" ).addClass( "dontShow" );
        }

        $( '#amountWriting' ).innerText = tafqeet(<?php echo $gift->amount; ?>, 'IQD' );
        console.log( tafqeet(<?php echo $gift->amount; ?>, 'IQD' ) )
        $( ".printbtn" ).click( function () {
            //Hide all other elements other than printarea.

            if (path == 'y') {
                $( ".ma-left img" ).addClass( "printable" );
            }

            $( ".printbtn" ).hide();
            $( ".dropdown-list" ).hide();
            $( ".ma-span" ).hide();
            $( ".nmbjiu" ).hide();

            $( ".svbn" ).hide();
            $( ".nhg" ).show();
            $( ".ma-header" ).hide();
            $( ".ma-iu" ).hide();
            window.print();
            $( ".ma-iu" ).show();
            $( ".nmbjiu" ).show();
            $( ".printbtn" ).show();
            $( ".dropdown-list" ).show();
            $( ".ma-span" ).show();
            $( ".svbn" ).show();
            $( ".nhg" ).hide();
            $( ".ma-header" ).show();
        } );
    } );
</script>
