$('#senha').on('keydown', function (e)
{
    if (e.keyCode === 13)
    {
      Login();
    }
})

// Validacoes
$("#nome").blur(function()
{
	Valida('nome');
});

$("#email").blur(function()
{
	Valida('email');
});

$("#nascimento").blur(function()
{
	Valida('nascimento');
});

$("#telefone").blur(function()
{
	Valida('telefone');
});

$("#whatsapp").blur(function()
{
	Valida('whatsapp');
});

$("#cep").blur(function()
{
	Valida('cep');
});

$("#numero").blur(function()
{
	Valida('numero');
});

$("#senha").blur(function()
{
	Valida('senha');
});

$("#password").blur(function()
{
	Valida('password');
});

//Validacao cpf
$("#cpf").blur(function(){
	bcpf = TestaCPF($('#cpf').val().replace(/[^\d]+/g,''));

	if(bcpf === false)
	{
		$("#gravar").prop("disabled",true);
		$("#cpf").removeClass("errocpf");
		$("#cpf").attr("style", "");
		$(".errorC").remove();

		var msg = 'CPF Inválido';
		$( "#cpf" ).focus();
	    $("#cpf").addClass("errocpf");
	    $(".errocpf").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	    return false;
	}
	else
	{
		$("#gravar").prop("disabled",false);
		$("#cpf").removeClass("errocpf");
		$("#cpf").attr("style", "");
		$(".errorC").remove();
	}
});

//Cadastra Usuario
$("#gravar").click(function() {
	Cadastrar();
});

//Cadastra Usuario
$("#atualizar").click(function() {
	Atualizar();
});

//Logar no Sistema
$("#login").click(function() {
	Login();
});

//Esqueci minha Senha
$("#esqueci").click(function() {
	EsqueciSenha();
});

function Cadastrar()
{
	Valida('nome');
	Valida('email');
	Valida('nascimento');
	Valida('telefone');
	Valida('whatsapp');
	Valida('cep');
	Valida('numero');
	Valida('senha');
	Valida('password');

	oData = new Object();
	oData.nome        = $('#nome').val();
	oData.email       = $('#email').val();
	oData.cpf         = $('#cpf').val().replace(/[^\d]+/g,'');
	oData.nascimento  = $('#nascimento').val().replace(/[^\d]+/g,'');
	oData.telefone    = $('#telefone').val().replace(/[^\d]+/g,'');
	oData.whatsapp    = $('#whatsapp').val().replace(/[^\d]+/g,'');
	oData.cep         = $('#cep').val().replace(/[^\d]+/g,'');
	oData.endereco    = $('#endereco').val();
	oData.numero      = $('#numero').val();
	oData.complemento = $('#complemento').val();
	oData.bairro      = $('#bairro').val();
	oData.cidade   	  = $('#cidade').val();
	oData.estado      = $('#estado').val();
	oData.senha       = $('#senha').val();

	$.ajax({
        url: "/cadastrar",
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
    		else
			{
    			$.confirm({
        			title: 'Alerta de Segurança',
        			content: resp['response'],
    			    buttons: {
    			        ok: function(){

    			        }
    			    }
    			});
			}
		}
    })
}

function Login()
{
	oData = new Object();
	oData.email  = $('#email').val();
	oData.senha  = $('#senha').val();

	$.ajax({
        url: "/login",
        method: "POST",
        data: oData
    })
    .done(function(resp){
    	if(resp)
		{
    		if(resp['code'] == 200)
    		{
    			location.href = resp['redirect'];
    		}
    		else
    		{
    			$.confirm({
        			title: 'Alerta de Segurança',
        			content: resp['response'],
    			    buttons: {
    			        ok: function(){

    			        }
    			    }
    			});
    		}
		}
    })

}

function Atualizar()
{
	oData = new Object();
    oData.cpf  = $('#cpf').val().replace(/[^\d]+/g,'');
    oData.nascimento  = $('#nascimento').val().replace(/[^\d]+/g,'');
	oData.telefone    = $('#telefone').val().replace(/[^\d]+/g,'');
	oData.whatsapp    = $('#whatsapp').val().replace(/[^\d]+/g,'');
	oData.cep         = $('#cep').val().replace(/[^\d]+/g,'');
	oData.endereco    = $('#endereco').val();
	oData.numero      = $('#numero').val();
	oData.complemento = $('#complemento').val();
	oData.bairro      = $('#bairro').val();
	oData.cidade   	  = $('#cidade').val();
	oData.estado      = $('#estado').val();
	oData.senha       = $('#senha').val();
	oData.id          = $('#id').val();

	$.ajax({
        url: "/atualizar",
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
			        		location.reload();
		        		}
			        }
			    }
			});
		}
    })

}

function EsqueciSenha()
{
	oData       = new Object();
	oData.email = $('#email').val();

	$.ajax({
        url: "/enviar/senha",
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
			        		resp['redirect'];
		        		}
			        }
			    }
			});
		}
    })
}


function AtualizaNotificacao(id)
{
	oData    = new Object();
	oData.id = id;

	$.ajax({
        url: "/atualiza/notificacoes",
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

function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
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

function AprovarUsuario(id)
{
	oData = new Object();
	oData.id = id;

	$.ajax({
        url: "/aprovar/usuario",
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

function ReprovarUsuario(id)
{
	oData = new Object();
	oData.id = id;

    $.confirm({
    	title: 'Alerta de Segurança',
    	content: 'Deseja realmente reprovar esta usuario?',
        buttons: {
            specialKey: {
                text: 'Sim',
                action: function(){
                	$.ajax({
                        url: "/reprovar/usuario",
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
