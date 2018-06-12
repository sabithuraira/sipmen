var d = new Date();

var vm = new Vue({  
    el: "#review_tag",
    data: {
        no_surat: '',
        nama_ttd : '',
        nip_ttd: '',
        is_kepala: true,
        month: d.getMonth() + 1,
        year: d.getFullYear(),
    },
});

var ttd = $("#ttd");
var btn_save = $("#btn-save");
var btn_print = $("#btn-print");
var id_jadwal = $("#id-jadwal");
var no_jadwal = $("#no-jadwal");
var loading = $("#loading");

var pathname = window.location.pathname;

$(document).ready(function() {
    loadDefaultData();
});

function loadDefaultData(){
    $.ajax({
        url: pathname+"?r=jadwalTugas/api_view&id="+id_jadwal.val(),
        dataType: 'json',
        success: function(data) {
            vm.no_surat= data.no_surat;
            vm.nip_ttd= data.nip_ttd;
            vm.nama_ttd = data.nama_ttd;
            vm.is_kepala = data.is_kepala;
            setInterval(function(){  
                window.print();
            },1500);          
        }.bind(this),
        error: function(xhr, status, err) {
            console.log(JSON.stringify(xhr));
        }.bind(this)
    });
}