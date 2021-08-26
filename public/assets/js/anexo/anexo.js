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
	UpdateAnexo();
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
        url: "/cadastrar/anexo",
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
    $('#gravar').prop( "disabled", true );
    $('#msgupload').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/anexo',
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
