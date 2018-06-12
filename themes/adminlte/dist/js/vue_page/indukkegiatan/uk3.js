
var vm = new Vue({  
    el: "#grafik_tag",
    data: {
        line_data: [],
        months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    },
});

var idnya = $('#idnya');
var loading = $("#loading");
var pathname = window.location.pathname;

$(document).ready(function () {
    setChartData();
});

function setChartData(){

    loading.css("display", "block");
    $.ajax({
        url: pathname+"?r=indukkegiatan/detail_unit&id=" + idnya.val(),
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
        element: 'line-chart',
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