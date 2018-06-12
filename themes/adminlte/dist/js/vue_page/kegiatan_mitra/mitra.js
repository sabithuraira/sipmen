var vm = new Vue({  
    el: "#mitra_tag",
    data: {
        nks:"",
        bs:"",
        wils: [],
        kmp_id: 0,
        cur_mitra_id: 0,
        cur_mitra_name: "",
        cur_wils: []
    },
    methods: {
        addWil: function () {
            if(this.nks == "" || this.bs == ""){
                alert("Lengkapi data NKS dan Blok Sensus");
            }
            else{
                this.wils.push({
                    nks: this.nks,
                    bs: this.bs
                });

                this.nks = "";
                this.bs = "";
            }
        },
        addWilDb: function () {
            if(this.nks == "" || this.bs == ""){
                alert("Lengkapi data NKS dan Blok Sensus");
            }
            else{
                var idnya       =$('#idnya').val();

                showAndHideLoading();
                $.ajax({
                    url: pathname+"?r=kegiatan_mitra/add_single_wilayah&id=" + idnya,
                    type:"post",
                    dataType :"json",
                    data:{
                        "nks": this.nks,
                        "bs": this.bs,
                        "kmp_id":this.kmp_id,
                        "mitra_id": this.cur_mitra_id
                    },
                    success : function(data)
                    {
                        if(data.satu.length >0)
                        {
                            alert('Data berhasil disimpan');
                            refreshWilayah();
                            //window.location.href=pathname+ "?r=kegiatan_mitra/mitra&id="+data.satu
                        }
                        else
                        {
                            alert('Data gagal disimpan, refresh halaman anda dan ulangi lagi');
                        }
                        showAndHideLoading();
                    }
                });

                this.nks = "";
                this.bs = "";
            }
        },
        removeWil: function (wil) {
          this.wils.splice(this.wils.indexOf(wil), 1)
        },
        removeWilDb: function (id) {
            showAndHideLoading();
            $.ajax({
                url: pathname+"?r=kegiatan_mitra/delete_wilayah&id=" + id,
                type:"get",
                dataType :"json",
                success : function(data)
                {
                    showAndHideLoading();
                    refreshWilayah();
                }
            });
            
        }
      },
});

var mitra_id    =$('#mitra_id');
var mitra_from  =$('#mitra_from');
var idkab  =$('#idkab');
var pathname = window.location.pathname;

$(document).ready(function () {
    
});

function refreshWilayah(){
    showAndHideLoading();
    $.ajax({
        url: pathname+"?r=kegiatan_mitra/get_list_wilayah&id=" + vm.kmp_id,
        type:"get",
        dataType :"json",
        success : function(data)
        {
            vm.cur_wils = data.satu;
            showAndHideLoading();
        }
    });
}

$(".update_wilayah").click(function () {
    vm.kmp_id = $(this).data('id');
    vm.cur_mitra_name = $(this).data('nama');
    vm.cur_mitra_id = $(this).data('mitra_id');
    refreshWilayah();
});

$(".delete-petugas").click(function () {

    if (confirm('Menghapus data petugas akan menghapus semua data nilai dan wilayah yang terkait dengan petugas ini. Anda yakin ingin melanjutkan?')) {
        var idnya = $(this).data('id');
        
        $.ajax({
            url: pathname+"?r=kegiatan_mitra/delete_petugas&id=" + idnya,
            type:"get",
            dataType :"json",
            success : function(data)
            {
                window.location.href=pathname+ "?r=kegiatan_mitra/mitra&id="+data.satu
            }
        });
    } else {
    }
});

mitra_from.change(function(){
    $.ajax({
        url: pathname+"?r=kegiatan_mitra/get_list_mitra&id=" + idkab.val(),
        type:"post",
        dataType :"json",
        data:{
            "mitra_from": mitra_from.val(),
        },
        success : function(data)
        {
            mitra_id.html(data.satu);
        }
    });
});

$('#btn-update-finish').click(function(){
    var idnya       =$('#idnya').val();

    window.location.href=pathname+ "?r=kegiatan_mitra/mitra&id="+idnya
});

$('#InfroTextSubmit').click(function(){
    var idnya       =$('#idnya').val();
    var mitra_status=$('#mitra_status').val();

    // console.log(JSON.stringify(mitra_nks));

    $.ajax({
        url: pathname+"?r=kegiatan_mitra/insert_petugas&id=" + idnya,
        type:"post",
        dataType :"json",
        data:{
            "mitra_id":mitra_id.val(),
            "mitra_from": mitra_from.val(),
            "mitra_status":mitra_status,
            "mitra_wils": vm.wils
        },
        success : function(data)
        {
            if(data.satu.length >0)
            {
                window.location.href=pathname+ "?r=kegiatan_mitra/mitra&id="+data.satu
            }
            else
            {
                alert('Data gagal disimpan, refresh halaman anda dan ulangi lagi');
            }
        }
    });
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