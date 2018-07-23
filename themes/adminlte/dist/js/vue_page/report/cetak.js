var vm = new Vue({  
    el: "#cetak_tag",
    data: {
        wils : [],
        selected_wil : [],
        selected_index: []
    },
    watch: {
        selected_index: function (val) {
            this.selected_wil = [];
            for(let i=0; i< val.length ;++i){
                this.selected_wil.push(this.wils[val[i]]);
            }
        }
    }
});

var loading = $("#loading");
var filter_btn = $("#filter-btn");

var prov_id = $("#prov_id");
var kab_id = $("#kab_id");
var kec_id = $("#kec_id");
var desa_id = $("#desa_id");

var pathname = window.location.pathname;

$(document).ready(function() {
    showAndHideLoading();
    $.ajax({
        url: pathname+"?r=report/get_list_cetak",
        dataType: 'json',
        type: "POST",
        data:{
            "kab_id": kab_id.val(),
            "kec_id": kec_id.val(),
            "desa_id": desa_id.val(),
        },
        success: function(data) {
            vm.wils = data.hasil;
            showAndHideLoading();
        }.bind(this),
        error: function(xhr, status, err) {
            showAndHideLoading();
            alert("Terjadi kesalahan pada internet, harap refresh halaman");
        }.bind(this)
    });
});

$(".checkbox-toggle").click(function () {
    var clicks = $(this).data('clicks');
    if (clicks) {
      //Uncheck all checkboxes
      $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
      vm.selected_index = [];

    } else {
      //Check all checkboxes
      $(".mailbox-messages input[type='checkbox']").iCheck("check");

        vm.selected_index = [];
        for(i=0;i<vm.wils.length;++i){
            vm.selected_index.push(i);
        }
    }
    $(this).data("clicks", !clicks);
});

function showAndHideLoading(){
    if($('.loading').css("display")=='none'){
        $(".loading").css("display","block");
        $(".loading_message").html("Loading...");
    }
    else{
        $(".loading").css("display","none");
    }
}


var tableToExcel = (function() {   
    
    var uri = "data:application/vnd.ms-excel;base64,",
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http:\/\/www.w3.org\/TR\/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}<\/x:Name><x:WorksheetOptions><x:DisplayGridlines\/><\/x:WorksheetOptions><\/x:ExcelWorksheet><\/x:ExcelWorksheets><\/x:ExcelWorkbook><\/xml><![endif]--><\/head><body><table>{table}<\/table><\/body><\/html>',
        base64 = function(s) {
            return window.btoa(unescape(encodeURIComponent(s)));
        },
        format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
            });
        };

    return function() {
        table = 'initabel';
        fileName = 'bps-file.xls';
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {
            worksheet: fileName || 'Worksheet', 
            table: table.innerHTML
        }

        $("<a id='dlink'  style='display:none;'></a>").appendTo("body");
            document.getElementById("dlink").href = uri + base64(format(template, ctx))
            document.getElementById("dlink").download = fileName;
            document.getElementById("dlink").click();
    }

})();  