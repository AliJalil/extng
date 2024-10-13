<?php require APPROOT . '/views/inc/header.php'; ?>

<script src="<?php echo URLROOT . "/public/vendor/qrcode.min.js" ?>"></script>
<script src="<?php echo URLROOT . "/public/vendor/qrcode2.min.js" ?>"></script>

<table id="detailsTable">

    <tbody>
    </tbody>
</table>

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
                            <tr>
                                <td style="height: 9.5cm;page-break-inside: avoid;" ><div id="${qrcodeContainerId}">
                                ${name} ${row.exNo}
                                </div></td>

                                <td><button class="not-print" id="${buttonId}">تحميل</button></td>
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

                        // Attach click event to download button
                        document.getElementById(buttonId).addEventListener('click', function () {
                            var qrCanvas = document.getElementById(qrcodeContainerId).getElementsByTagName('canvas')[0];
                            var qrImage = qrCanvas.toDataURL("image/png");
                            var link = document.createElement('a');
                            link.href = qrImage;
                            link.download = name + " " + row.exNo + ".png";
                            link.click();
                        });
                    });
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
