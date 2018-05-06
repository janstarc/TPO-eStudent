$(document).ready(function() {
    $("#naslov2").hide();
    
    $("#je_zavrocanje").click(function(){
		$("#naslov2").hide();
        $("#ulica2").removeAttr("required");
        $("#hisna_stevilka2").removeAttr("required");
        $("#id_posta2").removeAttr("required");
	});
    
    $("#ni_zavrocanje").click(function(){
		$("#naslov2").show();        
        $("#ulica2").attr("required", true);
        $("#hisna_stevilka2").attr("required", true);
        $("#id_posta2").attr("required", true);
	});
});
