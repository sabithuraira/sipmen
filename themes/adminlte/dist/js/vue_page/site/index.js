var vm = new Vue({  
    el: "#index_tag",
    data: {
    },
});

var loading = $("#loading");
var filter_btn = $("#filter-btn");


var prov_id = $("#prov_id");
var kab_id = $("#kab_id");
var kec_id = $("#kec_id");
var desa_id = $("#desa_id");

var pathname = window.location.pathname;

$(document).ready(function() {
});

kab_id.change(function() {
    if(kab_id.val()!=''){
        showAndHideLoading();

        $.ajax({
            url: pathname+"?r=site/get_list_kec&id="+kab_id.val(),
            dataType: 'json',
            type: "GET",
            success: function(data) {
                kec_id.html(data.satu);
                showAndHideLoading();
            }.bind(this),
            error: function(xhr, status, err) {
                showAndHideLoading();
                alert("Terjadi kesalahan pada internet, harap refresh halaman");
            }.bind(this)
        });
    }
    else{
        kec_id.html('<option value="">- Kecamatan -</option>');
        desa_id.html('<option value="">- Desa -</option>');
    }
});

kec_id.change(function() {
    console.log(kec_id.val());
    if(kec_id.val()!='' && kec_id.val()!=0){
        showAndHideLoading();

        $.ajax({
            url: pathname+"?r=site/get_list_desa&id="+kab_id.val()+"&id2="+kec_id.val(),
            dataType: 'json',
            type: "GET",
            success: function(data) {
                desa_id.html(data.satu);
                showAndHideLoading();
            }.bind(this),
            error: function(xhr, status, err) {
                showAndHideLoading();
                alert("Terjadi kesalahan pada internet, harap refresh halaman");
            }.bind(this)
        });
    }
    else{
        desa_id.html('<option value="">- Desa -</option>');
    }
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
