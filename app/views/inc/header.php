<!DOCTYPE html>
<html lang="ar">
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
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/style.css" ?>">
    <script type="text/javascript" src="<?php echo URLROOT . '/public/vendor/select2.min.js' ?>"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . '/public/vendor/select2.css' ?>">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    @media print {
        .not-print {
            display: none;
        !important;
        }
    }
</style>
<body>
<div class="not-print ma-background forprint">
    <div class="not-print ma-lefttrcavk"></div>

    <ul class="ma-iu not-print">


        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <div class="qw-ty">
                    <i class="fas fa-cog"></i>
                </div>
                <ul class="dropdown-menu">
                    <li>
                        <a id="changeInfo" class="ma-manga">
                            تعديل معلومات الحساب
                        </a>
                    </li>
                    <?php if (checkPermission($data['permissions'], 'AddUser') ||
                        checkPermission($data['permissions'], 'EditUser') ||
                        checkPermission($data['permissions'], 'DeleteUser')) : ?>
                        <li><a class="ma-manga" href="<?php echo URLROOT . "/users/"; ?>"> إدارة الحسابات</a></li>
                    <?php endif; ?>
                    <?php if (checkPermission($data['permissions'], 'ManagePage')): ?>
                        <li><a class="ma-manga" href="<?php echo URLROOT . "/manages/"; ?>"> إدارة </a></li>
                    <?php endif; ?>
                    <li><a class="ma-manga" href="<?php echo URLROOT . "/users/logout"; ?>">تسجيل الخروج</a></li>
                </ul>
        </li>
    </ul>
    <div class='ma-uyt2'>
        <div class="maprintdiv">
            <span class="maspanprint" style="display: none;color: black;font-size: 14px;font-weight: 500; ">العتبة العلوية المقدسة</span>
            <span class="maspanprint2" style="color: black;font-size: 14px;font-weight: 500; margin-left: 10px">شعبة الدفاع المدني</span>
            <ul class="ma-iu not-print">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="qw-ty">
                            المطافئ
                        </div>
                        <ul class="dropdown-menu">

                            <?php if (checkPermission($data['permissions'], 'AddGift')): ?>
                                <li><a class="ma-manga" href="<?php echo URLROOT . "/main/1"; ?>">اضافة معلومات
                                        مطفأة</a></li>
                            <?php endif; ?>
                            <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                                (checkPermission($data['permissions'], 'EditGift')) ||
                                (checkPermission($data['permissions'], 'StatementViewUser'))
                            ): ?>
                                <li><a class="ma-manga" href="<?php echo URLROOT . "/main/details/1"; ?>"> معلومات
                                        المطافئ</a></li>
                            <?php endif; ?>

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

                                <li><a href="<?php echo URLROOT . "/detections" ?>" class="ma-manga">عرض الكشوفات</a>
                                </li>
                                <li><a href="<?php echo URLROOT . "/detections/detect" ?>" class="ma-manga">اضافة منتسب
                                        لكشف</a></li>
                                <li><a href="<?php echo URLROOT . "/detections/add" ?>" class="ma-manga">اضافة كشف</a>
                                </li>


                            </ul>
                    </li>
                </ul>

            <?php endif; ?>

            <ul class="ma-iu not-print">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="qw-ty">
                            <a href="<?php echo URLROOT . "/main/qr" ?>" class="ma-manga">الكشف بقراءة الرمز</a>
                        </div>
                </li>
            </ul>

            <?php if (checkPermission($data['permissions'], 'StatementView')) : ?>
                <a style="font-size: 0px !important;" href="<?php echo URLROOT . "/charts" ?>" class="">س &nbsp;
                    &nbsp; </a>
            <?php endif; ?>
        </div>

        <div class="header-img">
            <img style="height: 35px;width: 35px; margin-left: 12px;"
                 src="<?php echo URLROOT . "/public/images/statics/imn_logo.png" ?>">
        </div>

        <a href="<?php echo URLROOT . "/main/index" ?>">
            <div class="header-img"><i
                        style="color:#fff; padding: 11px 10px; margin-left: 5px; background-color: #E93C3C; border-radius:50px "
                        class="fas fa-home-lg-alt"></i></div>
        </a>
    </div>
    <div class='ma-uyt'><?php echo $_SESSION['Uname'] ?>
        <div style="display: inline-block;"><i id="changeInfo" style="margin-left: 5px;  display: inline-block;"
            <i class="fas fa-user"></i>
        </div>
    </div>
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
    // Listen for the beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (event) => {
        // Prevent the default behavior of the event to suppress the browser's default prompt
        event.preventDefault();

        // Store the event object so that it can be used later
        const deferredPrompt = event;

        // Show your custom "Add to Home Screen" UI, e.g., by displaying a button or a banner
        const addToHomeScreenButton = document.getElementById('addToHomeScreenButton');
        addToHomeScreenButton.style.display = 'block';

        // Add a click event listener to the "Add to Home Screen" button
        addToHomeScreenButton.addEventListener('click', () => {
            // Hide the "Add to Home Screen" UI
            addToHomeScreenButton.style.display = 'none';

            // Show the browser's installation prompt
            deferredPrompt.prompt();

            // Wait for the user's response to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the installation prompt');
                    // Handle the installation confirmation, e.g., by tracking installation event or showing a success message
                } else {
                    console.log('User dismissed the installation prompt');
                    // Handle the installation dismissal, e.g., by tracking dismissal event or showing a cancellation message
                }

                // Reset the deferredPrompt so that it can be used again in the future
                deferredPrompt = null;
            });
        });
    });
</script>

<script>

    $(window).unload(function () {
        alert("Bye now!");
    });


    $("#changeInfo").on('click', function () {
        $("#changeInfoModel").addClass('model-open');
    });

    $(".close-btn, .bg-overlay").click(function () {
        $("#changeInfoModel").removeClass('model-open');
    });

    $('ul li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
    });
</script>

<script>


    changePassword('currentUserChangePasswordForm');

    function changePassword(formId) {
        $("#" + formId).submit(function (event) {
                const form = $("#" + formId);
                var params = form.serializeArray();
                var formData = new FormData();

                formData.append('uId', <?php echo trim($_SESSION['extUserId'])?>);
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });
                $.ajax({
                    url: '<?php echo URLROOT . "/users/changePassword";?>',
                    method: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        const json = $.parseJSON(response);
                        if (json == "200") {
                            showAlert("success", "تم تعديل المعلومات بنجاح");
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("خظأ: " + errorThrown);
                    }
                });
                return false;
            }
        );
    }
</script>
