var vm = new Vue({  
    el: "#edit_tag",
    data: {
        jumlah_ruta:0
    },
});

var pathname = window.location.pathname;

$(document).ready(function() {
});


  $(".btn_drop").click(function () {
    var init_number = $(this).data('nid');


    $("#edit"+init_number).attr('disabled', true);
    $("#drop"+init_number).removeAttr('checked');
    $("#drop"+init_number).attr('disabled', false);
    $(this).removeClass("btn-default").addClass('btn-info');
  });


  //Enable check and uncheck all functionality
  $(".checkbox-toggle").click(function () {
    var clicks = $(this).data('clicks');
    if (clicks) {
      //Uncheck all checkboxes
      $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
    } else {
      //Check all checkboxes
      $(".mailbox-messages input[type='checkbox']").iCheck("check");
    }
    $(this).data("clicks", !clicks);
  });


