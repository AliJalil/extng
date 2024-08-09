<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<div class="MA-vistitem2">
    <div class="nmbjiu2"><a href="<?php echo URLROOT . "/main/index"; ?>">
            <button class="ma-backf">
                <i style="font-weight: bold; padding-top: 10px;" class="far fa-arrow-right" aria-hidden="true"></i>
            </button>
        </a><span class="mainm">المستخدمين</span></div>
    <div class="intable">
        <div class="ma-expand2">
            <input class="input-medium search-query ma-ytr2" id="searcher" placeholder="ابحث هنا">
            <div style="color: #D5DAD8;  position: absolute;top: 12px;left: 20px;">
                <i class="fas fa-search" aria-hidden="true"></i></div>
            <div id="addUserBtn" class="Click-here Click-here2 "><i style="font-size: 15px;
    margin-left: 9px;" class="fas fa-plus"></i><label
                        class="wqe1">اضافة مستخدم</label>
            </div>
        </div>


        <div id="changePasswordModel" class="custom-model-main">
            <div class="custom-model-inner">
                <div class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="changePasswordForm">
                            <div class="ma-header">
                                <span>تغيير كلمة السر</span>
                            </div>
                            <table class="qw2" border="0">
                                <input id="uId" type="hidden" name="uId" value=""/>
                                <tr>
                                    <td class="rowone user">كلمة السر</td>
                                    <td>
                                        <input type="text" placeholder="ادخل كلمة السر" name="newPassword" required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rowone user">تأكيد كلمة السر</td>
                                    <td>
                                        <input type="text" placeholder="تأكيد كلمة السر" name="newPasswordConform"
                                               required="">
                                    </td>
                                </tr>
                            </table>
                            <div class="ma-tu password_change">
                                <input class="ma-add" type="submit" name="submit" value="حفظ ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>

        <div id="addUserModel" class="custom-model-main">
            <div class="custom-model-inner">
                <div class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="addUser">
                            <div class="ma-header">
                                <span>اضافة مستخدم</span>
                            </div>
                            <table class="qw2" border="0">
                                <tr>
                                    <td class="rowone user">الاسم الكامل</td>
                                    <td>
                                        <input placeholder="الاسم الكامل" type="text" name="name" id="name" required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rowone user">الاسم المستخدم</td>
                                    <td>
                                        <input placeholder="الاسم المستخدم" type="text" name="userName" id="userName"
                                               required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rowone user">كلمة السر</td>
                                    <td>
                                        <input type="text" placeholder="ادخل كلمة السر" name="password" required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rowone user">تأكيد كلمة السر</td>
                                    <td><input type="text" placeholder="تأكيد كلمة السر" name="confirm_password"
                                               required="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rowone user" style="padding-top: 17px;">الصلاحيات</td>
                                    <td>
                                        <div id="permissions"></div>
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


        <div id="changePermissionsModel" class="custom-model-main">
            <div class="custom-model-inner">
                <div class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="changePermissionsForm">
                            <div class="ma-header">
                                <span>تعديل الصلاحيات</span>
                            </div>
                            <input type="hidden" name="uId" value=""/>
                            <table class="qw2" border="0">
                                <tr>
                                    <td class="rowone user" style="padding-top: 17px;">الصلاحيات</td>
                                    <td>
                                        <div id="userPermissions"></div>
                                    </td>
                                </tr>

                            </table>
                            <div class="ma-tu changePermissions">
                                <input id="send_data2" class="ma-add" type="submit" name="Submit" value="حفظ ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>


        <div class="table-responsive">
            <table id="usersTable" class=" table table-striped table-bordered">
                <thead>
                <tr class="mjk">
                    <th class="name_th">الاسم</th>
                    <th class="user_name_th">الاسم المستخدم</th>
                    <th>صورة المنتسب</th>
                    <th class="state_th">الحالة</th>
                    <th>الاجراءات</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $( document ).ready( function () {
        var emTable = $( '#usersTable' ).DataTable( {
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,
            'ajax': {
                'url': '<?php echo URLROOT . "/users/index" ?>',
                "type": 'POST',
            },
            columns: [
                {data: 'name'},
                {data: 'userName'},
                {
                    data: 'userId',
                    render: function (data, type, row) {
                        var imgSrc = "<?php echo URLROOT . "/public/images/statics/noimageicon.png" ?>";
                        if (row['img']) {
                            imgSrc = '<?php echo URLROOT . "/public/images/uploads/users/" ?>' + row['img'] + '';
                        }
                        return '<div class="maiser"> <a target="_blank" href="' + imgSrc + '">  <img id="img' + row['userId'] + '" class="xy Zimg" src="' + imgSrc + '"> </a>'
                            <?php if (checkPermission($data['permissions'], 'EditUser')):?>
                            + '                        ' +
                            '                        <div style="display: inline-block;">' +
                            '                            <button style="transition: all 0.3s; background: #EDEDED;color: green;" data-toggle="tooltip"' +
                            '                                    title="تغيير الصورة"' +
                            '                                    class="btn btn-outline-primary btn-sm btn-success"' +
                            '                                    onclick=replaceImage(' + row["userId"] + ',"","<?php echo URLROOT . "/users/replaceImage"; ?>","#img' + row["userId"] + '","img")>' +
                            '                                <i class="fas fa-image"></i>' +
                            '                            </button>' +
                            '                        </div></div>'
                        <?php endif; ?>
                    }

                },

                {data: 'isActive'},

                {
                    data: 'userId',
                    render: function (data, type, row) {
                        return '<div style="margin-top: 5px">' +

                            '                             <?php if (checkPermission($data['permissions'], 'DeleteUser')):?><button style="transition: all 0.3s ;color: red;" id="delete-item-' + data + '" data-toggle="tooltip" title="حذف السجل الحالي"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-trash"></i><span style="margin-right: 12px;">حذف</span>' +
                            '                            </button>' +
                            '                       ' +
                            '                          <?php endif; ?> <?php if (checkPermission($data['permissions'], 'EditUser')):?><button style="transition: all 0.3s;color: #519944;" id="change-permissions-' + data + '" data-toggle="tooltip" title="تغيير الصلاحيات"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-lock"></i><span style="margin-right: 12px;">تعديل الصلاحيات</span>' +
                            '                            </button>' +
                            '                       ' +
                            '                            <button style="transition: all 0.3s;color: #4c4e56;" id="change-password-' + data + '" data-toggle="tooltip" title="تعديل كلمة المرور"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-key"></i><span style="margin-right: 12px;"> تغيير كلمة المرور</span>' +
                            '                            </button>' +
                            '                       ' +
                            '                            <a href="<?php echo URLROOT . "/detections/details/0/0/"; ?>' + data + '" style="transition: all 0.3s;color: #4c4e56;"  data-toggle="tooltip" title="كشوفات المنتسب"' +
                            '                                    class="btn  btn-sm">' +
                            '                                <i class="fas fa-eye"></i><span style="margin-right: 12px;"> كشوفات المنتسب</span>' +
                            '                            </a> <?php endif; ?>' +
                            '                       ' +
                            '                    </div>';
                    }
                },
            ],
            columnDefs: [

                {
                    targets: "name_th",
                    render: function (data, type, row) {
                        return '<a class="name" id="name" data-name="name"  data-type="text" data-pk=' + row['userId'] + '>' + data + '</a>'
                    }
                },
                {
                    targets: "user_name_th",
                    render: function (data, type, row) {
                        return '<a class="userName" id="userName" data-name="userName"  data-type="text" data-pk=' + row['userId'] + '>' + data + '</a>'
                    }
                },

                {
                    targets: "state_th",

                    render: function (data, type, row) {
                        return '<a class="state" id="state" data-name="isActive"  data-type="select" data-pk=' + row['userId'] + '>' + activeStates.filter( state => state.value == data )[0].text + '</a>'
                    }
                },
            ]
        } )
        emTable.on( 'draw', function () {

            <?php if (checkPermission($data['permissions'], 'EditUser')):?>
            selectFromSource( ".state", "<?php echo URLROOT . "/users/edit";?>", activeStates );
            make_editable_x( '.name', "<?php echo URLROOT . "/users/edit";?>" );
            make_editable_x( '.userName', "<?php echo URLROOT . "/users/edit";?>" );
            <?php endif;?>
        } )
        $( document ).on( 'click', '[id^="change-password-"]', function () {
            var id = this.id.split( '-' ).pop();
            $( "#changePasswordModel" ).addClass( 'model-open' );
            $( 'input[name="uId"]' ).val( id );

        } );

        $( document ).on( 'click', '[id^="change-permissions-"]', function () {
            var id = this.id.split( '-' ).pop();
            $( "#changePermissionsModel" ).addClass( 'model-open' );
            $( 'input[name="uId"]' ).val( id );
            bindDataChangePermissions( id )

        } );

        $( document ).on( 'click', '[id^="delete-item-"]', function () {
            var button = $( this );
            var id = this.id.split( '-' ).pop();
            deleteFunction( "حذف عنصر", "هل انت متأكد من حذف العنصر المحدد؟", "<?php echo URLROOT . "/users/edit";?>", id, emTable, button );

        } );

        let permissionsToSet = <?php echo $data['permissionsToSet']; ?>;
        bindData( permissionsToSet )

        function bindData(permissions) {
            $( "#permissions" ).empty();
            let permissionHtml = "";
            var i = 0;
            permissions.forEach( item => {
                    i = i + 1;
                    permissionHtml += '<label class="containerRadio">' + item.pNameAr + '' +
                        '<input type="checkbox" name="radio" value="' + item.pId + '"> ' +
                        '<span class="checkmark"></span>' +
                        '</label> ';
                    if (i % 4 == 0) {
                        permissionHtml = permissionHtml + '<br>';
                    }
                }
            )
            $( "#permissions" ).html( permissionHtml )
            // $( "#userPermissions" ).html( permissionHtml )
        }


        function bindDataChangePermissions(userId = 1) {
            $( "#userPermissions" ).empty();
            let permissionHtml = "";
            var i = 0;
            permissionsToSet.forEach( item => {
                    i = i + 1;
                    permissionHtml += '<label class="containerRadio">' + item.pNameAr + '' +
                        '<input id="' + item.pId + '" type="checkbox" name="radio" value="' + item.pId + '"> ' +
                        '<span class="checkmark"></span>' +
                        '</label> ';
                    if (i % 4 == 0) {
                        permissionHtml = permissionHtml + '<br>';
                    }
                }
            )

            $( "#userPermissions" ).html( permissionHtml );
            var formData = new FormData();
            formData.append( 'userId', userId );
            $.ajax( {
                url: '<?php echo URLROOT . "/users/getPermissionsByUserId/";?>',
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    const givenPermissions = $.parseJSON( response );
                    givenPermissions.forEach( (item) => {
                        $( '#userPermissions input[id=' + item.pId + ']' ).prop( "checked", true );
                    } );
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert( "Status: " + textStatus );
                    alert( "خظأ: " + errorThrown );
                }
            } );


        }
    } );

</script>

<script>

    addUser( 'addUser' );
    changeUserPassword( 'changePasswordForm' );
    changeUserPermissions( 'changePermissionsForm' );

    function addUser(formId) {
        $( "#" + formId ).submit( function (event) {
                const permissionList = [];
                $.each( $( "input[type=checkbox]:checked" ), function () {
                    permissionList.push( parseInt( $( this ).val() ) )
                } );
                const form = $( "#" + formId );
                var params = form.serializeArray();
                var formData = new FormData();
                formData.append( "permissions", JSON.stringify( permissionList ) );
                $( params ).each( function (index, element) {
                    formData.append( element.name, element.value );
                } );
                sendAjaxRequest( '<?php echo URLROOT . "/users/add";?>', formData, formId );
                return false;
            }
        );
    }

    function changeUserPermissions(formId) {
        $( "#" + formId ).submit( function (event) {
                const permissionList = [];
                $.each( $( "input[type=checkbox]:checked" ), function () {
                    permissionList.push( parseInt( $( this ).val() ) )
                } );

                const form = $( "#" + formId );
                const params = form.serializeArray();
                const formData = new FormData();
                formData.append( "permissions", JSON.stringify( permissionList ) );
                $( params ).each( function (index, element) {
                    formData.append( element.name, element.value );
                } );
                sendAjaxRequest( '<?php echo URLROOT . "/users/changePermission";?>', formData, formId );
                // $( "#changePermissionsModel" ).removeClass( 'model-open' );
                return false;
            }
        );
    }

    function changeUserPassword(formId) {
        $( "#" + formId ).submit( function (event) {
                const form = $( "#" + formId );
                const params = form.serializeArray();
                const formData = new FormData();
                $( params ).each( function (index, element) {
                    formData.append( element.name, element.value );
                } );
                sendAjaxRequest( '<?php echo URLROOT . "/users/changeUserPassword";?>', formData, formId );
                // $( "#changePasswordModel" ).removeClass( 'model-open' );
                return false;
            }
        );
    }

    function sendAjaxRequest(url, formData, formId) {

        $.ajax( {
            url: url,
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const json = $.parseJSON( response );
                if (json == "200") {
                    $( "#addUserModel" ).removeClass( 'model-open' );
                    $( "#changePermissionsModel" ).removeClass( 'model-open' );
                    $( "#changePasswordModel" ).removeClass( 'model-open' );
                    showAlert( "success", "تمت العملية بنجاح" )
                    $( "#" + formId ).trigger( "reset" );
                    $( "#submit" ).attr( "disabled", false );
                    $( "#submit" ).val( "حفظ" );
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert( "Status: " + textStatus );
                alert( "خظأ: " + errorThrown );
            }
        } );
    }
</script>


<script>
    $( "#addUserBtn" ).on( 'click', function () {
        $( "#addUserModel" ).addClass( 'model-open' );
    } );
    $( ".close-btn, .bg-overlay" ).click( function () {
        $( "#addUserModel" ).removeClass( 'model-open' );
        $( "#changePermissionsModel" ).removeClass( 'model-open' );
        $( "#changePasswordModel" ).removeClass( 'model-open' );
    } );
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
