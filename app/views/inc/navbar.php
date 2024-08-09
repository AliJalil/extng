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
                        <button class="ma-manga" id="addToHomeScreenButton"> Shortcut</button>
                        <a class="ma-manga" href="<?php echo URLROOT . "/users/logout"; ?>">تسجيل الخروج</a>
                    </div>
                </ul>
        </li>
    </ul>
    <div class='ma-uyt2'>
        <div class="maprintdiv">
            <span class="maspanprint hide-on-phone" style="display: none;color: black;font-size: 14px;font-weight: 500; ">العتبة العلوية المقدسة</span>
            <span class="maspanprint2 hide-on-phone" style="color: black;font-size: 14px;font-weight: 500; margin-left: 10px">شعبة الدفاع المدني</span>
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
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/1"; ?>">اضافة معلومات
                                        مطفأة</a>
                                <?php endif; ?>
                                <?php if ((checkPermission($data['permissions'], 'ViewTables')) ||
                                    (checkPermission($data['permissions'], 'EditGift'))): ?>
                                    <a class="ma-manga" href="<?php echo URLROOT . "/main/details/1"; ?>"> معلومات
                                        المطافئ</a>
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
                                    <a href="<?php echo URLROOT . "/detections" ?>" class="ma-manga">عرض الكشوفات</a>
                                    <a href="<?php echo URLROOT . "/detections/detect" ?>" class="ma-manga">اضافة منتسب
                                        لكشف</a>
                                    <a href="<?php echo URLROOT . "/detections/add" ?>" class="ma-manga">اضافة كشف</a>
                                </div>
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

        <div class="imgeprint" style="display: inline-block;">
            <img style="height: 35px;width: 35px; margin-left: 12px;"
                 src="<?php echo URLROOT . "/public/images/statics/imn_logo.png" ?>">
        </div>

        <a href="<?php echo URLROOT . "/main/index" ?>">
            <div class="wer2" style="display: inline-block;"><i
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
