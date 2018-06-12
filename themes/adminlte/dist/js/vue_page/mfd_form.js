var vm = new Vue({  
    el: "#mfdform_tag",
    data: {
        idnya:'',
        art_laki: 0,
        art_perempuan: 0,
        blok_sensus: '',
        bsbtt: 0,
        desa_nama: '',
        desa_no: '',
        kab_nama: '',
        kab_no: '',
        kec_nama: '',
        kec_no: '',
        kk: 0,
        muatan_dominan: '',
        prov_nama: '',
        prov_no: '',
        ruta_biasa: 0,
        ruta_khusus: 0
    },
});

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

$( "#btn-submit" ).click(function() {

});