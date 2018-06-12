var vm = new Vue({  
    el: "#mfd_tag",
    data: {
        hello: "Hello world",
        data: [],
    },
});

var loading = $("#loading");
var search = $("#search");
var search_type = $("#search_type");
var download_excel = $("#download-excel");

firebase.initializeApp({
    apiKey: "AIzaSyAzSb1P0Rq3r74dvSVxZXViidt2nULUtX4",
    authDomain: "mfdfirestore.firebaseapp.com",
    databaseURL: "https://mfdfirestore.firebaseio.com",
    projectId: "mfdfirestore",
    storageBucket: "mfdfirestore.appspot.com",
    messagingSenderId: "830731479472"
});
  
// Initialize Cloud Firestore through Firebase
var db = firebase.firestore();

$(document).ready(function() {
    refreshData();
});


search.keypress(function (e) {
    var key = e.which;
    if(key == 13)
    {
        refreshData();
        return false;  
    }
});   

function refreshData(){
    loading.css("display", "block");

    var coll = db.collection("datas");

    if(search.val().length>0){
        console.log("masuk search");
        coll = coll.where(search_type.val(), "==", search.val().toUpperCase());
    }
    
    coll.get().then((querySnapshot) => {
        vm.data = [];
        querySnapshot.forEach((doc) => {
            var cur_data={
                idnya: doc.id,
                art_laki: doc.data().art_laki,
                art_perempuan: doc.data().art_perempuan,
                blok_sensus: doc.data().blok_sensus,
                bsbtt: doc.data().bsbtt,
                desa_nama: doc.data().desa_nama,
                desa_no: doc.data().desa_no,
                kab_nama: doc.data().kab_nam,
                kab_no: doc.data().kab_no,
                kec_nama: doc.data().kec_nama,
                kec_no: doc.data().kec_no,
                kk: doc.data().kk,
                muatan_dominan: doc.data().muatan_dominan,
                prov_nama: doc.data().prov_nama,
                prov_no: doc.data().prov_no,
                ruta_biasa: doc.data().ruta_biasa,
                ruta_khusus: doc.data().art_khusus
            };
            vm.data.push(cur_data);
        });
        loading.css("display", "none");
    }); 
}


// download_excel.click(function(){
//     console.log("masuk downloat");
//     tableToExcel();
// });

// function tableToExcel(){
//     var uri = "data:application/vnd.ms-excel;base64,",
//     template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http:\/\/www.w3.org\/TR\/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}<\/x:Name><x:WorksheetOptions><x:DisplayGridlines\/><\/x:WorksheetOptions><\/x:ExcelWorksheet><\/x:ExcelWorksheets><\/x:ExcelWorkbook><\/xml><![endif]--><\/head><body><table>{table}<\/table><\/body><\/html>',
//     base64 = function(s) {
//         return window.btoa(unescape(encodeURIComponent(s)));
//     },
//     format = function(s, c) {
//         return s.replace(/{(\w+)}/g, function(m, p) {
//             return c[p];
//         });
//     };

//     return function() {
//         table = 'tabletoexcel';
//         fileName = 'mfd1673.xls';
//         if (!table.nodeType) table = document.getElementById(table)
//         var ctx = {
//             worksheet: fileName || 'Worksheet', 
//             table: table.innerHTML
//         }

//         $("<a id='dlink'  style='display:none;'></a>").appendTo("body");
//             document.getElementById("dlink").href = uri + base64(format(template, ctx))
//             document.getElementById("dlink").download = fileName;
//             document.getElementById("dlink").click();
//     }
// }
