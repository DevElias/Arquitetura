var url_atual = window.location.href;
var res = url_atual.split("/");

$('#idprojeto').val(res[4]);

$("#valor").mask('#.##0,00', {
	  reverse: true
	});

$('#data').mask('00/00/0000');

//Cadastra Pagamento
$("#gravar").click(function() {
	Cadastrar();
});

//Editar Pagamento
$("#editargravar").click(function() {
	UpdatePagamento();
})

//Upload Arquivo
$('input[type=file]').on("change", function(){
	$('input[type=file]').each(function(index){
        if ($('input[type=file]').eq(index).val() != ""){
            readURL(this);
        }
    });
});

//Criar Faturamento (Transformar Orçamento em Faturamento)
$("#btncriarFaturamento").click(function() {
    CriarFaturamento();
})


function Cadastrar()
{
	$.ajax({
        url: "/cadastrar/financeiro",
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
    $('#msgupload').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/financeiro',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url").val(data['dir']);
                    $('#msgupload').html('Upload Concluído!');
                }
         });
    }
}

function ExcluirPagamento(idPagamento)
{
	let id = idPagamento;

	oData = new Object();
	oData.id      = id

	$.confirm({
        content: 'Deseja Realmente Excluir esse Pagamento?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){

                	$.ajax({
                        url: "/excluir/financeiro/"+id,
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
                    			        	location.href = resp['redirect'];
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

function UpdatePagamento()
{
	let id = $('#idpagamento').val();

	$.ajax({
        url: "/atualizar/financeiro/"+id,
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

//Metodo para converter Orçamento em Faturamento
function CriarFaturamento()
{
    let idprojeto = $('#idprojeto').val();
    let idcategoria = $('#categoria').val();
	$.ajax({
        url: "/cadastrar/financeiro/orcamento",
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
    			        	window.location.href = '/projeto/'+idprojeto+'/orcamentos/listagem/?categoria='+idcategoria;
    			        }
    			    }
    			});
			}
		}
    })
}
