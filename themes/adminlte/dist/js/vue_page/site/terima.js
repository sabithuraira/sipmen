var vm = new Vue({  
    el: "#terima_tag",
    data: {
        jumlah_ruta:0
    },
});

var pathname = window.location.pathname;

var hid_jumlah_ruta = $("#hid_jumlah_ruta");

$(document).ready(function() {
    if(hid_jumlah_ruta.val()!=0){
        vm.jumlah_ruta = parseInt(hid_jumlah_ruta.val());
    }
});