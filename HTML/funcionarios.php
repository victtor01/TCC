<?php

session_start();
if(isset($_SESSION['nome']) && isset($_SESSION['id']) && isset($_SESSION['cargo'])){
    if($_SESSION['cargo'] != 1){
        header('Location: painel.php');
        die();
    }
}
else{
    header('Location: ../login.php');
    die();
}


include_once '../PHP/conexao.php';
include_once '../PHP/funcionarios.php';

$funcionario = new funcionario;
$funcionario = $funcionario->getFuncionario();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <script src="../JS/script.js"></script>
    <script src="../modal/modal.js"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../modal/modal.css">

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <title>Produtos</title>

</head>

<body>

    <div class="msg" id="msg2" style="background-color: red;">
        <h2> Algo deu errado</h2>
    </div>
    <div class="msg" id="msg1">
        <h2>Ação conluída com sucesso!</h2>
    </div>

    <header class="header-titulo titulo-principal">
        <div style="width: 100%; height: 100%; align-items: center; display: flex; position: relative; cursor: pointer;">
            <a href="painel.html" style="text-decoration: none; color: white; display: flex; justify-content: left; font-size: 12pt;">
                <img src="../imagens/box.png" width="45px" height="45px;" style="margin-right: 30px;">
                <h1 style="margin-right: 50px;"> Controle de Estoque </h1>
            </a>
            <div style="right: 0; position: absolute; color: #FF731D; display: flex;">
                <h2> Ola, admin! </h2>
            </div>
        </div>
    </header>

    <main>

        <div class="barra-lateral">
            <header>
                <div class="imagem">
                <img src="<?php echo $funcionario['foto']; ?>" width="150" height="150">
                </div>
                <h2 style="margin-top: 10px;"> <?php echo $funcionario['nome']?></h2>
            </header>
            <section>
                <a href="painel.php">
                    <ion-icon name="desktop-outline"></ion-icon> <span> Home </span>
                </a>
                <a href="produtos.php">
                    <ion-icon name="bag-outline"></ion-icon> <span> Produtos </span>
                </a>
                <a href="categoria.php">
                    <ion-icon name="bookmark-outline"></ion-icon> <span> Categorias </span>
                </a>
                <a href="fornecedores.php">
                    <ion-icon name="person-outline"></ion-icon> <span> Fornecedores </span>
                </a>
                <button class="clientes-funcionarios" id="botao-financeiro" onclick="Financeiro()">
                    <ion-icon name="cash-outline"></ion-icon></ion-icon> <span> Financeiro </span>
                    <ion-icon name="chevron-forward-outline" id="ion-icon-seta-financeiro" width='10px'></ion-icon>    
                </button>
                <div class="href-clientes-funcionarios" id="href-financeiro">
                    <!-- <a href="#">
                        <span> Dashboard </span>
                    </a> -->
                    <a href="entrada.php">
                        <span> Entradas </span>
                    </a>
                    <a href="saidas.php">
                        <span> saidas </span>
                    </a>
                </div>
                
                <?php if($_SESSION['cargo'] == 1){ ?>
                    <a href="funcionarios.php">
                    <ion-icon name="person-outline"></ion-icon> <span> Funcionários </span>
                </a>
                    <!-- <button class="clientes-funcionarios" id="botao-contas" onclick="ClientesFuncionarios()">
                        <ion-icon name="person-add-outline"></ion-icon> <span> Contas </span>
                        <ion-icon name="chevron-forward-outline" id="ion-icon-seta" width='10px'></ion-icon>    
                    </button>
                    <div class="href-clientes-funcionarios" id="href-clientes-funcionarios">
                        <a href="funcionarios.php">
                            <span> Funcionários </span>
                        </a>
                        <a href="clientes.php">
                            <span> Clientes </span>
                        </a>
                    </div> -->
                <?php }?>

                <a href="../PHP/validar-user.php?logout=1" class="sair">
                    <ion-icon name="exit-outline"></ion-icon> <span> Sair </span>
                </a>
                
            </section>
        </div>

        <section class="section-principal">
            <header class="header-titulo titulo-section">
                <h1>
                    funcionários
                </h1>
            </header>

            <form action="../PHP/funcionarios.php" method="post" enctype="multipart/form-data">
                <div class="botoes-principais">
                    <div class="div">
                        <button type="button" class="botao" id="button-entrada" onclick="abrirmodal('button-entrada')">
                        <ion-icon name="add-outline" style="width: 30px; height: 100%;"></ion-icon> <span>Funcionário</span>
                        </button>
                    </div>
                    <div class="div-pesquisar div">
                        <input type="text" placeholder="Pesquise..." class="pesquisar">
                        <button type="button" class="btn-pesquisar" style="border: none; background: none;">
                            <img src="../imagens/lupa.png" width="25px" height="25px">
                        </button>
                    </div>
                    <div class="div">
                        <button type="submit" class="botao" id="button-saida" name="updateFuncionarios">
                            <ion-icon style="height: 26px; width: 26px" name="cloud-done-outline"></ion-icon> <span> Guardar </span>
                        </button>
                    </div>
                </div>
                <section class="section-informacoes">
                    <?php
                    $funcionario = new funcionario;
                    $funcionario->mostrarFuncionarios();
                    ?>
                </section>
            </form>

        </section>
        
    </main>

    <dialog id="modal-entrada" class="modal">

        <header class="header-cadastro">
            <!-- titulo da parte de registro de produto -->
            <h2 style="font-weight: 450;">cadastrar Funcionário</h2>
            <!-- botao que vai fechar a parte de registor de produto-->
            <button type="button" style="background: none;" onclick="fecharmodal('button-entrada-fechar')">
            <ion-icon style="width: 40px; height: 40px;"name="close-outline"></ion-icon>
            </button>

        </header>

        <section class="section-cadastro">
            <form method="POST" action="../PHP/funcionarios.php" enctype="multipart/form-data">
                <label class="informacoes">
                    <label class="label-titulo"> Nome do Funcionário: * </label>
                    <input name="nome" type="text" class="input-registro" placeholder="João" autocomplete="off" required>
                </label>

                <!-- Idade - Cargo-->
                <div class="div-informacoes">
                    <label class="label-quantidade">
                        <label class="label-titulo"> CPF </label>
                        <input name="CPF" type="text" class="input-registro" placeholder="000.000.000-00" autocomplete="off" required>
                    </label>

                    <label class="label-tamanho">
                        <label class="label-titulo"> Cargo: *</label>
                        <select id="cargo" name="cargo" class="select">
                            <option value='1'>Gerente</option>
                            <option value='2'>Faxineiro</option>
                            <option value='3'>Recepcionista</option>
                            <option value='4'>Vendedor</option>
                        </select>
                    </label>
                </div>

                <!--  Data - Foto-->
                <div class="div-informacoes">
                    <label class="label-data">
                        <label class="label-titulo"> Data de Nascimento: * </label>
                        <input name="data" type="date" class="input-registro" autocomplete="off" required>
                    </label>
                    <label>
                        <label class="label-titulo"> Foto:  *</label>
                        <input class="foto" name="foto" type="file">
                    </label>
                </div>

                <!-- Salário - Contato -->
                <div class="div-informacoes">
                    <label class="label-numero">
                        <label class="label-titulo"> Salário: *</label>
                        <input id="salario" name="salario" type="text" class="input-registro" placeholder="1000.00" autocomplete="off" required>
                    </label>
                    <label class="label-numero">
                        <label class="label-titulo"> Contato: *</label>
                        <input name="contato" type="text" class="input-registro" placeholder="(99)9999-9999" autocomplete="off" required>
                    </label>
                </div>
                
                <!-- Email -->
                <div class="div-informacoes">
                    <label class="label-numero">
                        <label class="label-titulo"> Email: *</label>
                        <input id="valor_fornecedor" name="email" type="email" class="input-registro" placeholder="example@gmail.com" autocomplete="off" required>
                    </label>
                </div>

                <!-- Senha - Confirmar senha -->
                <div class="div-informacoes">
                    <label class="label-numero">
                        <label class="label-titulo"> Senha: *</label>
                        <input name="senha" type="password" class="input-registro" placeholder="•••••••••" autocomplete="off" required>
                    </label>
                    <label>
                        <label class="label-titulo"> Confirmar senha: *</label>
                        <input name="confirmar_senha" type="password" class="input-registro" placeholder="•••••••••" autocomplete="off" required>                       
                    </label>
                </div>

                <!-- butao (submit) para enviar o produto para o banco de dados-->
                <div class="botoes-submit">
                    <button type="reset" class="botao2"> Limpar </button>
                    <button type="submit" name="inserir" class="botao1"> cadastrar</button>
                    
                </div>
            </form>
        </section>

    </dialog>

    <?php
    if(!empty($_GET['id_funcionario'])){

        $funcionario = new funcionario;
        $funcionario->ModalMudarSenhadoFuncionario();

    }
    ?>

</body>
