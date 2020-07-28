var url_atual = window.location.href;
var res = url_atual.split("/");

$('#idprojeto').val(res[4]);

$('#gravardocumento').attr("disabled", true);

$('#data').mask('00/00/0000');
$('#horainicio').mask('00:00');
$('#horafim').mask('00:00');

//Upload Arquivo
$('input[type=file]').on("change", function(){
	$('input[type=file]').each(function(index){
        if ($('input[type=file]').eq(index).val() != ""){
            readURL(this);
        }
    });
});


//Cadastra Anexo
$("#gravar").click(function() {
	Cadastrar();
});

//Confirmar Reuniao
$("#confirmar").click(function() {
	Confirmar(res[7]);
});

//Editar Reuniao
$("#editar").click(function() {
	Editar();
});

//Editar Reuniao
$("#editargravar").click(function() {
	UpdateReuniao();
})

//Gravar Documento
$("#gravardocumento").click(function() {
	GravaDocumento();
});

//Editar Documento
$("#editardocumento").click(function() {
	AtualizarDocumento();
});

function Cadastrar()
{
	let usuarios = [];
	let contador = 0;
	
	$('input[name="chk"]:checked').toArray().map(function(check) { 
		usuarios[contador] = $(check).val();
		contador++;
	});

	console.log(usuarios);
	
	$.ajax({
        url: "/cadastrar/reuniao",
        method: "POST",
        data: ({'formulario': $("#formulario").serialize(), 'usuarios' : usuarios}),
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

function ExcluirAnexo(idAnexo)
{
	let id = idAnexo;
	
	oData = new Object();
	oData.id      = id
	
	$.confirm({
        content: 'Deseja Realmente Excluir esse Projeto?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/excluir/anexo/"+id,
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

function UpdateAnexo()
{
	let id = $('#idanexo').val();
	
	$.ajax({
        url: "/atualizar/anexo/"+id,
        method: "POST",
        data: $("#formularioedicao").serialize()
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
    			        	location.href = resp['redirect'];
    			        }
    			    }
    			});
			}
		}
    })
}

function Confirmar(idReuniao)
{
	$.confirm({
		title: 'Alerta de Segurança',
		content: 'Deseja Confirmar Presença nesta Reunião?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/confirmar/reuniao/"+idReuniao,
                        method: "POST",
                        data: ''
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
                	$.ajax({
                        url: "/rejeitar/reuniao/"+idReuniao,
                        method: "POST",
                        data: ''
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
            }
        }
    });
}

function UpdateReuniao()
{
	let id = $('#idreuniao').val();
	
	let usuarios = [];
	let contador = 0;
	
	$('input[name="chk"]:checked').toArray().map(function(check) { 
		usuarios[contador] = $(check).val();
		contador++;
	});

	console.log(usuarios);
	
	$.ajax({
        url: "/atualizar/reuniao/"+id,
        method: "POST",
        data: ({'formulario': $("#formularioedicao").serialize(), 'usuarios' : usuarios}),
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
    			        	location.href = resp['redirect'];
    			        }
    			    }
    			});
			}
		}
    })
}

function readURL(input) 
{
    if (input.files && input.files[0]) 
    {
        var reader = new FileReader();
        
        var formData = new FormData();
        formData.append('file', input.files[0]);
         
         $.ajax({
                url : '/upload/arquivo/reuniao',
                type : 'POST',
                data : formData,
                processData: false,  
                contentType: false, 
                success : function(data) {
                	$("#url").val(data['dir']);
                	$('#gravardocumento').attr("disabled", false);
                }
         });
    }
} 

function GravaDocumento()
{
	$.ajax({
        url: "/gravar/documento",
        method: "POST",
        data: $("#formdocumento").serialize()
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

function AprovarDocumento(idDocumento)
{
	let id = idDocumento;
	
	oData = new Object();
	oData.id      = id
	
	$.confirm({
		title: 'Alerta de Segurança',
		content: 'Deseja Realmente Aprovar esse Documento?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/aprovar/documento/"+id,
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

function ReprovarDocumento(idDocumento)
{
	let id = idDocumento;
	
	oData = new Object();
	oData.id      = id
	
	$.confirm({
		title: 'Alerta de Segurança',
		content: 'Deseja Realmente Reprovar esse Documento?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/reprovar/documento/"+id,
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

function ExcluirDocumento(idDocumento)
{
	let id = idDocumento;
	
	oData = new Object();
	oData.id      = id
	
	$.confirm({
		title: 'Alerta de Segurança',
		content: 'Deseja Realmente Excluir esse Documento?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/excluir/documento/"+id,
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

//Editar Categoria
function EditarDocumento(idDocumento)
{
	$('#editardocumento').prop( "disabled", true );
	
	$('#formdocumentoedit').trigger('reset');
	
	let id = idDocumento;
	
	oData    = new Object();
	oData.id = id;
	
	$.ajax({
        url: "/editar/documento/"+id,
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		console.log(resp);
    		$('#descricaoedit').val(resp.response[0].descricao);
    		$('#documentoedit').val(resp.response[0].documento);
    		$('#linkedit').val(resp.response[0].link);
    		$("#statusedit").val(resp.response[0].status).change();
    		$('#urledit').val(resp.response[0].arquivo);
    		$('#idocumento').val(resp.response[0].id);
    		$('#editardocumento').prop( "disabled", false );
		}
    })
	
}

function AtualizarDocumento()
{
	$.ajax({
        url: "/atualizar/documento",
        method: "POST",
        data: $("#formdocumentoedit").serialize()
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
