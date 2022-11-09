<?php
    class produto{
        
        public function inserir()
        {

            include('conexao.PHP');
     
            $nome =  $_POST['nome'] ;
            $categoria =  $_POST['categoria'];
            $quantidade =  $_POST['quantidade'];
            $fornecedor =  $_POST['fornecedor'];
            $valor_investido =  $_POST['investimento'];
            $lucro_esperado = $_POST['lucro'];
            $data_produto = $_POST['data'];
            $tamanho = $_POST['tamanho'];

            $inserir_produto  = "INSERT INTO
            produto (nome, categoria, quantidade, fornecedor,
            valor_investido, lucro_esperado, data_produto, tamanho)
            VALUES ('$nome', $categoria, '$quantidade',
            $fornecedor, '$valor_investido', '$lucro_esperado', '$data_produto',
            '$tamanho')";
        
            $query_result = mysqli_query($conexao, $inserir_produto);

            if(!$query_result){
                $msg = false;
                return $msg;
            }
            else{
                $msg = true;
                return $msg;
            }

            
        }
        function retirar()
        {
            include('conexao.PHP');
            $produtos = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            foreach($produtos['id'] as $chave => $id){

                $id_produto = $produtos['id'][$chave];
                $nome = $produtos['nome'][$chave];
                $quantidade_retirada = $produtos['quantidade'][$chave];
                $preco = $produtos['preco'][$chave];
                $categoria = $produtos['categoria'][$chave];
                $fornecedor = $produtos['fornecedor'][$chave];
                $data = $produtos['data'];
                $tamanho = $produtos['tamanho'][$chave];
                $valor_total = (intval($quantidade_retirada) * intval($preco));

                /*
                    echo "Chave: " . $chave ."</br>";
                    echo "nome: " . $nome . "</br>";
                    echo "id: ". $id_produto ."</br>";
                    echo "quantidade: ". $quantidade_retirada . "</br>";
                    echo "preço: " . $preco . "</br>";
                    echo " categoria" . $categoria . "</br>";
                    echo "fornecedor: " . $fornecedor ."</br>";
                    echo "data: " . $data ."</br>";
                    echo "tamanho: " . $tamanho ."</br>";
                ECHO */
                
                $sql_quantidade_atual = "SELECT quantidade FROM produto WHERE id_produto=$id_produto"; 
                $query = mysqli_query($conexao, $sql_quantidade_atual);
                
                while($quant = mysqli_fetch_assoc($query)) 
                {
                    $quantidade_atual = $quant['quantidade'];
                }                

                $resto = (intval($quantidade_atual) - intval($quantidade_retirada));

                if($resto < 0){
                    header("Location: ../HTML/produtos.php?msg=2");
                }else{
                    $sql_update = "UPDATE produto SET quantidade = '$resto' WHERE id_produto=$id_produto";
                    $query = mysqli_query($conexao, $sql_update);
                    $produto = new produto;
                    $produto->saida($nome, $preco, $data, $tamanho, $categoria, $fornecedor, $quantidade_retirada, $valor_total);
                    header('location: ../HTML/produtos.php?msg=1');
                }
            }

            
        }
        private function entrada($nome, $valor, $data, $tamanho, $categoria, $fornecedor)
        {
            include('conexao.PHP');
            $sql = "INSERT INTO entrada(quantidade, valor, tamanho, nome, data_entrada)
            VALUES ('$quantidade', '$valor', '$tamanho', '$nome', '$data')";

            $result = mysqli_query($conexao, $sql);

            if($result){
                header('Location: ../HTML/produtos.php');
            }else{
                echo "algo deu errado!";
            }
        }
        private function saida($nome, $valor, $data, $tamanho, $categoria, $fornecedor, $quantidade, $valor_total)
        {
            include('conexao.PHP');
            $sql = "INSERT INTO saida(quantidade, valor_produto, nome_produto,
            data_saida, tamanho, categoria, fornecedor, valor_total) 
            VALUES ('$quantidade', '$valor', '$nome', '$data', '$tamanho', '$categoria', '$fornecedor', '$valor_total')";

            $query = mysqli_query($conexao, $sql);
        }
        public function delete($id)
        {
            include_once('conexao.PHP');

            $sql = "DELETE FROM produto WHERE id_produto=$id";
            $query_result = mysqli_query($conexao, $sql);

        }
        public function validar($dados)
        {
            include_once('conexao.PHP');

            if(!empty($dados['checkbox_id'])){
                $pesquisa = implode(", ", $dados['checkbox_id']);
                header("Location: ../HTML/produtos.php?pesquisa=" . $pesquisa);          
            }
            else{
                header("Location: ../HTML/produtos.php");
            }
        }
        function modal_produtos_selecionados($pesquisa)
        {

            include('conexao.PHP');
            $sql = "SELECT * FROM produto WHERE id_produto IN ($pesquisa)";
            $result = mysqli_query($conexao, $sql);

            if(mysqli_num_rows($result) > 0){
            echo" 

            <script>
                var modal_ = window.document.getElementById('modal-saida');
                modal_.showModal();
            </script>";

            while($user_data = mysqli_fetch_assoc($result)){
                $id = $user_data['id_produto'];
                $nome = $user_data['nome'];
                $categoria = $user_data['categoria'];
                $tamanho = $user_data['tamanho'];
                $quantidade = $user_data['quantidade'];
                $fornecedor = $user_data['fornecedor'];
                
                echo"<div class='modal-saida-select-result'>
                            <input type='hidden' name='id[]' value='$id'>

                            <label style='width: 100%; display: flex; flex-direction: column; '>
                                <span style=' width: 100%;'> nome: </span>
                                <span>" . $nome . " </span>
                                <input name='nome[]' type='hidden' value='". $nome ."'>
                            </label>

                            <label style='width: 100%; display: flex;flex-direction: column;'>
                                <span style=' width: 100%;'> categoria: </span>
                                <span> " . $categoria . "</span>
                                <input name='categoria[]' type='hidden' value='". $categoria ."'>
                            </label>

                            <label style='width: 100%; display: flex;flex-direction: column;'>
                                <span style=' width: 100%;'> tamanho: </span>
                                <span > ";
                                    switch($tamanho) {
                                        case 1:
                                            echo "P";
                                            break;
                                        case 2:
                                            echo "PP";
                                            break;
                                        case 3:
                                            echo "M";
                                            break;
                                        case 4:
                                            echo "G";
                                            break;
                                        case 5:
                                            echo "GG";
                                            break;
                                    } 
                                echo "</span>
                                <input type='hidden' name='tamanho[]' value='$tamanho'>
                            </label>

                            <label style='width: 100%; display: flex;flex-direction: column;'>
                                <span style=' width: 100%;'> quantidade: </span>
                                <input name='quantidade[]' type='number' max=". $quantidade .">
                            </label>

                            <label style='width: 100%; display: flex;flex-direction: column;'>
                                <span style=' width: 100%;'> valor: </span>
                                <input name='preco[]' type='text'>
                            </label>

                            <input type='hidden' name='fornecedor[]' value=.$fornecedor.>

                    </div>";

            }

            echo"<label style='width: 100%; display: flex;flex-direction: column;'>
                    <span style=' width: 100%;'> data: </span>
                    <input name='data' type='date'>
                </label>";
            }
        }
        function mostrar_produtos()
        {
            include('conexao.PHP');
                    $sql = "SELECT * FROM produto ORDER BY data_produto ASC";
                    $result = mysqli_query($conexao, $sql);

                    if(mysqli_num_rows($result) > 0){
                        echo" 
                        <thead>
                            <tr class='tr'>
                                <th></th>
                                <th> Nome </th>
                                <th> Categoria</th>
                                <th> Tamanho</th>
                                <th> Quantidade</th>
                                <th> Data</th>
                                <th style='min-width: 100px;'> Ações </th>
                            </tr>
                        </thead>";

                        while ($user_data = mysqli_fetch_assoc($result)) {
                            $id = $user_data['id_produto'];
                            $nome = $user_data['nome'];
                            $categoria = $user_data['categoria'];
                            $quantidade = $user_data['quantidade'];
                            $fornecedor = $user_data['fornecedor'];
                            $valor_investido = $user_data['valor_investido'];
                            $lucro_esperado = $user_data['lucro_esperado'];
                            $data_produto = $user_data['data_produto'];
                            $tamanho = $user_data['tamanho'];
                            $data = $user_data['data_produto'];
    
                            $sql_fornecedor = "SELECT nome FROM fornecedor WHERE id_fornecedor = $fornecedor";
                            $result_fornecedor = mysqli_query($conexao, $sql_fornecedor);
    
                            if (mysqli_num_rows($result_fornecedor) > 0) {
                                while ($rowData = mysqli_fetch_assoc($result_fornecedor)) {
                                    $fornecedor_nome = $rowData["nome"];
                                }
                            }
    
                            $sql_categoria = "SELECT nome FROM categoria WHERE id_categoria = $categoria";
                            $result_categoria = mysqli_query($conexao, $sql_categoria);
    
                            if (mysqli_num_rows($result_categoria) > 0) {
                                while ($rowData = mysqli_fetch_assoc($result_categoria)) {
                                    $categoria_nome = $rowData["nome"];
                                }
                            }
                           
                            echo "<tr> <td>";
                            echo "<input type='checkbox' style='width: 70%; height: 70%; border-radius: 5px; 'name='checkbox_id[$id]' value='" . $id . "'>";
                            echo"</td>";

                            echo "<td style='max-width: 100px'>";
                            echo $nome;
                            echo "</td>";
                            echo "<td>";
                            echo $categoria_nome;
                            echo "</td>";
                            echo "<td>";
                            switch ($tamanho) {
                                case 1:
                                    echo "P";
                                    break;
                                case 2:
                                    echo "PP";
                                    break;
                                case 3:
                                    echo "M";
                                    break;
                                case 4:
                                    echo "G";
                                    break;
                                case 5:
                                    echo "GG";
                                    break;
                            }
                            echo "</td>";
                            echo "<td style='color: "; 
                            if($quantidade > 5){echo "green;'>";}
                            elseif($quantidade > 0){ echo "blue;'>"; }
                            else { echo "red;'>";}

                            echo $quantidade . "</td>";
                            
                            echo "<td>" . $data ."</td>";

                            echo "<td style='max-width: 60px; min-width: 50px;'>
        
                                    <button class='editar' type='button'>
                                        <a style='width: 35px; height: 35px;name='id_produto' href='../PHP/produto.php?id_produto=$user_data[id_produto]'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                            <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                            </svg>
                                        </a>
                                    </button> 
                        
                        
                                    <button class='editar' type='button'>
                                        <a style='width: 35px; height: 35px;' name='id_produto' href='../PHP/produto.php?id_produto=$user_data[id_produto]&delete=on'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                            </svg>
                                        </a>
                                    </button>
    
                                    <button class='editar' type='button' style='background-color: yellow'>
                                    <a style='width: 35px; height: 35px; color: black;' name='id_produto' >
                                        <ion-icon name='information-circle-outline' style='width: 20px; height: 20px;'></ion-icon>
                                    </a>
                                    </button>
                            
                                </td>";
    
                            echo "</tr>";

                        }
                    }
                    else{
                        echo "Nenhum produto cadastrado";
                    }
        }
    }

    $produto = new produto;

    if(isset($_POST['submit-produto'])){
        $msg = $produto->inserir();
        if($msg){  header('Location: ../HTML/produtos.php?msg=1'); }
        else{  header('Location: ../HTML/produtos.php?msg=0');}
    }
    elseif(!empty($_GET['id_produto']) && !empty($_GET['delete']) ){
        if($_GET['delete'] == 'on'){
            $id = $_GET['id_produto'];
            $msg = $produto->delete($id);
            header('Location: ../HTML/produtos.php?msg=1');
        }
    }
    elseif(isset($_POST['submit-saida-produto'])){
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $produto->validar($dados);
    }
    elseif(isset($_POST['retirar-produto'])){
        $produto->retirar();
    }
