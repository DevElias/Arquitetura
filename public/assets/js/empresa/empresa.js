$('#desc-empresa').on('keydown', function (e)
{
    if (e.keyCode === 13)
    {
    	BuscaEmpresa();
    }
})

$('#cnpj-empresa').on('keydown', function (e)
{
    if (e.keyCode === 13)
    {
    	SolicitarVinculo();
    }
})

// Validacoes
$("#fantasia").blur(function()
{
	Valida('fantasia');
});

$("#social").blur(function()
{
	Valida('social');
});

$("#email").blur(function()
{
	Valida('email');
});

$("#tel").blur(function()
{
	Valida('tel');
});

$("#cep").blur(function()
{
	Valida('cep');
});

$("#numero").blur(function()
{
	Valida('numero');
});

//Validacao CNPJ
$("#cnpj").blur(function(){
	bcnpj = validarCNPJ($('#cnpj').val());
	
	if(bcnpj === false)
	{
		$("#gravar").prop("disabled",true);
		$("#cnpj").removeClass("errocnpj");
		$("#cnpj").attr("style", "");
		$(".errorC").remove();
		
		var msg = 'CNPJ Inválido';
		$( "#cnpj" ).focus();
	    $("#cnpj").addClass("errocnpj");
	    $(".errocnpj").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	    return false;
	}
	else
	{
		$("#gravar").prop("disabled",false);
		$("#cnpj").removeClass("errocnpj");
		$("#cnpj").attr("style", "");
		$(".errorC").remove();
	}
});

//Apenas Numeros no campos CNPJ
$('#cnpj-empresa').keyup(function() {
  $(this).val(this.value.replace(/\D/g, ''));
});

//Cadastra Empresa
$("#gravar").click(function() {
	Cadastrar();
});

//Busca Empresa
$("#search").click(function() {
	BuscaEmpresa();
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
	
	Valida('fantasia');
	Valida('social');
	Valida('email');
	Valida('tel');
	Valida('cep');
	Valida('numero');
	
	oData = new Object();
	oData.fantasia    = $('#fantasia').val();
	oData.social      = $('#social').val();
	oData.cnpj        = $('#cnpj').val().replace(/[^\d]+/g,'');;
	oData.email       = $('#email').val();
	oData.tel         = $('#tel').val().replace(/[^\d]+/g,'');;
	oData.whats       = $('#whats').val().replace(/[^\d]+/g,'');;
	oData.cep         = $('#cep').val().replace(/[^\d]+/g,'');;
	oData.endereco    = $('#endereco').val();
	oData.numero      = $('#numero').val();
	oData.complemento = $('#complemento').val();
	oData.bairro      = $('#bairro').val();
	oData.cidade      = $('#cidade').val();
	oData.estado      = $('#estado').val();
	oData.segmento    = $('#segmento').val();
	oData.responsavel = $('#responsavel').val();

	$.ajax({
        url: "/cadastrar/empresa",
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

function BuscaEmpresa()
{
	oData = new Object();
	oData.empresa = $('#desc-empresa').val();

	$.ajax({
        url: "/buscar/empresa",
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

function Aprovar(id)
{
	oData = new Object();
	oData.id = id;

	$.ajax({
        url: "/aprovar/empresa",
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
			        	if(resp['redirect'])
		        		{
			        		location.href = resp['redirect'];
		        		}
			        }
			    }
			});
		}
    })
}

function Reprovar(id)
{
	oData = new Object();
	oData.id = id;

    $.confirm({
    	title: 'Alerta de Segurança',
    	content: 'Deseja realmente reprovar esta empresa?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	$.ajax({
                        url: "/reprovar/empresa",
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
			        	if(resp['redirect'])
		        		{
			        		location.href = resp['redirect'];
		        		}
			        }
			    }
			});
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

function CriarPasta()
{
	oData = new Object();
	oData.descricao = $('#descricao').val();
	oData.idempresa = $('#idempresa').val();
	oData.pathname  = window.location.pathname;
	oData.url       = window.location.href;
	oData.origin    = window.location.origin;

	$.ajax({
        url: "/criar/pasta",
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		location.reload();
		}
    })
}

function SolicitarVinculo()
{
	oData      = new Object();
	oData.cnpj = $('#cnpj-empresa').val();

	$.ajax({
        url: "/solicitar/empresa",
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
			        	if(resp['redirect'])
		        		{
			        		location.href = resp['redirect'];
		        		}
			        }
			    }
			});
		}
    })
}

function AprovarSolicitacao(id)
{
	oData = new Object();
	oData.id_solicitacao = id;

	$.ajax({
        url: "/aprovar/solicitacao",
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

function ReprovarSolicitacao(id)
{
	oData = new Object();
	oData.id_solicitacao = id;

    $.confirm({
    	title: 'Alerta de Segurança',
    	content: 'Deseja realmente reprovar este usuario?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	$.ajax({
                        url: "/reprovar/solicitacao",
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

function TornarResponsael(idusuario, idempresa)
{
	oData            = new Object();
	oData.id_usuario = idusuario;
	oData.id_empresa = idempresa;

    $.confirm({
    	title: 'Alerta de Segurança',
    	content: 'Deseja realmente tornar este usuario responsável por essa empresa?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	$.ajax({
                        url: "/responsavel/empresa",
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

function Atualizar()
{
	oData = new Object();
	oData.fantasia    = $('#fantasia').val();
	oData.social      = $('#social').val();
	oData.email       = $('#email').val();
	oData.tel         = $('#tel').val().replace(/[^\d]+/g,'');;
	oData.whats       = $('#whats').val().replace(/[^\d]+/g,'');;
	oData.cep         = $('#cep').val().replace(/[^\d]+/g,'');;
	oData.endereco    = $('#endereco').val();
	oData.numero      = $('#numero').val();
	oData.complemento = $('#complemento').val();
	oData.bairro      = $('#bairro').val();
	oData.cidade      = $('#cidade').val();
	oData.estado      = $('#estado').val();
	oData.segmento    = $('#segmento').val();
	oData.id          = $('#idempresa').val();

	$.ajax({
        url: "/atualizar/empresa",
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
			        	if(resp['redirect'])
		        		{
			        		location.href = resp['redirect'];
		        		}
			        }
			    }
			});
		}
    })
}

function validarCNPJ(cnpj) 
{
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
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

function ReprovarEmpresa(id)
{
	oData = new Object();
	oData.id = id;

    $.confirm({
    	title: 'Alerta de Segurança',
    	content: 'Deseja realmente reprovar esta empresa?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	$.ajax({
                        url: "/reprovar/empresa",
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
