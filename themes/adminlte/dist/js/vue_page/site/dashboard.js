
var vm = new Vue({  
    el: "#dashboard_tag",
    data: {
      line_data: [],
      months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    },
});

var loading = $("#loading");
var calendar = $("#calendar");
var pathname = window.location.pathname;

var is_first=0;


$(document).ready(function() {
    $(".knob").knob();
    pieChartPersentage();
    setChartData();
    refreshCalenderData();
});


function setChartData(){
      loading.css("display", "block");
      $.ajax({
          url: pathname+"?r=indukkegiatan/detail_unit&id=0",
          type:"GET",
          dataType :"json",
          success : function(data)
          {
              vm.line_data = [
                  {m: '2018-01', real: data.satu.r1, rpd: data.satu.rpd1},
                  {m: '2018-02', real: data.satu.r2, rpd: data.satu.rpd2},
                  {m: '2018-03', real: data.satu.r3, rpd: data.satu.rpd3},
                  {m: '2018-04', real: data.satu.r4, rpd: data.satu.rpd4},
                  {m: '2018-05', real: data.satu.r5, rpd: data.satu.rpd5},
                  {m: '2018-06', real: data.satu.r6, rpd: data.satu.rpd6},
                  {m: '2018-07', real: data.satu.r7, rpd: data.satu.rpd7},
                  {m: '2018-08', real: data.satu.r8, rpd: data.satu.rpd8},
                  {m: '2018-09', real: data.satu.r9, rpd: data.satu.rpd9},
                  {m: '2018-10', real: data.satu.r10, rpd: data.satu.rpd10},
                  {m: '2018-11', real: data.satu.r11, rpd: data.satu.rpd11},
                  {m: '2018-12', real: data.satu.r12, rpd: data.satu.rpd12},
              ];
  
              morrisLineChart();
              loading.css("display", "none");
          }.bind(this),
          error: function(xhr, status, err) {
              loading.css("display", "none");
              alert("Terjadi kesalahan pada internet, harap refresh halaman");
          }.bind(this)
      });
  }

function morrisLineChart(){
  var line = new Morris.Line({
      element: 'anggaran-chart',
      resize: true,
      data: vm.line_data,
      xkey: 'm',
      ykeys: ['real', 'rpd'],
      ymax: 100,
      ymin: 0,
      labels: ['real', 'rpd'],
      lineColors: ['Green', 'Blue'],
      hideHover: 'auto',
      stacked: true,
      xLabelFormat: function(x) {
          var month = vm.months[x.getMonth()];
          return month;
      },
      gridTextColor: "#fff",
      pointStrokeColors: ["#efefef"],
      gridLineColor: "#efefef",
      lineWidth: 2,
      gridStrokeWidth: 0.4,
      pointSize: 4,
      gridTextSize: 11
  });
}

function pieChartPersentage(){
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
      {
        value: 700,
        color: "#f56954",
        highlight: "#f56954",
        label: "Terlambat"
      },
      {
        value: 500,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "Tepat Waktu"
      },
      {
        value: 400,
        color: "#f39c12",
        highlight: "#f39c12",
        label: "Belum selesai"
      },
    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 1,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: false,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
      //String - A tooltip template
      tooltipTemplate: "<%=value %> kegiatan <%=label%> "
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
}

function refreshCalenderData(){
    loading.css("display", "block");
    $.ajax({
        url: pathname+"?r=kegiatan/listkegiatan&id=1",
        dataType: 'json',
        type: "GET",
        success: function(data) {
            if(is_first==0)
            {
                setCalendar(data.data);
                is_first=1;
            }
            else{
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', data.data);         
                $('#calendar').fullCalendar('rerenderEvents' );
            }

            loading.css("display", "none");
        }.bind(this),
        error: function(xhr, status, err) {
            alert("Terjadi kesalahan pada internet, harap refresh halaman");
        }.bind(this)
    });
}

function setCalendar(list_data){
    calendar.fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      events: list_data
    });
}