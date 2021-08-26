var url_atual = window.location.href;
var res = url_atual.split("/");

$('#idprojeto').val(res[4]);

//Cadastra Usuario
$("#gravar").click(function() {
	Cadastrar();
});

//Cadastra Usuario
$("#atualizar").click(function() {
	Atualizar();
});

function Cadastrar()
{
	$.ajax({
        url: "/enviar/convite",
        method: "POST",
        data: $("#formulario").serialize()
    })
    .done(function(resp){
    	if(resp)
		{
    		$.confirm({
    			title: 'Alerta de Segurança',
    			content: resp['response'],
			    buttons: {
			        ok: function(){
			        	location.reload();
			        }
			    }
			});
		}
    })
}

function ExcluirRelacao(idusuario)
{
	let idUser    = idusuario;
	let idProjeto = $('#idprojeto').val()
	
	oData = new Object();
	oData.idUser    = idUser;
	oData.idProjeto = idProjeto;
	
	$.confirm({
        content: 'Deseja Realmente Excluir esse Vinculo de Usuario ?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/excluir/vinculo",
                        method: "POST",
                        data: oData
                    })
                    .done(function(resp){
                    	if(resp)
                		{
                    		if(resp['code'] == 200)
                			{
                    			$.confirm({
                        			title: 'Alerta de Segurança',
                        			content: resp['response'],
                    			    buttons: {
                    			        ok: function(){
                    			        	location.reload();
                    			        }
                    			    }
                    			});
                			}
                		}
                    })
                }
            },
            alphabet: {
                text: 'Nao',
                action: function(){
                    return;
                }
            }
        }
    });
}

function Atualizar()
{
	var url_atual = window.location.href;
	var res = url_atual.split("/");
	
	let redirect  = 'http://' + res[2] + '/projeto/' + res[7] + '/usuarios';
	
		$.ajax({
        url: "/atualizar/user",
        method: "POST",
        data: $("#formulario").serialize()
    })
    .done(function(resp){
    	if(resp)
		{
    		$.confirm({
    			title: 'Alerta de Segurança',
    			content: resp['response'],
			    buttons: {
			        ok: function(){
			        	location.href = redirect;
			        }
			    }
			});
		}
    })

}
