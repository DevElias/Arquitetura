
// Validacoes
$("#nome").blur(function()
{
	Valida('nome');
});

//Cadastra Categoria
$("#gravar").click(function() {
	Cadastrar();
});

//Editar Categoria
$("#editargravar").click(function() {
	EditarCategoria();
});

function Cadastrar()
{
	let vinculos = {} ;
	Valida('nome');
	
	if( $('#chk1').prop('checked') ) {
	    vinculos[1] = 1;
	}
	
	if( $('#chk2').prop('checked') ) {
	    vinculos[2] = 2;
	}
	
	if( $('#chk3').prop('checked') ) {
	    vinculos[3] = 3;
	}
	
	if( $('#chk4').prop('checked') ) {
	    vinculos[4] = 4;
	}
	
	if( $('#chk5').prop('checked') ) {
	    vinculos[5] = 5;
	}
	
	if( $('#chk6').prop('checked') ) {
	    vinculos[6] = 6;
	}
	
	
	oData = new Object();
	oData.nome      = $('#nome').val();
	oData.vinculos  = vinculos;
	
	$.ajax({
        url: "/cadastrar/categoria",
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
    			        	if(resp['redirect'])
    		        		{
    			        		location.href = resp['redirect'];
    		        		}
    			        }
    			    }
    			});
			}
		}
    })
}

function Valida(campo)
{
	if($('#'+campo).val() == '')
	{
		 $("#"+campo).removeClass("erro"+campo);
		 $("#"+campo).attr("style", "");
		 $(".errorC").remove();
	     $("#"+campo).addClass("erro"+campo);
	     $(".erro"+campo).css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + '</p>');
	     return false;
	}
	else
	{
		$("#"+campo).removeClass("erro"+campo);
		$("#"+campo).attr("style", "");
		$(".errorC").remove();
	}
}

//Excluir Categoria
function Excluir(idCategoria)
{
	let id = idCategoria;
	
	oData = new Object();
	oData.id      = id
	
	$.confirm({
        content: 'Deseja Realmente Excluir essa Categoria?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	
                	$.ajax({
                        url: "/eliminar/categoria/"+id,
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
                    			        	if(resp['redirect'])
                    		        		{
                    			        		location.href = resp['redirect'];
                    		        		}
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
function Editar(idCategoria)
{
	$('#editargravar').prop( "disabled", true );
	
	$('#formedit').trigger('reset');
	
	let id = idCategoria;
	
	oData    = new Object();
	oData.id = id;
	
	$.ajax({
        url: "/editar/categoria/"+id,
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		$('#idcategoria').val(resp.response[0].id);
    		$('#editarnome').val(resp.response[0].nome);
    		$('#editargravar').prop( "disabled", false );
    		
    		var chks = (resp.response[0].id_vinculos.split(","));
    		
    		$.each(chks, function( index, value ) {
    			$('#editarchk'+value).prop("checked", true);
    		});
		}
    })
	
}

function EditarCategoria()
{
	let vinculos = {} ;
	Valida('nome');
	
	if( $('#editarchk1').prop('checked') ) {
	    vinculos[1] = 1;
	}
	
	if( $('#editarchk2').prop('checked') ) {
	    vinculos[2] = 2;
	}
	
	if( $('#editarchk3').prop('checked') ) {
	    vinculos[3] = 3;
	}
	
	if( $('#editarchk4').prop('checked') ) {
	    vinculos[4] = 4;
	}
	
	if( $('#editarchk5').prop('checked') ) {
	    vinculos[5] = 5;
	}
	
	if( $('#editarchk6').prop('checked') ) {
	    vinculos[6] = 6;
	}
	
	oData          = new Object();
	oData.id       = $('#idcategoria').val();
	oData.nome     = $('#editarnome').val();
	oData.vinculos = vinculos;
	
	$.ajax({
        url: "/atualizar/categoria",
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
    			        	if(resp['redirect'])
    		        		{
    			        		location.href = resp['redirect'];
    		        		}
    			        }
    			    }
    			});
			}
		}
    })
	
}
