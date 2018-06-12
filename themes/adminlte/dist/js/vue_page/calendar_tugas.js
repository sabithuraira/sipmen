var d = new Date();

var vm = new Vue({  
    el: "#calendar_tag",
    data: {
        hello: "Hello world",
        list_name: [],
        data : [],
        total_day: 30,
        month: d.getMonth() + 1,
    },
});

// {id: "198908232012111001", name: "Sabit Huraira" }, 
// {id: "196507311989011001", name: "PM Hamonangan"}

var month_id = $("#monthid");
var thead = $("#tablehead");
var tbody = $("#tablebody");
var loading = $("#loading");

var pathname = window.location.pathname;

$(document).ready(function() {
    month_id.val(vm.month);

    grabListName();
});

month_id.change(function() {
    vm.month = month_id.val();
    grabListName();
});

function generateTable(){
    generateHeader();
    generateBody();
    setJadwal();
}

function grabListName(){
    thead.children().remove();
    tbody.children().remove();

    loading.css("display", "block");
    $.ajax({
        url: pathname+"?r=jadwalTugas/listpegawai",
        dataType: 'json',
        success: function(data) {
            vm.list_name=data.data;
            console.log(JSON.stringify(vm.list_name))
            grabDatas();
        }.bind(this),
        error: function(xhr, status, err) {
            console.log(xhr);
        }.bind(this)
    });
}

function grabDatas()
{
    $.ajax({
        url: pathname+"?r=jadwalTugas/listkegiatan&id="+vm.month,
        dataType: 'json',
        success: function(data) {
            vm.data=data.data;
            generateTable();

            loading.css("display", "none");
        }.bind(this),
        error: function(xhr, status, err) {
            console.log(xhr);
        }.bind(this)
    });
}

function setJadwal(){
    for(var i=0;i<vm.data.length;++i){
        setCellJadwal(vm.data[i]);
    }
}

function setCellJadwal(data){
    if(data.start_date==data.end_date){
        $("#id"+data.nip+" td").eq(data.start_date+1).addClass("red");
    }
    else{
        var total_jadwal = data.end_date - data.start_date + 1;
        var start_cell= $("#id"+data.nip+" td").eq(parseInt(data.start_date)+1);
        
        start_cell.attr('colspan',total_jadwal);
        start_cell.addClass("red");
        start_cell.append(data.judul);
        
        for(var d=parseInt(data.start_date)+1;d<=parseInt(data.end_date);++d){
             $("#id"+data.nip+" td").eq(d+1).remove();
        }
    }
}

function generateHeader(){
    var str_head ='<th style="width: 20px"></th><th></th>';

    for(var i=1;i<=vm.total_day;++i){
        str_head += '<th style="width: 30px">'+i+'</th>';
    }

    thead.append(str_head);
}

function generateBody(){
    var tbody = $("#tablebody");
    // console.log(vm.list_name);
    for(var i=0 ;i < vm.list_name.length; ++i){
        var str_body = '<tr id="id'+vm.list_name[i].id+'"><td>'+(i+1)+'.</td>';
        str_body += '<td class="gray">'+vm.list_name[i].name+'</td>';
        str_body += generateEmptyTd();
        str_body += '</tr>';

        tbody.append(str_body);
    }
}

function generateEmptyTd(){
    str_result="";
    for(var i=1;i<=vm.total_day;++i){
        str_result += '<td></td>';
    }

    return str_result;
}