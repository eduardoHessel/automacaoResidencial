<nav class="navbar navbar-expand navbar-dark bg-dark static-top" style=" font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;">

    <a class="navbar-brand mr-1" href="?p=pagina-inicial" style=" font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif; font-weight: 670;">WILL DOMUS</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">

        </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item"><?php
                    $idUsuario = $_SESSION['idUsuario'];
                    $id_casa = $_SESSION['id_casa'];
                    include_once '../class/Usuario.php';
                    $u = new Usuario();

                    $dados = $u->consultar($idUsuario, $id_casa);
                    foreach ($dados as $mostrar) {
                        $nome = $mostrar['Nome'];
                    }
                    echo 'Olá, ' . $nome
                    ?></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>

</nav> 



