var vm = new Vue({  
    el: "#terima_tag",
    data: {
        jumlah_ruta:0,
        tambahan_ruta:0,
        asal_ruta:0,
        is_error: false,
    },
});

var pathname = window.location.pathname;

const hid_jumlah_ruta = $("#hid_jumlah_ruta");
const btn_tambah = $("#btn_tambah");

$(document).ready(function() {
    if(hid_jumlah_ruta.val()!=0){
        vm.jumlah_ruta = parseInt(hid_jumlah_ruta.val());
        vm.asal_ruta = vm.jumlah_ruta;
    }
});

$("#terima-form").submit(function(e){
    var semua_nomor = [];
    for(i=0;i<vm.jumlah_ruta;++i){
        if($("#noruta"+i).val()==''){
            vm.is_error = true;
            return false;
        }
        else{
            semua_nomor.push(parseInt($("#noruta"+i).val()));
        }
    }

    for(i=1;i<=vm.jumlah_ruta;++i){
        if(semua_nomor.indexOf(i)==-1)
        {
            console.log(semua_nomor);
            console.log(i);
            vm.is_error = true;
            return false;
        }
    }
    
    vm.is_error = false;
    return true;
});

btn_tambah.click(function(){
    vm.jumlah_ruta +=1;
    vm.tambahan_ruta +=1;
});

