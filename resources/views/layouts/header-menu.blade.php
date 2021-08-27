<div class="main-header">
    <div class="logo">
        <img src="{{asset('assets/images/footer.png')}}" alt="">
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->

        <div class="menu-toggle">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="{{asset('assets/images/faces/1.png')}}" id="userDropdown" alt="" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i>
                        <?php if(!isset($_SESSION))
                              {
                                session_start();
                              }
                              echo($_SESSION['nome']); ?>
                    </div>
                    <a class="dropdown-item" href="/minha-conta/<?php echo $_SESSION['id'];?>">Minha Conta</a>
                    <a class="dropdown-item" href="/logout">Sair</a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- header top menu end -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{asset('assets/js/usuario/usuario.js')}}"></script>
