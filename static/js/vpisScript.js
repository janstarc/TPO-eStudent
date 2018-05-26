$(document).ready(function() {
    toggleDrzava();
    toggleDrzava2();
    
    $("#stalni").click(function(){
        $("#id_drzava2").removeAttr("required");
        $("#ulica2").removeAttr("required");
	});
    
    $("#zacasni").click(function(){
        $("#id_drzava2").attr("required", true);
        $("#ulica2").attr("required", true);
	});
});

function toggleDrzava() {
    if ($("#id_drzava").val() == 705) {
        $(".postaINobcina").show();
        $("#id_posta").attr("required", true);
        $("#id_obcina").attr("required", true);
    } else {
        $(".postaINobcina").hide();
        $("#id_posta").removeAttr("required");
        $("#id_obcina").removeAttr("required");
    }
}

function toggleDrzava2() {
    if ($("#id_drzava2").val() == 705) {
        $(".postaINobcina2").show();
        $("#id_posta2").attr("required", true);
        $("#id_obcina2").attr("required", true);
    } else {
        $(".postaINobcina2").hide();
        $("#id_posta2").removeAttr("required");
        $("#id_obcina2").removeAttr("required");
    }
}
