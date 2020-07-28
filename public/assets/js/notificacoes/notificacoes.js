var url_atual = window.location.href;
var res = url_atual.split("/");

$('#idprojeto').val(res[4]);

$('#previsto').mask('00/00/0000');

//Cadastra Anexo
$("#gravar").click(function() {
	Cadastrar();
});

//Editar Anexo
$("#editargravar").click(function() {
	UpdateNotificacao();
})

//Upload Arquivo
$('input[type=file]').on("change", function(){
	$('input[type=file]').each(function(index){
        if ($('input[type=file]').eq(index).val() != ""){
            readURL(this);
        }
    });
});

function Cadastrar()
{
	$.ajax({
        url: "/cadastrar/notificacao",
        method: "POST",
        data: $("#formulario").serialize()
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

function readURL(input)
{
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/notificacao',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                	$('#gravar').prop( "disabled", false );
                    $("#url").val(data['dir']);
                    $('#msgupload').html('Upload Concluído!');
                }
         });
    }
}

function ExcluirNotificacao(idNotificacao)
{
	let id = idNotificacao;

	oData = new Object();
	oData.id      = id

	$.confirm({
		title: 'Alerta de Segurança',
		content: 'Deseja Realmente Excluir essa Notificação?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){

                	$.ajax({
                        url: "/excluir/notificacao/"+id,
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

function UpdateNotificacao()
{
	let id = $('#idnotificacao').val();

	$.ajax({
        url: "/atualizar/notificacao/"+id,
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
