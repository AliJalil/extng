<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<div class="MA-vistitem2 jk">
    <div class="nmbjiu2"><a href="<?php echo URLROOT . "/main/index";?>">
            <button class="ma-backf"><i style="font-weight: bold;
    padding-top: 10px;" class="far fa-arrow-right" aria-hidden="true"></i>
            </button>

        </a><span class="mainm">المستخدمين</span></div>
    <div class="ma-dir not-print">

        <div class="custom-model-main">
            <div class="custom-model-inner">
                <div class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="addUser">

                            <table>
                                <td class="rowone">اسم التبرع</td>
                                <td>
                                    <select class="ma-forplace" placeholder="العملة" type="text" required="">
                                        <option value="">اختر التبرع</option>
                                        <option value="1">نقد</option>
                                        <option value="2">ذهب</option>
                                        <option value="3">العينية</option>
                                        <option value="4">انعام</option>
                                    </select>
                                </td>
                                <tr>
                                    <td class="rowone"> اضافة التخصيص</td>
                                    <td>
                                        <input class="ma-forplace sId" placeholder="التخصيص" type="text" required="">
                                    </td>
                                </tr>
                            </table>





                            <div class="ma-tu adduser1">
                                <input id="send_data2" class="ma-add" type="submit" name="Submit" value="اضافة ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>




    </div>
    <div class="intable">
        <div class="ma-expand2">

            <input class="input-medium search-query ma-ytr2" id="searcher" placeholder="ابحث هنا">
            <div style="color: #D5DAD8;  position: absolute;
    top: 12px;

    left: 20px;"><i class="fas fa-search" aria-hidden="true"></i></div>
            <div class="Click-here Click-here2 "><i style="font-size: 15px;
    margin-left: 9px;" class="fas fa-plus"></i><label
                        class="wqe1">اضافة التخصيص</label>
            </div>
        </div>


        <div class="table-responsive">
            <table id="usersTable" class=" table table-striped table-bordered">
                <thead>
                <tr class="mjk" pcolor=#CCCCCC>
                    <th>الاسم</th>
                    <th>الاسم المستخدم</th>
                    <th>التخصيص</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="MA-vistitem2 jk">

    <div class="ma-dir maopi not-print">
        <div class="custom-model-main">
            <div class="custom-model-inner">
                <div class="close-btn">×</div>
                <div class="custom-model-wrap">
                    <div class="pop-up-content-wrap">
                        <form class="nameFoo2 so" method="post" id="addUser">

                            <table>
                                <td class="rowone">اسم التبرع</td>
                                <td>
                                    <select class="ma-forplace" placeholder="العملة" type="text" required="">
                                        <option value="">اختر التبرع</option>
                                        <option value="1">نقد</option>
                                        <option value="2">ذهب</option>
                                        <option value="3">العينية</option>
                                        <option value="4">انعام</option>
                                    </select>
                                </td>
                                <tr>
                                    <td class="rowone"> اضافة نوع</td>
                                    <td>
                                        <input class="ma-forplace sId" placeholder="التخصيص" type="text" required="">
                                    </td>
                                </tr>
                            </table>
                            <div class="ma-tu adduser1">
                                <input id="send_data2" class="ma-add" type="submit" name="Submit" value="اضافة ">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>
    </div>
    <div class="intable">
        <div class="ma-expand2">

            <input class="input-medium search-query ma-ytr2" id="searcher" placeholder="ابحث هنا">
            <div style="color: #D5DAD8;  position: absolute;
    top: 12px;

    left: 20px;"><i class="fas fa-search" aria-hidden="true"></i></div>
            <div class="Click-here Click-here2 "><i style="font-size: 15px;
    margin-left: 9px;" class="fas fa-plus"></i><label
                        class="wqe1">اضافة نوع</label>

            </div>


        </div>

        <div class="table-responsive">
            <table id="usersTable" class=" table table-striped table-bordered">
                <thead>
                <tr class="mjk" pcolor=#CCCCCC>
                    <th>الاسم</th>
                    <th>الاسم المستخدم</th>
                    <th>التخصيص</th>

                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<script>$( document ).ready( function () {
        $( '#employee_data' ).DataTable();
    } );

</script>

<script>
    $( document ).ready( function () {

        // DataTables initialisation
        var table = $( '#employee_data' ).DataTable();

        // Refilter the table
        $( '#min, #max' ).on( 'change', function () {
            table.draw();
        } );
    } );
</script>

<script>
    $( ".Click-here" ).on( 'click', function () {
        $( ".custom-model-main" ).addClass( 'model-open' );
    } );
    $( ".close-btn, .bg-overlay" ).click( function () {
        $( ".custom-model-main" ).removeClass( 'model-open' );
    } );
</script>
