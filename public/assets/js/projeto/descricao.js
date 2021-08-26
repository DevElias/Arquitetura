var url_atual = window.location.href;
var res = url_atual.split("/");

	oData = new Object();
	oData.idprojeto = res[4];
	
	$.ajax({
        url: "/projeto/get",
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		if(resp['code'] == 200)
			{
    			$('#nomeprojeto').html(resp['projeto']['nome']);
			}
		}
    })