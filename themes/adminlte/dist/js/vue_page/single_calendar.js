
var vm = new Vue({  
    el: "#single_calendar_tag",
    data: {},
});

var loading = $("#loading");
var pegawai_id = $("#pegawai_id");
var calendar = $("#calendar");
var pathname = window.location.pathname;

var is_first=0;


$(document).ready(function() {
    refreshCalenderData(pegawai_id.val());
});

pegawai_id.change(function() {
    refreshCalenderData(pegawai_id.val());
});

//param is pegawai_id
function refreshCalenderData($id){
    loading.css("display", "block");
    $.ajax({
        url: pathname+"?r=jadwalTugas/jadwalpegawai&id="+$id,
        dataType: 'json',
        type: "GET",
        success: function(data) {
            if(is_first==0)
            {
                setCalendar(data.data);
                is_first=1;
            }
            else{
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', data.data);         
                $('#calendar').fullCalendar('rerenderEvents' );
            }

            loading.css("display", "none");
        }.bind(this),
        error: function(xhr, status, err) {
            alert("Terjadi kesalahan pada internet, harap refresh halaman");
        }.bind(this)
    });
}

function setCalendar(list_data){
    calendar.fullCalendar({
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