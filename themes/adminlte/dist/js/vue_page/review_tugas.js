var d = new Date();

var vm = new Vue({  
    el: "#review_tag",
    data: {
        hello: "Hello world",
        no_surat: '',
        nama_ttd : '',
        nip_ttd: '',
        is_kepala: true,
        is_allow_simpan: true,
        total_day: 30,
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
    if(no_jadwal.val().length==0){
        vm.is_allow_simpan=true;
    }
    else{
        vm.is_allow_simpan=false;
    }

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
        }.bind(this),
        error: function(xhr, status, err) {
            console.log(JSON.stringify(xhr));
        }.bind(this)
    });
}

function saveDataSurat(){
    $.ajax({
        url: pathname+"?r=jadwalTugas/enter_surat&id="+id_jadwal.val(),
        dataType: 'json',
        method: "POST",
        data: { no_surat: vm.no_surat, nama_ttd: vm.nama_ttd , nip_ttd: vm.nip_ttd, is_kepala: vm.is_kepala },
        success: function(data) {
            if(data=="true"){
                alert("Sukses menyimpan data");
                vm.is_allow_simpan=false;
            }
            else{
                alert("Gagal menyimpan data, refresh halaman dan ulangi kembali.");
            }
        }.bind(this),
        error: function(xhr, status, err) {
            console.log(JSON.stringify(xhr));
        }.bind(this)
    });
}

btn_save.click(function(){
    if(vm.is_allow_simpan){
        if(vm.no_surat=='' || vm.no_surat==null){
            alert("Pejabat dan unit kerja yang dipilih tidak valid");
        }
        else{
            saveDataSurat();
        }
    }
});

btn_print.click(function(){
    if(!vm.is_allow_simpan){
        window.location.href = pathname+"?r=jadwalTugas/stugas&id="+id_jadwal.val();
    }
})

ttd.change(function() {
    if(ttd.val()==1)
        vm.is_kepala=true;
    else 
        vm.is_kepala=false;
    

    $.ajax({
        url: pathname+"?r=jadwalTugas/api_pejabat&id="+ttd.val(),
        dataType: 'json',
        success: function(data) {
            if(data.nama==''){
                vm.no_surat="";
                alert("Tidak ada pejabat pada seksi tersebut");
            }
            else{
                vm.no_surat="B-" + data.last_number + "/BPS1671/"+data.seksi+"/"+vm.month+"/"+vm.year;
            }
            vm.nama_ttd=data.nama;
            vm.nip_ttd = data.nip;
        }.bind(this),
        error: function(xhr, status, err) {
            console.log(JSON.stringify(xhr));

            vm.no_surat="";
            vm.nama_ttd="";
            vm.nip_ttd = "";
            alert("Tidak ada pejabat pada seksi tersebut");
        }.bind(this)
    });
});