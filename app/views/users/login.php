<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo SITENAME ?> </title>
    <script type="text/javascript"
            src="<?php echo URLROOT . "/public/js/DataTables/jQuery-1.12.4/jquery-1.12.4.min.js" ?>"></script>
    <script type="text/javascript" src="<?php echo URLROOT . "/public/js/sweetalert2.min.js" ?>"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/sweetalert2.min.css" ?>" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/28e600a1b8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/style.css" ?>" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/vendor/bootstrap@5.0.2/css/bootstrap.min.css" ?>"
          crossorigin="anonymous">
    <script type="text/javascript"
            src="<?php echo URLROOT . "/public/vendor/bootstrap@5.0.2/js/bootstrap.bundle.min.js" ?>"></script>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo URLROOT . "/public/images/statics/favicon.ico"; ?>">

    <style>
        body {
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>

<div class="MA-backimage"
     style="background-image: url(<?php echo URLROOT . "/public/images/statics/login-bg111.jpg" ?>);">
    <div class="ma-opas">
        <form method="post" id="logintype" enctype="multipart/form-data">
            <div class="ret"><i class="fas fa-fire-extinguisher kl" ></i>  <h4 class="ruy er">كشف المطافئ</h4>
            </div>
            <h2 class="ruy">مرحبا بك </h2>
            <div class="xcwe">
                <label class="uio">الاسم المستخدم</label>
                <i class="fa fa-user icon"></i>
                <input placeholder="الاسم المستخدم" id="username" class="row2" type="text" name="un"
                       required=</i>
            </div>
            <div class="xcwe fg">

                <label class="uio">كلمة السر</label>
                <i class="fas fa-eye" onclick="myFunction()"></i>
                <input id="myInput" placeholder="كلمة المرور " class="row2" type="password" name="pw" required>
            </div>
            <input class="row2 hj" type="submit"
                   name="save" value="تسجيل الدخول">

        </form>

    </div>
</div>


<script>

    $( document ).ready( function () {


        $( "#logintype" ).submit( function (event) {

                var formData = new FormData( this );

                const username = $( "#username" ).val();
                const password = $( "#myInput" ).val();
                formData.append( 'userName', username );
                formData.append( 'password', password );
                $.ajax( {
                    url: '<?php echo URLROOT . "/users/login";?>',
                    method: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var json = $.parseJSON( response );
                        if (json == "1") {
                            window.location = "<?php echo URLROOT . "/main/index";?>";
                        } else if (json == "10") {
                            $( "#userName_err" ).html( "الرجاء ادخال الاسم مستخدم" );
                        } else if (json == "11") {
                            $( "#password_err" ).html( "الرجاء ادخال كلمة المرور" );
                        } else if (json == "12") {
                            $( "#password_err" ).html( "خطأ في الاسم المستخدم او كلمة المرور" );
                            const Toast = Swal.mixin( {
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000
                            } );

                            Toast.fire( {
                                type: 'error',
                                title: 'خطأ في الاسم المستخدم او كلمة المرور'
                            } )
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
    } );
</script>


<div class="mjaio"><img src="<?php echo URLROOT . "/public/images/statics/iahs-logo%20(2).png" ?>"></div>
</body>
</html>
<script>
    function myFunction() {
        var x = document.getElementById( "myInput" );
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

