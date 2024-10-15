<?php require APPROOT . '/views/inc/header.php'; ?>

<script src="<?php echo URLROOT . "/public/vendor/qrcode.min.js" ?>"></script>
<script src="<?php echo URLROOT . "/public/vendor/qrcode2.min.js" ?>"></script>

<table id="detailsTable">

    <tbody>
    </tbody>
</table>

<style>



    table{
        Width:100%!important;
    }
    .SH_bg_img{
        width:100%;
    }

    .SH_label_cont{
        width: 24%;
        margin:0px;
        padding: 0px;
        display: inline-block;
    }
    .SH_label{
        Wdith:100%;
        position: relative;
    }

    

    .SH_qr_code{
        Width: 29%;
        position: absolute;
        right: 9.75%;
        bottom: 10.7%;
      }

      .SH_qr_code img{
        Width:100%;
      }

      .SH_exNum{
        display: block;
        position: absolute;
        right: 9%;
        Width: 30%;
        top: 57.4%;
        font-size: 120%;
      }

    .SH_name{
        display:block;
        position: absolute;
        left: 4%;
        Width: 45%;
        bottom: 3%;
        background-color: #fff;
        font-size: 56%;
        padding: 2%;
        border-radius: 4px;
      }

      @media print {
        .SH_label_cont{
            page-break-inside: avoid;
        }

        body, html {
            margin: 0;
            padding: 0;
            margin-top:0.5cm;
        }

        @page {
            margin: 0;
        }

      }




</style>

<script>
    $(document).ready(function () {
        // AJAX call to fetch data
        $.ajax({
            url: '<?php echo URLROOT . "/main/details2" ?>',
            type: 'POST',
            success: function (response) {
                console.log("Response received:", response);
                response = JSON.parse(response);
                var data = response.aaData;  // Extract the 'aaData' array
                console.log("Data:", data);  // Log the data for debugging
                var tableBody = $('#detailsTable tbody');
                tableBody.empty();  // Clear the table body

                if (data && data.length > 0) {
                    data.forEach(function (row) {
                        // Use exName if available, otherwise fall back to 'Unknown'
                        var name = row.exName || "Unknown";

                        // Create a unique QR code container and button ID
                        var qrcodeContainerId = 'qrcode-' + row.exId;
                        var buttonId = 'btn-' + row.exId;

                        // Append row with QR code and download button
                        var newRow = `
                            <tr class="SH_label_cont">
                                <td class="SH_label" >
                                    <img class="SH_bg_img" src="<?php echo URLROOT . '/public/images/statics/qr-bg.jpg'?>"/>
                                    <label class="SH_exNum">${row.exNo}</label>
                                    <div class="SH_qr_code" id="${qrcodeContainerId}">
                                    </div>
                                    <label class="SH_name">${name}</label>
                                </td>

                                
                            </tr>
                        `;
                        tableBody.append(newRow);

                        // Generate QR code
                        var qrcode = new QRCode(document.getElementById(qrcodeContainerId), {
                            text: row.exId,
                            width: 250,
                            height: 250,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });

                        
                    });
                    window.print();
                } else {
                    console.error("No data found in response.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error in AJAX request:", error);
            }
        });
    });
</script>
