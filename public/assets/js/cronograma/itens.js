$('#comeco').mask('00/00/0000');
$('#fim').mask('00/00/0000');

$('#editarcomeco').mask('00/00/0000');
$('#editarfim').mask('00/00/0000');

var url_atual = window.location.href;
var res = url_atual.split("/");
$('#cronograma').val(res[6]);

//Cadastra Cronograma
$("#gravar").click(function() {
	Cadastrar();
});

//Editar Item
$("#editargravar").click(function() {
	UpdateItem();
})

function Cadastrar()
{
    let idprojeto = $('#idprojetocriacao').val();
    let idcronograma = $('#cronograma').val();
    let categoriaurlcriacao = $('#categoria').val();
	$.ajax({
        url: "/cadastrar/cronograma/itens",
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
    			        	window.location.href = '/projeto/'+idprojeto+'/cronogramas/'+idcronograma+'/detalhes/?categoria='+categoriaurlcriacao;
    			        }
    			    }
    			});
			}
		}
    })
}

function ExcluirItem(idItem)
{
	let id = idItem;

	oData = new Object();
	oData.id      = id

	$.confirm({
        title: 'Alerta de Segurança',
        content: 'Deseja Realmente Excluir esse Item?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){

                	$.ajax({
                        url: "/excluir/cronograma/itens/"+id,
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
        url: "/editar/cronograma/itens/"+id,
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		$("#editarcategoria ").val(resp.response[0].id_categoria);
    		$('#editardescricao').val(resp.response[0].descricao);
            $('#editarprancha').val(resp.response[0].prancha);
            $('#editarcomeco').val(resp.response[0].inicio);
    		$('#editarfim').val(resp.response[0].fim);
    		$('#editarexecutor').val(resp.response[0].executor);
    		$("#editarstatus ").val(resp.response[0].status);
    		$('#editargravar').prop( "disabled", false );
    		$('#iditem').val(resp.response[0].id);
    		$('#editarcronograma').val(resp.response[0].id_cronograma);
		}
    })

}

function UpdateItem()
{
    let id = $('#iditem').val();
    let categoriaurl = $('#editarcategoria').val();
    let idprojetoeditar = $('#iddoprojetoeditar').val();
    let idcronogramaeditar = $('#editarcronograma').val();


	$.ajax({
        url: "/atualizar/cronograma/itens/"+id,
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
    			        	window.location.href = '/projeto/'+idprojetoeditar+'/cronogramas/'+idcronogramaeditar+'/detalhes/?categoria='+categoriaurl;
    			        }
    			    }
    			});
			}
		}
    })
}
