function clicar_categoria(){
  let fundo1 = document.getElementById("fundo-registrar-categoria");
  let registro = document.getElementById("registrar-categoria");
  

  fundo1.style.display = "flex";
  registro.style.display ="block";

}
function fechar_categoria() {
  let fundo = document.getElementById("fundo-registrar-categoria");
  let registro = document.getElementById("registrar-categoria");

  fundo.style.display = "none";
  registro.style.display ="none";
}

function clicar_fornecedor() {
  let fundo = document.getElementById("fundo-registrar-fornecedor");
  let registro = document.getElementById("registrar-fornecedor");
  fundo.style.display = "flex";
  registro.style.display = "block";
}

var hidden = true;
function ClientesFuncionarios(){
  var clientesfuncionarios = window.document.querySelector('.href-clientes-funcionarios');
  var imagem_seta = window.document.getElementById('ion-icon-seta');

  if(hidden == true){
    clientesfuncionarios.style.display = "block";
    hidden = false;
    imagem_seta.style.cssText = 
    'transform: rotate(90deg)';
  }
  else{ 
    clientesfuncionarios.style.display = "none";
    hidden = true;
    imagem_seta.style.cssText = 
    'transform: rotate(0deg)';
  }
}