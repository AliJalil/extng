<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/dteditableScript.php'; ?>
<script src="<?php echo URLROOT . "/public/js/dtJs.js"; ?>"></script>
<script src="<?php echo URLROOT . "/public/js/loader.js" ?>"></script>
<script type="text/javascript">

    var moneyCounts = [<?php echo $data["moneyCounts"]?>];
    var goldCounts = [<?php echo $data["goldCounts"]?>];
    var specifications = [<?php echo $data["specifications"]?>];
    google.charts.load('current',{packages:['corechart']});


    // google.charts.setOnLoadCallback(drawChart1);
//     function drawChart1() {
// // Set Data
//         var data = google.visualization.arrayToDataTable([
//             ['Price', 'Size'],
//             moneyCounts
//         ]);
// // Set Options
//         var options = {
//             title: 'House Prices vs Size',
//             hAxis: {title: 'Square Meters'},
//             vAxis: {title: 'Price in Millions'},
//             legend: 'none'
//         };
// // Draw Chart
//         var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
//         chart.draw(data, options);
//     }





    google.setOnLoadCallback( function () {
        drawChart( specifications, 'chart_specification_div', "التخصيص" )
    } )
    google.setOnLoadCallback( function () {
        drawChart( moneyCounts, 'chart_div', "العملة" )
    } )
    //
    google.setOnLoadCallback( function () {
        drawChart( goldCounts, 'gold_div', "الذهب والفضة" )
    } )

    //
    function drawChart(dataToShow, divId = 'chart_div', rowsTitle = "") {

        var data = new google.visualization.DataTable();
        data.addColumn( 'string', 'Year' );
        data.addColumn( 'number', rowsTitle );
        data.addRows(
            dataToShow
        );

        var options = {
            width: 900,
            height: 400,
            title: 'Tasks Completed',
            pieHole: 0.5,
            // colors: ['#008000', '#ffbf00', '#FF0000','#4E6282'],
            pieSliceText: 'value',
            sliceVisibilityThreshold :1/10000000000,
            fontSize: 20,
            legend: {
                position: 'labeled'
            },
        };

        var chart = new google.visualization.PieChart( document.getElementById( divId ) );
        chart.draw(data, options);
        // chart.draw( data, {
        //     colors: ['#42c698', 'yellow', 'blue'], 'is3D': true,
        //     hAxis: {title: rowsTitle, titleTextStyle: {color: 'red'}}
        // } );
    }


</script>


<div class="MA-vistitem2">

    <div class="nmbjiu"><a href="<?php echo URLROOT . "/index/"; ?>">
            <button class="ma-back"><i class="fas fa-home"></i></button>
        </a></div>

    <div class="ma-span"> الواردات النقدية حسب التخصيص</div>
    <div id="chart_specification_div"></div>
</div>
<div class="MA-vistitem2">
    <div class="ma-span">الواردات النقدية حسب العملة</div>
    <div id="chart_div"></div>
</div>

<div class="MA-vistitem2">
    <div class="ma-span">واردات الذهب والفضة</div>
    <div id="gold_div"></div>
</div>


