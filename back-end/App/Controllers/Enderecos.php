<?php

use App\Core\Controller;
//
Class Enderecos extends Controller{

  public function index(){
    $modelEndereco = $this->model("Endereco");
    $dados = $modelEndereco->listarTodos();
    echo json_encode($dados);
  }

  public function find($id){
    $modelEndereco = $this->model("Endereco");
    $dados = $modelEndereco->buscarPorId($id);

    if($dados){
      echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }else{
      http_response_code(404);
      $erro = ["Erro" => "Endereço não encontrado"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }

    return $dados;
  }

  public function store(){
    $json = file_get_contents("php://input");
    $modelEndereco = $this->model("Endereco");
    $dadosinsercao = json_decode($json);
    //uf, cidade, bairro, rua, numero, complemento, cep
    $modelEndereco->uf = $dadosinsercao->uf;
    $modelEndereco->cidade = $dadosinsercao->cidade;
    $modelEndereco->bairro = $dadosinsercao->bairro;
    $modelEndereco->rua = $dadosinsercao->rua;
    $modelEndereco->numero = $dadosinsercao->numero;
    $modelEndereco->complemento = $dadosinsercao->complemento;
    $modelEndereco->cep = $dadosinsercao->cep;
    $modelEndereco->inserirEndereco();
    return $modelEndereco;

  }

  public function update($id){
    $json = file_get_contents("php://input");
    $modelEndereco = $this->model("Endereco");
    $dadosEdicao = json_decode($json);
    $modelEndereco->uf = $dadosEdicao->uf;
    $modelEndereco->cidade = $dadosEdicao->cidade;
    $modelEndereco->bairro = $dadosEdicao->bairro;
    $modelEndereco->rua = $dadosEdicao->rua;
    $modelEndereco->numero = $dadosEdicao->numero;
    $modelEndereco->complemento = $dadosEdicao->complemento;
    $modelEndereco->cep = $dadosEdicao->cep;
    $modelEndereco->idEndereco = $id;
    if($modelEndereco->atualizar()){
      http_response_code(204);
    }else{
      http_response_code(500);
      $erro = ["erro" => "Problemas ao editar o cliente"];
      echo json_encode($erro, JSON_UNESCAPED_UNICODE);
    }
    
  }

  public function delete($id){
    $modelEndereco = $this->model("Endereco");
    $modelEndereco->buscarPorId($id);
    if(!$modelEndereco){
      http_response_code(404);
      $erro = ["Erro" => "Endereco não encontrado"];
      echo json_encode($erro);
    }else if($modelEndereco->deletar()){
      http_response_code(204);
      $mensagem = ["Sucesso!" => "Deleção efetuada com sucesso!"];
      echo json_encode($mensagem);
    }
  }

}