<!-- classes para criação dos menus em desktop e mobile-->
<nav  class="nav-bar">
    <div class="menu">
        <ul class="menuServicos">
            <li class="nav-item"><a href="./perfil.php" class = "nav-link" id="item0"><img src="./Imagens/iconPerfil.png" alt="icone de usuarios" class="icons">Perfil</a></li>
            <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
                <li class="nav-item"><a href="./usuarios.php" class = "nav-link"  id="item1"><img src="./Imagens/iconUsuarios.png" alt="icone de usuarios" class="icons">Usuarios</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'RECEPCIONISTA') : ?>
                <li class="nav-item"><a href="./pacientes.php" class="nav-link" id="item2"><img src="./Imagens/iconPacientes.png" alt="icone de pacientes" class="icons">Pacientes</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
                <li class="nav-item"><a href="./servicos.php" class = "nav-link"  id="item3"><img src="./Imagens/iconServicos.png" alt="icone de serviços" class="icons">Serviços</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO' || $_SESSION['cargo'] == 'ESPECIALISTA' || $_SESSION['cargo'] == 'RECEPCIONISTA') : ?>
                <li class="nav-item"><a href="./atendimento.php" class = "nav-link"  id="item3"><img src="./Imagens/iconCalendario.png" alt="icone de usuarios" class="icons">Agenda/Atendimento</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
                <li class="nav-item"><a href="./financeiro.php" class = "nav-link"  id="item4"><img src="./Imagens/iconFinanceiro.png" alt="icone de financeiro" class="icons">Financeiro</a></li>
            <?php endif; ?>
            <li class="nav-item" class="btnSair no-ajax"><a href="./logout.php" class = "nav-link" ><img src="./Imagens/iconSair.png" alt="icone de sair" class="icons">Sair</a></li>
        </ul>
    </div>
                
    <div class="mobile-menu-icon">
        <button onclick="menuShow()"><img class="icon" src="./Imagens/isconBurguer.png" alt=""></button>
    </div>
</nav>

<div class = "mobile-menu">
    <ul class="menuServicos">
        <li class="nav-item"><a href="./perfil.php" class = "nav-link" id="item0"><img src="./Imagens/iconPerfil.png" alt="icone de usuarios" class="icons">Perfil</a></li>
        <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
            <li class="nav-item"><a href="./usuarios.php" class = "nav-link"  id="item1"><img src="./Imagens/iconUsuarios.png" alt="icone de usuarios" class="icons">Usuarios</a></li>
        <?php endif; ?>
        <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'RECEPCIONISTA') : ?>
            <li class="nav-item"><a href="./pacientes.php" class = "nav-link"  id="item2"><img src="./Imagens/iconPacientes.png" alt="icone de pacientes" class="icons">Pacientes</a></li>
        <?php endif; ?>
        <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
            <li class="nav-item"><a href="./servicos.php" class = "nav-link"  id="item3"><img src="./Imagens/iconServicos.png" alt="icone de serviços" class="icons">Serviços</a></li>
        <?php endif; ?>
        <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO' || $_SESSION['cargo'] == 'ESPECIALISTA' || $_SESSION['cargo'] == 'RECEPCIONISTA') : ?>
            <li class="nav-item"><a href="./atendimento.php" class = "nav-link"  id="item3"><img src="./Imagens/iconCalendario.png" alt="icone de usuarios" class="icons">Agenda/Atendimento</a></li>
        <?php endif; ?>
        <?php if ($_SESSION['cargo'] == 'ADM' || $_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
            <li class="nav-item"><a href="./financeiro.php" class = "nav-link"  id="item4"><img src="./Imagens/iconFinanceiro.png" alt="icone de financeiro" class="icons">Financeiro</a></li>
        <?php endif; ?>
        <li class="nav-item" class="btnSair no-ajax"><a href="./logout.php" class = "nav-link" ><img src="./Imagens/iconSair.png" alt="icone de sair" class="icons">Sair</a></li>
    </ul>
</div>   
<!--////////--> 