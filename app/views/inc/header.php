<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo SITENAME ?> </title>
    <script type="text/javascript" src="<?php echo URLROOT . "/public/js/moment.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo URLROOT . "/public/js/fontawesome.js" ?>"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/bootstrap@5.0.2/css/bootstrap.min.css" ?>"
          crossorigin="anonymous">
    <script type="text/javascript"
            src="<?php echo URLROOT . "/public/vendor/bootstrap@5.0.2/js/bootstrap.bundle.min.js" ?>"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/fontawesome/css/all.css" ?>"
          crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto Nastaliq Urdu' rel='stylesheet'>
    <script type="text/javascript"
            src="<?php echo URLROOT . "/public/js/DataTables/jQuery-1.12.4/jquery-1.12.4.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo URLROOT . "/public/js/main.js" ?>"></script>
    <script type="text/javascript" src="<?php echo URLROOT . "/public/js/tafqeet.js" ?>"></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo URLROOT . "/public/images/statics/favicon.ico"; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/style.css" ?>" crossorigin="anonymous">
    <script type="text/javascript" src="<?php echo URLROOT . "/public/vendor/select2.min.js" ?>"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/select2.css" ?>" crossorigin="anonymous">

    <script type="text/javascript" src="<?php echo URLROOT . "/public/js/sweetalert2.min.js" ?>"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/sweetalert2.min.css" ?>" crossorigin="anonymous">
</head>

<body>
<div class="ma-background forprint">
    <div class="ma-lefttrcavk"></div>

    <ul class="ma-iu not-print">


        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <div class="qw-ty">
                    <i class="fas fa-cog"></i>

                </div>
                <ul class="dropdown-menu">
                    <i class="ma-users fas fa-user"></i>
                    <div
                            style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                            class='ma-uyt'>
                        <div id="changeInfo">
                            تعديل المعلومات
                            <div style="display: inline-block;"><i style="margin-left: 5px;  display: inline-block;"
                                                                   class="fas fa-edit"></i></div>
                        </div>
                        <?php if (checkPermission($data['permissions'], 'AddUser') ||
                            checkPermission($data['permissions'], 'EditUser') ||
                            checkPermission($data['permissions'], 'DeleteUser')) : ?>
                            <a class="ma-manga" href="<?php echo URLROOT . "/users/"; ?>"> إدارة الحسابات</a>
                        <?php endif; ?>
                        <?php if (checkPermission($data['permissions'], 'ManagePage')): ?>
                            <a class="ma-manga" href="<?php echo URLROOT . "/manages/"; ?>"> إدارة </a>
                        <?php endif; ?>

                        <a class="ma-manga" href="<?php echo URLROOT . "/users/logout"; ?>">تسجيل الخروج</a>
                    </div>
                </ul>

        </li>
    </ul>
    <div class='ma-uyt2'>
        <div class="maprintdiv">
            <span class="maspanprint" style="display: none;color: black;font-size: 14px;font-weight: 500; ">العتبة العلوية المقدسة</span>
            <span class="maspanprint2" style="color: #234D40;font-size: 14px;font-weight: 500; margin-left: 10px">شعبة الدفاع المدني</span>


            <ul class="ma-iu not-print">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="qw-ty">
                            المطافئ
                        </div>
                        <ul class="dropdown-menu">
                            <div
                                    style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                                    class='ma-uyt'>
                                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/1"; ?>">اضافة معلومات مطفئة</a>
                                <?php endif; ?>
                                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                                    (checkPermission($data['permissions'], 'EditGift')) ||
                                    (checkPermission($data['permissions'], 'Checker'))): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/details/1"; ?>"> معلومات المطافئ</a>
                                <?php endif; ?>
                            </div>
                        </ul>
                </li>
            </ul>

            <ul class="ma-iu not-print">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="qw-ty">
                            الذهب
                        </div>
                        <ul class="dropdown-menu">
                            <div
                                    style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                                    class='ma-uyt'>
                                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/2"; ?>">اضافة الذهب والفضة</a>
                                <?php endif; ?>
                                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                                    (checkPermission($data['permissions'], 'EditGift')) ||
                                    (checkPermission($data['permissions'], 'GoldExpert')) ||
                                    (checkPermission($data['permissions'], 'Checker'))): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/details/2"; ?>"> جدول الذهب
                                        والفضة</a>
                                <?php endif; ?>
                            </div>
                        </ul>
                </li>
            </ul>

            <ul class="ma-iu not-print">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="qw-ty">
                            العينية
                        </div>
                        <ul class="dropdown-menu">

                            <div
                                    style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                                    class='ma-uyt'>
                                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/3"; ?>">اضافة المواد
                                        العينية</a>
                                <?php endif; ?>
                                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                                    (checkPermission($data['permissions'], 'EditGift')) ||
                                    (checkPermission($data['permissions'], 'Checker'))): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/details/3"; ?>"> جدول المواد
                                        العينية</a>
                                <?php endif; ?>
                            </div>
                        </ul>


                </li>
            </ul>

            <ul class="ma-iu not-print">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="qw-ty">
                            الأنعام
                        </div>
                        <ul class="dropdown-menu">

                            <div
                                    style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                                    class='ma-uyt'>
                                <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/4"; ?>">اضافة الأنعام</a>
                                <?php endif; ?>
                                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                                    (checkPermission($data['permissions'], 'EditGift')) ||
                                    (checkPermission($data['permissions'], 'Checker'))): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/details/4"; ?>"> جدول
                                        الأنعام</a>
                                <?php endif; ?>
                            </div>
                        </ul>


                </li>
            </ul>


            <?php if (checkPermission($data['permissions'], 'StatementView')) : ?>
                <ul class="ma-iu not-print">

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="qw-ty">
                                الكشوفات
                            </div>
                            <ul class="dropdown-menu">

                                <div
                                        style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                                        class='ma-uyt'>
                                    <a href="<?php echo URLROOT . "/statistics" ?>" class="ma-manga">عرض الكشوفات</a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/0/0" ?>" class="ma-manga">كشف
                                        العملات العام</a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/0/1/999" ?>" class="ma-manga">كشف
                                        العملات العربية والاجنبية</a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/1/1/2" ?>" class="ma-manga">كشف
                                        تخصيص الدولار </a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/1/1/1" ?>" class="ma-manga">كشف
                                        تخصيص الدينار </a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/1/1" ?>" class="ma-manga">كشف
                                        تخصيص العملات العربية والاجنبية</a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/0/2" ?>" class="ma-manga">كشف
                                        الذهب والفضة</a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/1/2" ?>" class="ma-manga">كشف
                                        تخصيص الذهب </a>
                                    <a href="<?php echo URLROOT . "/statistics/summary/1/4" ?>" class="ma-manga">كشف
                                        الانعام</a>

                                </div>

                            </ul>


                    </li>
                </ul>

            <?php endif; ?>

            <?php if (checkPermission($data['permissions'], 'StatementView')) : ?>
                <ul class="ma-iu not-print ma-deleted">

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <div class="qw-ty">
                                الإحصائيات
                            </div>
                            <ul class="dropdown-menu">

                                <div
                                        style="height: 33px; background: #fff; text-align: center; line-height: 33px;  border-radius: 5px;"
                                        class='ma-uyt'>
                                    <a href="<?php echo URLROOT . "/charts" ?>" class="ma-manga">عرض الاحصائيات</a>
                                </div>
                            </ul>


                    </li>
                </ul>

            <?php endif; ?>

            <?php if (checkPermission($data['permissions'], 'StatementView')) : ?>
                <a style="font-size: 0px !important;" href="<?php echo URLROOT . "/charts" ?>" class="">س &nbsp;
                    &nbsp; </a>
            <?php endif; ?>


        </div>

        <div class="imgeprint" style="display: inline-block;">
            <img style="height: 35px;width: 35px; margin-left: 12px;"
                 src="<?php echo URLROOT . "/public/images/statics/imn_logo.png" ?>">
        </div>

        <a href="<?php echo URLROOT . "/main/index" ?>">
            <div class="wer2" style="display: inline-block;"><i
                        style="color:#fff; padding: 11px 10px; margin-left: 5px; background-color: #018360; border-radius:50px "
                        class="fas fa-home-lg-alt"></i></div>
        </a>
    </div>
    <div class='ma-uyt'><?php echo $_SESSION['Uname'] ?>
        <div style="display: inline-block;"><i id="changeInfo" style="margin-left: 5px;  display: inline-block;"
            <i class="fas fa-user"></i>
        </div>
    </div>
    <!--        <div class="ma-deteprint" style="display: none">-->
    <!--            <span  style="color: black;font-size: 14px;font-weight: 500; ">كشف العملات العامة</span>-->
    <!--        </div>-->
</div>

<div id="changeInfoModel" class="custom-model-main">
    <div class="custom-model-inner">
        <div class="close-btn">×</div>
        <div class="custom-model-wrap">
            <div class="pop-up-content-wrap">
                <form class="nameFoo2 so" method="post" id="currentUserChangePasswordForm">
                    <div class="ma-header">
                        <span>تعديل المعلومات</span>
                    </div>
                    <table class="qw2" border="0">
                        <tr>
                            <td class="rowone user">الاسم المستخدم الحالي</td>
                            <td>
                                <input placeholder="الاسم المستخدم الحالي" type="text" name="userName" id="userName"
                                       required="">
                            </td>
                        </tr>
                        <tr>
                            <td class="rowone user">كلمة السر الحالية</td>
                            <td>
                                <input type="text" placeholder="ادخل كلمة السر الحالية" name="password" required="">
                            </td>
                        </tr>
                        <tr>
                            <td class="rowone user">كلمة السر الجديدة</td>
                            <td>
                                <input type="text" placeholder="ادخل كلمة السر الجديدة" name="newPassword" required="">
                            </td>
                        </tr>
                        <tr>
                            <td class="rowone user">تأكيد كلمة السر الجديدة</td>
                            <td><input type="text" placeholder="تأكيد كلمة السر الجديدة" name="newPasswordConform"
                                       required="">
                            </td>
                        </tr>
                    </table>
                    <div class="ma-tu adduser1">
                        <input id="send_data2" class="ma-add" type="submit" name="Submit" value="حفظ ">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-overlay"></div>
</div>


<script>

    $( window ).unload( function () {
        alert( "Bye now!" );
    } );


    $( "#changeInfo" ).on( 'click', function () {
        $( "#changeInfoModel" ).addClass( 'model-open' );
    } );

    $( ".close-btn, .bg-overlay" ).click( function () {
        $( "#changeInfoModel" ).removeClass( 'model-open' );
    } );

    $( 'ul li.dropdown' ).hover( function () {
        $( this ).find( '.dropdown-menu' ).stop( true, true ).delay( 100 ).fadeIn( 200 );
    }, function () {
        $( this ).find( '.dropdown-menu' ).stop( true, true ).delay( 100 ).fadeOut( 200 );
    } );
</script>

<script>


    changePassword( 'currentUserChangePasswordForm' );

    function changePassword(formId) {
        $( "#" + formId ).submit( function (event) {
                const form = $( "#" + formId );
                var params = form.serializeArray();
                var formData = new FormData();

                formData.append( 'uId', <?php echo trim($_SESSION['extUserId'])?>);
                $( params ).each( function (index, element) {
                    formData.append( element.name, element.value );
                } );
                $.ajax( {
                    url: '<?php echo URLROOT . "/users/changePassword";?>',
                    method: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        const json = $.parseJSON( response );
                        if (json == "200") {
                            showAlert( "success", "تم تعديل المعلومات بنجاح" );
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
</script>
