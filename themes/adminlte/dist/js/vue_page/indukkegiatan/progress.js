
var vm = new Vue({  
    el: "#progress_tag",
    data: {
        line_data: [],
        months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    },
});

var unit_line = $('#unit_line');
var loading = $("#loading");
var unitkerja = $('#unit_kerja');
var idnya=$('#idnya');
var target=$('#target');
var r1=$('#r1');
var r2=$('#r2');
var r3=$('#r3');
var r4=$('#r4');
var r5=$('#r5');
var r6=$('#r6');
var r7=$('#r7');
var r8=$('#r8');
var r9=$('#r9');
var r10=$('#r10');
var r11=$('#r11');
var r12=$('#r12');


var unitkerja_rpd = $('#unit_kerjarpd');
var rpd1=$('#rpd1');
var rpd2=$('#rpd2');
var rpd3=$('#rpd3');
var rpd4=$('#rpd4');
var rpd5=$('#rpd5');
var rpd6=$('#rpd6');
var rpd7=$('#rpd7');
var rpd8=$('#rpd8');
var rpd9=$('#rpd9');
var rpd10=$('#rpd10');
var rpd11=$('#rpd11');
var rpd12=$('#rpd12');
var pathname = window.location.pathname;

$(document).ready(function () {
    setDetailTarget();
    setDetailRpd();
    setChartData();
});

unit_line.change(function(){
    setChartData();
})

unitkerja.change(function(){
    setDetailTarget();
});

unitkerja_rpd.change(function(){
    setDetailRpd();
});

function setChartData(){

    loading.css("display", "block");
    $.ajax({
        url: pathname+"?r=indukkegiatan/detail_kegiatan&id=" + idnya.val()+ "&kab_id=" + unit_line.val(),
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

function setDetailTarget(){
    if(unitkerja.val().length > 0){
        $.ajax({
            url: pathname+"?r=indukkegiatan/detail_kab_kota&id=" + idnya.val() + "&kab_id=" + unitkerja.val(),
            type:"GET",
            dataType :"json",
            success : function(data)
            {
                target.val(data.satu.target);
                r1.val(data.satu.r1);
                r2.val(data.satu.r2);
                r3.val(data.satu.r3);
                r4.val(data.satu.r4);
                r5.val(data.satu.r5);
                r6.val(data.satu.r6);
                r7.val(data.satu.r7);
                r8.val(data.satu.r8);
                r9.val(data.satu.r9);
                r10.val(data.satu.r10);
                r11.val(data.satu.r11);
                r12.val(data.satu.r12);
            }
        });
    }
}

function setDetailRpd(){
    if(unitkerja_rpd.val().length > 0){
        $.ajax({
            url: pathname+"?r=indukkegiatan/detail_kab_kota&id=" + idnya.val() + "&kab_id=" + unitkerja_rpd.val(),
            type:"GET",
            dataType :"json",
            success : function(data)
            {
                rpd1.val(data.satu.rpd1);
                rpd2.val(data.satu.rpd2);
                rpd3.val(data.satu.rpd3);
                rpd4.val(data.satu.rpd4);
                rpd5.val(data.satu.rpd5);
                rpd6.val(data.satu.rpd6);
                rpd7.val(data.satu.rpd7);
                rpd8.val(data.satu.rpd8);
                rpd9.val(data.satu.rpd9);
                rpd10.val(data.satu.rpd10);
                rpd11.val(data.satu.rpd11);
                rpd12.val(data.satu.rpd12);
            }
        });
    }
}

$('#InfroTextRpd').click(function(){
    $.ajax({
        url: pathname+"?r=indukkegiatan/insert_rpd&id=" + idnya.val(),
        type:"post",
        dataType :"json",
        data:{
                "unitkerja":unitkerja_rpd.val(),
                "rpd1":rpd1.val(),
                "rpd2":rpd2.val(),
                "rpd3":rpd3.val(),
                "rpd4":rpd4.val(),
                "rpd5":rpd5.val(),
                "rpd6":rpd6.val(),
                "rpd7":rpd7.val(),
                "rpd8":rpd8.val(),
                "rpd9":rpd9.val(),
                "rpd10":rpd10.val(),
                "rpd11":rpd11.val(),
                "rpd12":rpd12.val()
            },
            success : function(data)
            {
                if(data.satu.length >0)
                {
                    window.location.href=pathname+ "?r=indukkegiatan/progress&id="+data.satu
                }
                else
                {
                    alert('Data gagal disimpan, refresh halaman anda dan ulangi lagi');
                }
            }
        }
    );

});

$('#InfroText').click(function(){

    $.ajax({
        url: pathname+"?r=indukkegiatan/insert_anggaran&id=" + idnya.val(),
        type:"post",
        dataType :"json",
        data:{
                "unitkerja":unitkerja.val(),
                "target":target.val(),
                "r1":r1.val(),
                "r2":r2.val(),
                "r3":r3.val(),
                "r4":r4.val(),
                "r5":r5.val(),
                "r6":r6.val(),
                "r7":r7.val(),
                "r8":r8.val(),
                "r9":r9.val(),
                "r10":r10.val(),
                "r11":r11.val(),
                "r12":r12.val()
            },
            success : function(data)
            {
                if(data.satu.length >0)
                {
                    window.location.href=pathname+ "?r=indukkegiatan/progress&id="+data.satu
                }
                else
                {
                    alert('Data gagal disimpan, refresh halaman anda dan ulangi lagi');
                }
            }
        }
    );
});