$('#desc-projeto').on('keydown', function (e)
{
    if (e.keyCode === 13)
    {
    	BuscaProjeto();
    }
})

// Validacoes
$("#nome").blur(function()
{
	Valida('nome');
});

$("#descricao").blur(function()
{
	Valida('descricao');
});

$("#cep").blur(function()
{
	Valida('cep');
});

$("#numero").blur(function()
{
	Valida('numero');
});

//Cadastra Empresa
$("#gravar").click(function() {
	Cadastrar();
});

//Editar Reuniao
$("#editargravar").click(function() {
	UpdateProjeto();
})

//Busca Empresa
$("#search").click(function() {
	BuscaProjeto();
});

//Cria Pasta
$("#criar").click(function() {
	CriarPasta();
});

//Cria Pasta
$("#solicitar").click(function() {
	SolicitarVinculo();
});

//Adicionar usuario a empresa
$("#addusuario").click(function() {
	AdicionarUsuario();
});

//Atualizar Empresa
$("#atualizar-empresa").click(function() {
	Atualizar();
});

function Cadastrar()
{
	
	Valida('nome');
	Valida('descricao');
	Valida('cep');
	Valida('numero');
	
	oData = new Object();
	oData.nome        = $('#nome').val();
	oData.descricao   = $('#descricao').val();
	oData.cep         = $('#cep').val().replace(/[^\d]+/g,'');;
	oData.endereco    = $('#endereco').val();
	oData.numero      = $('#numero').val();
	oData.complemento = $('#complemento').val();
	oData.bairro      = $('#bairro').val();
	oData.cidade      = $('#cidade').val();
	oData.estado      = $('#estado').val();
	oData.status      = $('#status').val();
	oData.etapa       = $('#etapa').val();

	$.ajax({
        url: "/cadastrar/projeto",
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

function BuscaProjeto()
{
	oData = new Object();
	oData.projeto = $('#desc-projeto').val();

	$.ajax({
        url: "/buscar/projeto",
        method: "POST",
        data: oData
    })
     .done(function(resp){
    	if(resp)
		{
    		$('#busca').html(resp['html']);
		}
    })

}

function AdicionarUsuario()
{
	oData               = new Object();
	oData.identificador = $('#identificador').val();
	oData.id_empresa    = $('#idempresa').val();

	$.ajax({
        url: "/addusuario/empresa",
        method: "POST",
        data: oData
    })
     .done(function(resp){
    	if(resp)
		{
    		$.confirm({
    			title: 'Alerta de Segurança',
    			content: resp['response'],
			    buttons: {
			        ok: function(){
			        	if(resp['code'] == '200')
		        		{
			        		location.reload();
		        		}
			        }
			    }
			});
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

function UpdateProjeto()
{
	let id = $('#idprojeto').val();
	
	$.ajax({
        url: "/atualizar/projeto/"+id,
        method: "POST",
        data: $("#formularioedicao").serialize(),
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
