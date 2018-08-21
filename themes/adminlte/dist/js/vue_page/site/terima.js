var vm = new Vue({  
    el: "#terima_tag",
    data: {
        jumlah_ruta:0,
        no_batch:'',
        kab: '',
        tambahan_ruta:0,
        asal_ruta:0,
        is_error: false,
    },
});

var pathname = window.location.pathname;
var body = $("body");

const hid_jumlah_ruta = $("#hid_jumlah_ruta");
const btn_tambah = $("#btn_tambah");

$(document).ready(function() {
    vm.no_batch = $("#no_batch").val();
    vm.kab = $("#idKab").val();
    if(hid_jumlah_ruta.val()!=0){
        vm.jumlah_ruta = parseInt(hid_jumlah_ruta.val());
        vm.asal_ruta = vm.jumlah_ruta;
    }
});

$("#btn-generate").click(function(e){
    vm.jumlah_ruta = parseInt($("#jumlah_ruta").val());
    $("#btn-generate").attr('disabled', true);
    $("#jumlah_ruta").attr('disabled', true);
});


//delete existing ruta
$(".delete-ruta").click(function(e){
    console.log("masuk");
    var no_ruta = parseInt($(this).data('nomor'));
    body.addClass("loading");
    if(no_ruta!=0){
        console.log(no_ruta);
        if(no_ruta==vm.asal_ruta){
            $.ajax({
                url: pathname+"?r=sipmen/delete_ruta&batch="+vm.no_batch+"&kab="+vm.kab+"&noruta="+no_ruta,
                dataType: 'json',
                type: "GET",
                success: function(data) {
                    body.removeClass("loading");
                    // window.location.href = pathname+"?r=sipmen/terima&id="+id_jadwal.val(); 
                    window.location.reload(false); 
                }.bind(this),
                error: function(xhr, status, err) {
                    body.removeClass("loading"); 
                    alert("Terjadi kesalahan pada internet, harap refresh halaman");
                }.bind(this)
            });
        }
        else{
            body.removeClass("loading"); 
            alert("Hanya mengizinkan penghapusan ruta pada no urut terakhir");
        }
    }
    else{
        body.removeClass("loading"); 
        alert("Hanya mengizinkan penghapusan ruta pada no urut terakhir");
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