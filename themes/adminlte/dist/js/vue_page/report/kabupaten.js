
var vm = new Vue({  
    el: "#kabupaten_tag",
    data: {},
});

var areaChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
var pathname = window.location.pathname;

$(document).ready(function() {
    $(".knob").knob();
    loadChart();
});

function loadChart(){
    
    // loading.css("display", "block");
    var tahun = $('#tahun').val();
    var id = $('#id').val();
    $.ajax({
        url: pathname+"?r=report/api_report_kabupaten&id="+id+"&tahun="+tahun,
        dataType: 'json',
        type: "GET",
        success: function(data) {
            setDataReportSeries(data);

            // loading.css("display", "none");
        }.bind(this),
        error: function(xhr, status, err) {
            alert("Terjadi kesalahan pada internet, harap refresh halaman");
        }.bind(this)
    });
}

function setDataReportSeries(data){

    // var d1=[];
    // <?php 
    //     $tahun=date('Y');
    //     foreach ($dataprogress as $key => $value) { ?>
    //     d1[d1.length]=[gd(<?php echo $tahun; ?>,<?php echo $value['bulan']-1 ?>,1),<?php echo $value['nilai'] ?>];
    // <?php } ?>
    
    var areaChart = new Chart(areaChartCanvas);
    var areaChartData = null;

    var labels = ["January", "February", "March", "April", "May", "June", "July", "Agustus", "September", "Oktober", "November", "Desember"];
    var datas = [0, 0, 0,0, 0, 0, 0, 0, 0, 0,0, 0, 0, 0];

    var dataprogress = data.dataprogress;
    for(var i=0;i<dataprogress.length;++i){
        datas[parseInt(dataprogress[i]['bulan']) - 1] = dataprogress[i]['nilai'];
    }

    areaChartData = {
        labels: labels,
        datasets: [
          {
            label: "Nilai",
            fillColor: "rgba(60,141,188,0.9)",
            strokeColor: "rgba(60,141,188,0.8)",
            pointColor: "#3b8bba",
            pointStrokeColor: "rgba(60,141,188,1)",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(60,141,188,1)",
            data: datas
          }
        ]
    };
    
    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);
}

function gd(year, month, day) {
    return new Date(year, month, day).getTime();
}