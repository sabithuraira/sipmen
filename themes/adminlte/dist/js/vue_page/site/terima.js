var vm = new Vue({  
    el: "#terima_tag",
    data: {
        jumlah_ruta:0,
        tambahan_ruta:0,
        asal_ruta:0,
    },
});

var pathname = window.location.pathname;

var hid_jumlah_ruta = $("#hid_jumlah_ruta");
var btn_tambah = $("#btn_tambah");

$(document).ready(function() {
    if(hid_jumlah_ruta.val()!=0){
        vm.jumlah_ruta = parseInt(hid_jumlah_ruta.val());
        vm.asal_ruta = vm.jumlah_ruta;
    }
});

btn_tambah.click(function(){
    vm.jumlah_ruta +=1;
    vm.tambahan_ruta +=1;
});

