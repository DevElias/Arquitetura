var url_atual = window.location.href;
var res = url_atual.split("/");

$('#idprojeto').val(res[4]);

$("#valorunitario").mask('#.##0,00', {
    reverse: true
  });
$("#valorunitarioedit").mask('#.##0,00', {
    reverse: true
    });
$("#totaledit").mask('#.##0,00', {
    reverse: true
    });
$("#total").mask('#.##0,00', {
	  reverse: true
	});

//Cadastra Anexo
$("#gravar").click(function() {
	Cadastrar();
});
$("#gravarServico").click(function() {
	CadastrarServico();
});
$("#gravarAprovado").click(function() {
	CadastrarAprovado();
});
//Editar Item
$("#editargravar").click(function() {
	UpdateItem();
})

function Cadastrar()
{
	$.ajax({
        url: "/cadastrar/orcamento/produto",
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


function CadastrarServico()
{
	$.ajax({
        url: "/cadastrar/orcamento/servico",
        method: "POST",
        data: $("#formulario").serialize()
    })
    .done(function(resp){
    	if(resp)
		{
    		if(resp['code'] == 200)
			{
    			$.confirm({
        			title: 'Mensagem de Sucesso',
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


function CadastrarAprovado()
{
	$.ajax({
        url: "/cadastrar/orcamento/itemaprovado",
        method: "POST",
        data: $("#formulario").serialize()
    })
    .done(function(resp){
    	if(resp)
		{
    		if(resp['code'] == 200)
			{
    			$.confirm({
        			title: 'Mensagem de Sucesso',
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
                url : '/upload/orcamento/imagemorcamento',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url").val(data['dir']);
                    $('#gravar').prop( "disabled", false );
                    $('#msgupload').html('Upload Concluído!');
                }
         });
    }
}

function readURL1(input)
{
    $('#gravar').prop( "disabled", true );
    $('#msgupload1').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/orcamento/imagemorcamento',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url1").val(data['dir']);
                    $('#gravar').prop( "disabled", false );
                    $('#msgupload1').html('Upload Concluído!');
                }
         });
    }
}


function readURL2(input)
{
    $('#gravar').prop( "disabled", true );
    $('#msgupload2').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/orcamento/imagemorcamento',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url2").val(data['dir']);
                    $('#gravar').prop( "disabled", false );
                    $('#msgupload2').html('Upload Concluído!');
                }
         });
    }
}

function readURL3(input)
{
    $('#gravar').prop( "disabled", true );
    $('#msgupload3').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/orcamento/imagemorcamento',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url3").val(data['dir']);
                    $('#gravar').prop( "disabled", false );
                    $('#msgupload3').html('Upload Concluído!');
                }
         });
    }
}

function readURL4(input)
{
    $('#gravar').prop( "disabled", true );
    $('#msgupload4').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/orcamento/imagemorcamento',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url4").val(data['dir']);
                    $('#gravar').prop( "disabled", false );
                    $('#msgupload4').html('Upload Concluído!');
                }
         });
    }
}

function readURL5(input)
{
    $('#gravar').prop( "disabled", true );
    $('#msgupload5').html('Fazendo upload do arquivo');
    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        var formData = new FormData();
        formData.append('file', input.files[0]);

         $.ajax({
                url : '/upload/orcamento/imagemorcamento',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    $("#url5").val(data['dir']);
                    $('#gravar').prop( "disabled", false );
                    $('#msgupload5').html('Upload Concluído!');

                }
         });
    }
}


function ExcluirItem(idItem)
{
	let id = idItem;

	oData = new Object();
	oData.id      = id

	$.confirm({
        title: 'Excluir item',
        content: 'Deseja Realmente Excluir esse Item?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){

                	$.ajax({
                        url: "/excluir/orcamento/itens/"+id,
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


function ExcluirtemProduto(idPai)
{
	let id = idPai;

	oData = new Object();
	oData.id      = id

	$.confirm({
        title: 'Excluir item',
        content: 'Deseja Realmente Excluir esse Item?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){

                	$.ajax({
                        url: "/excluir/orcamento/itenspai/"+id,
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



//Editar Item
function EditarItem(idItem)
{
	$('#editargravar').prop( "disabled", true );

	$('#formedit').trigger('reset');

	let id = idItem;

	oData    = new Object();
	oData.id = id;

	$.ajax({
        url: "/editar/orcamento/itens/"+id,
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		console.log(resp.response[0]);
    		$("#editarcategoria").val(resp.response[0].id_categoria);
    		$('#descricaoedit').val(resp.response[0].descricao);
            $('#valorunitarioedit').val(resp.response[0].valor);
            $('#unidadeedit').val(resp.response[0].unidade);
            $('#totaledit').val(resp.response[0].total);
            $('#iditem').val(resp.response[0].id);
            $('#editargravar').prop( "disabled", false );
		}
    })

}


function UpdateItem()
{
	let id = $('#iditem').val();

	$.ajax({
        url: "/atualizar/orcamento/itens/"+id,
        method: "POST",
        data: $("#formedit").serialize()
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

function AprovarItemProduto($idform){
    console.log($("#form"+$idform).serialize());
    $formulario = $("#form"+$idform).serialize();
    if($formulario != ""){


    $.ajax({
        url: "/aprovar/orcamento/produto",
        method: "POST",
        data: {
            'form': $("#form"+$idform).serializeArray(),
            'id_pai': $idform
        }
    })
    .done(function(resp){
    	if(resp)
		{
    		if(resp['code'] == 200)
			{
    			$.confirm({
        			title: 'Item Aprovado',
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
    }else {
        $.confirm({
            title: 'Erro',
            content: 'Antes de clicar em aprovar, selecione o item que gostaria de aprovar!',
            buttons: {
                ok: function(){
                }
            }
        });
    }
}

function ReprovarItemProduto($idform){
    console.log($("#form"+$idform).serialize());
    $.ajax({
        url: "/reprovar/orcamento/produto",
        method: "POST",
        data: $("#formReprovar").serialize(),
    })
    .done(function(resp){
    	if(resp)
		{
    		if(resp['code'] == 200)
			{
    			$.confirm({
        			title: 'Item Reprovado',
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

function reprovarItemModal(idpai){
    $('#idpai').val();
    $('#idpai').val(idpai);
}

//Cancelar Faturamento(Apagar os itens de faturamento baseado no ID de orçamento)
function CancelarFaturamento(orcamento)
{

	let idorcamento = orcamento;

	oData = new Object();
	oData.idorcamento      = idorcamento

	$.confirm({
        title: 'Cancelar Faturamento',
        content: 'Deseja Realmente Cancelar o Faturamento deste item?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){

                	$.ajax({
                        url: "/excluir/financeiro/orcamento/"+idorcamento,
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


function EditarItensPergunta(id_pai)
{
	let idpai = id_pai;

	$.ajax({
        url: "/atualizar/orcamento/itens/lote/"+idpai,
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
