<?php
include 'ValidarSessao.php';
include 'links.php';
class categoria extends links_pages{

    function inserir(){
        include('conexao.PHP');

        $nome = $_POST['nome'];
        $obs = $_POST['obs'];

        $sql_inserir = "INSERT INTO categoria(nome, descricao) VALUES ('$nome', '$obs')";
        $inserir = mysqli_query($conexao, $sql_inserir);

        header('Location:' . $this->link_categorias);
        
    }
    function deletar(){
        include_once('conexao.php');
        $id = $_GET['id_categoria'];
        $sqldelete = "DELETE FROM categoria WHERE id_categoria='$id'";
        $result = mysqli_query($conexao, $sqldelete);

        header('Location:' . $this->link_categorias);
    }
    function mostrar_categoria(){
        include('conexao.PHP');
        $sql = "SELECT * FROM categoria ORDER BY id_categoria ASC ";
        $result = $conexao->query($sql);

        while ($user_data = mysqli_fetch_assoc($result)) {

            $id_categoria = $user_data['id_categoria'];
            $query_quantidade = "SELECT SUM(quantidade) as quantidade_total FROM produto WHERE categoria = $id_categoria";
            $query_quantidade = $conexao->query($query_quantidade);
            $linha = $query_quantidade->fetch_assoc();
            $soma = $linha['quantidade_total'];

            echo "<form action='../PHP/categoria.php' method='GET'>";
                echo "<input type='hidden' name='id' value='$id_categoria'/>";
                echo "<tr>";
                    echo "<td>" . $id_categoria . "</td>";
                    echo "<td> <input style='border: none;' name='input_name[$user_data[id_categoria]]' value='" . $user_data['nome'] . "'/></td>";
                    if($user_data['descricao'] == null || $user_data['descricao'] == ' '){
                        echo "<td>Não há descrição da categoria </td>";
                    }else{
                        echo "<td> <input style='border: none;' name='descricao' value='" . $user_data['descricao']. "'/></td>";
                    }

                    echo "<td style=";
                    if ($soma == 0) {
                        echo " 'color: red;' >" . "0";
                    } elseif ($soma > 0) {
                        echo " 'color: green;' >" . $soma;
                    }
                    echo "</td>";

                    // BOTOES PARA EDITAR E EXCLUIR
                    echo " 
                            <td>
                            <button class='editar' type='submit' style='width: 35px; height: 35px; color: #fff'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg>
                            </button> 
                        
                            <button class='editar' type='button'>
                                <a style='width: 40px; height: 40px;' name='id_categoria' href='../PHP/categoria.php?id_categoria=$user_data[id_categoria]&delete=on'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                    </svg>
                                </a>
                            </button>
                            </td>
                            ";
                echo "</tr>";
            echo "</form>";
        }
    }
    function editar_categoria(){

        include_once('conexao.PHP');

        $nome = reset($_GET['input_name']);
        $descricao = $_GET['descricao'];
        $id = $_GET['id'];

        $sqlUpdate = "UPDATE categoria SET nome='$nome', descricao='$descricao' WHERE id_categoria='$id'";
        $result = mysqli_query($conexao, $sqlUpdate); 
        
        header('Location:' . $this->link_categorias);
        die();
    }
}

$categoria = new categoria;
if(isset($_POST['nome']) && isset($_POST['obs'])){
    echo "1";
    $categoria->inserir();
}
if(!empty($_GET['delete'])){
    if($_GET['delete'] == 'on'){
        $categoria->deletar();
    }
}
elseif(isset($_GET['id']) && empty($_GET['delete'])){

    $categoria->editar_categoria();
}

?>