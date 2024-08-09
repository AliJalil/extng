<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<script src="<?php echo URLROOT . "/public/vendor/qrcode.min.js" ?>"></script>
<script src="<?php echo URLROOT . "/public/vendor/qrcode2.min.js" ?>"></script>

<style>
    /* Hide ordering indicators */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        visibility: hidden;
    }
</style>
<table id="detailsTable">
    <thead>
    <tr class="mjk" pcolor=#CCCCCC>
        <th class="exQR_th"></th>
    </tr>
    </thead>
    <!--End of Header-->
</table>


<script>
    $(document).ready(function () {
        var emTable = $('#detailsTable').DataTable({
            "processing": true,
            'serverSide': true,
            'serverMethod': 'post',
            'autoWidth': false,
            dom: '',
            pageLength: -1,
            ordering: false,
            'ajax': {
                'url': '<?php echo URLROOT . "/main/details" ?>',
                "type": 'POST',
                "data": function (data) {
                },
            },
            columns: [

                {
                    data: 'exId',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            var qrcodeContainerId = 'qrcode-' + data;
                            var buttonId = 'btn-' + data;
                            setTimeout(function () {
                                var qrcode = new QRCode(document.getElementById(qrcodeContainerId), {
                                    text: data,
                                    width: 250,  // Adjust the size as needed
                                    height: 250,
                                    colorDark: "#000000",
                                    colorLight: "#ffffff",
                                    correctLevel: QRCode.CorrectLevel.H
                                });

                                // Add click event listener to the button
                                document.getElementById(buttonId).addEventListener('click', function () {
                                    var qrCanvas = document.getElementById(qrcodeContainerId).getElementsByTagName('canvas')[0];
                                    var qrImage = qrCanvas.toDataURL("image/png");
                                    var link = document.createElement('a');
                                    link.href = qrImage;
                                    link.download = row.exName + " " + row.exNo + ".png";
                                    link.click();
                                });
                            }, 0);
                            return '<div id="' + qrcodeContainerId + '"></div>' +

                                '<div>' + row.exName + " " + row.exNo + '</div>'+
                                '<button class="not-print" id="' + buttonId + '">تحميل</button><br><br>'
                                ;
                        }
                        return data;
                    }
                }
            ],
            buttons: [],
        })
    });
</script>


