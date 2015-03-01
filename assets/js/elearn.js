$(document).ready(function(){
    if($("#life_available").val()==0){
        $("#modalDanger2_mod").trigger('click');
    }
    $("#life_regain_lose").click(function(){
        var regain = 'regain';
        $.ajax({
            type: "POST",
            url: site_url+'/chapters/regainLife',
            data: {"regain": regain},
            success: function (data) {
                //window.location = window.location.href;
            }
        });
    });
});