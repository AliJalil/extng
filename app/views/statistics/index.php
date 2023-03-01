<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="MA-vistitem sa">

    <div class="nmbjiu"><a href="<?php echo URLROOT . "/index/"; ?>">
            <button class="ma-back"><i class="fas fa-home"></i></button>
        </a></div>

    <div class="ma-span">اختر نوع الكشف</div>
    <?php if (checkPermission($data['permissions'], 'StatementView')) : ?>
        <div id="selectlist" class="dropdown-list territory zaq" name="territory">
            <div class="ma-op yipo">

                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/0/0"; ?>"
                   class="btn1 ma-rt ty">كشف العملات العام
                </a>
                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/0/1/999"; ?>"
                   class="btn1 ma-rt ty">كشف العملات العربية والاجنبية
                </a>

                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/1/1/2"; ?>"
                   class="btn1 ma-rt ty">كشف الدولار حسب التخصيص
                </a>

                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/1/1/1"; ?>"
                   class="btn1 ma-rt ty">كشف الدينار حسب التخصيص
                </a>

                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/1/1"; ?>"
                   class="btn1 ma-rt ty">كشف العملات العربية والاجنبية
                    حسب التخصيص
                </a>
                <br>
                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/0/2"; ?>"
                   class="btn1 ma-rt ty"></i>كشف الذهب والفضة
                </a>

                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/1/2"; ?>"
                   class="btn1 ma-rt ty"></i>كشف الذهب حسب التخصيص
                </a>
                <br>
                <a style="vertical-align: bottom" href="<?php echo URLROOT . "/statistics/summary/1/4"; ?>"
                   class="btn1 ma-rt ty"></i>كشف الانعام
                </a>

            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    $( document ).ready( function () {
        $( ".btn1" ).click( function () {
            //this is change select value 1
            $( '#dynamicChange' ).val( '1' ).trigger( 'change' );
        } );
        $( ".btn2" ).click( function () {
            //
            //this is change select value 1
            $( '#dynamicChange2' ).val( '2' ).trigger( 'change' );
        } );
        $( ".btn3" ).click( function () {
            //
            //this is change select value 1
            $( '#dynamicChange3' ).val( '3' ).trigger( 'change' );
        } );
        $( ".btn4" ).click( function () {
            //
            //this is change select value 1
            $( '#dynamicChange4' ).val( '4' ).trigger( 'change' );
        } );
    } );
</script>

<script>
    $( document ).ready( function () {
        $( ".btn1" ).click( function () {
            $( ".ma-left" ).fadeIn()
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back" ).click( function () {
            $( ".ma-left" ).fadeOut()
        } );
    } );
    $( document ).ready( function () {
        $( ".btn2" ).click( function () {
            $( ".ma-left1" ).fadeIn()
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back1" ).click( function () {
            $( ".ma-left1" ).fadeOut()
        } );
    } );


    $( document ).ready( function () {
        $( ".btn3" ).click( function () {
            $( ".ma-left2" ).fadeIn()
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back2" ).click( function () {
            $( ".ma-left2" ).fadeOut()
        } );
    } );

    $( document ).ready( function () {
        $( ".btn4" ).click( function () {
            $( ".ma-left3" ).fadeIn()
        } );
    } );
    $( document ).ready( function () {
        $( ".ma-back3" ).click( function () {
            $( ".ma-left3" ).fadeOut()
        } );
    } );
</script>

<script>

    $( ".printbtn" ).click( function () {
        //Hide all other elements other than printarea.
        $( ".printbtn" ).hide();
        $( ".dropdown-list" ).hide();
        $( ".ma-span" ).hide();
        $( ".svbn" ).hide();
        $( ".nhg" ).show();
        $( ".ma-header" ).hide();
        $( ".ma-iu" ).hide();
        window.print();
        $( ".ma-iu" ).show();
        $( ".printbtn" ).show();
        $( ".dropdown-list" ).show();
        $( ".ma-span" ).show();
        $( ".svbn" ).show();
        $( ".nhg" ).hide();
        $( ".ma-header" ).show();
    } );

</script>

