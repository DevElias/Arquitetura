<div class="col-12 col-md-2">
        <div class="card card-menu">
            <div class="card-body">
                <div class="row">
                    <ul class="menu-projeto">
                    <?php $id = $_SESSION['idprojeto']; ?>
                        <li class="<?php echo $sobre;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/status">
                                <img src="/assets/images/icones/sobre.svg" alt="Sobre" class="icon-projeto-list" />
                                Sobre</a>
                            </li>
                            <li class="<?php echo $projetos;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/anexos">
                                <span class="icon-projeto-list icon-projeto"></span>
                                Projeto</a>
                            </li>
                            <li class="<?php echo $cronograma;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/cronogramas" class="{{ request()->is('/projeto/*/cronogramas') ? 'active' : '' }}">
                                <span class="icon-projeto-list icon-cronograma"></span>
                                Cronogramas</a>
                            </li>
                            <li class="<?php echo $orcamento;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/orcamentos">
                                <span class="icon-projeto-list icon-orcamento"></span>
                                Orçamentos</a>
                            </li>
                            <li class="<?php echo $financeiro2;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/financeiro">
                                <span class="icon-projeto-list icon-financeiro"></span>
                                Financeiro</a>
                            </li>
                            <li class="<?php echo $reuniao;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/reunioes">
                                <span class="icon-projeto-list icon-reuniao"></span>
                                Reuniões</a>
                            </li>
                            <li class="<?php echo $notificacao;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/notificacoes">
                                <span class="icon-projeto-list icon-notificacao"></span>
                                Notificações</a>
                            </li>
                            <li  class="<?php echo $usuarios2;  ?>">
                                <a href="{{ url('/projeto/') }}/<?php echo $id;  ?>/usuarios">
                                <span class="icon-projeto-list icon-usuario"></span>
                                Usuários Vinculados</a>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
