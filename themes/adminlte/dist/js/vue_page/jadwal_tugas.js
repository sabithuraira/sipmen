var vm = new Vue({  
    el: "#jadwal_tag",
    data: {
        // events: [{"title":"Task Force SE2016","start":"2017-11-07","end":"2017-11-10","backgroundColor":"#f56954","borderColor":"#f56954"}]
    },
});

var loading = $("#loading");
var jadwal_success = $("#jadwal-success");
var jadwal_error = $("#jadwal-error");
var pegawai = $("#JadwalTugas_pegawai_id");
var tstart = $("#JadwalTugas_tanggal_mulai");
var tend = $("#JadwalTugas_tanggal_berakhir");

var pathname = window.location.pathname;


$(document).ready(function() {
    // setCalendar();
});

pegawai.change(function() {
    checkCalendar();
});

tstart.change(function() {
    if(isDateConsistent()){
        checkCalendar();
    }
    else{
        alert("'Tanggal mulai' tidak boleh lebih besar dari 'Tanggal berakhir'!");
        tstart.val('');
    }
});

tend.change(function() {
    if(isDateConsistent()){
        checkCalendar();
    }
    else{
        alert("'Tanggal mulai' tidak boleh lebih besar dari 'Tanggal berakhir'!");
        tend.val('');
    }
});

function isDateConsistent(){
    
    if(tstart.val().length && tend.val().length){
        if(tstart.val()>tend.val())
            return false;
    }

    return true;
}


function checkCalendar(){

    if(pegawai.val().length && tstart.val().length && tend.val().length){
        loading.css("display", "block");

        $.ajax({
            url: pathname+"?r=jadwalTugas/checkjadwal&id="+pegawai.val()+"&tstart="+tstart.val()+"&tend="+tend.val(),
            dataType: 'json',
            success: function(data) {
                loading.css("display", "none");
                if(data==0)
                {
                    jadwal_success.css("display", "block");
                    jadwal_error.css("display", "none");
                }
                else{
                    refreshCalenderData(pegawai.val());
                }
            }.bind(this),
            error: function(xhr, status, err) {
                console.log(xhr);
                loading.css("display", "none");
                alert("Terjadi kesalahan pada internet, harap refresh halaman");
                // refreshCalenderData(pegawai.val());
            }.bind(this)
        });

    }
}

//param is pegawai_id
function refreshCalenderData($id){
    $.ajax({
        url: pathname+"?r=jadwalTugas/jadwalpegawai&id="+$id,
        dataType: 'json',
        type: "GET",
        success: function(data) {
            // vm.events = data;
            jadwal_success.css("display", "none");
            jadwal_error.css("display", "block");
            setCalendar(data.data);
        }.bind(this),
        error: function(xhr, status, err) {
            alert("Terjadi kesalahan pada internet, harap refresh halaman");
        }.bind(this)
    });
}

function setCalendar(list_data){
    console.log(list_data);
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      events: list_data
    });
}