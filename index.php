<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trabalho de Programação Web II</title>
  <link rel="stylesheet" href="estilo.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https: //fonts.googleapis.com/css2? family = Poppins: ital, wght @ 0,100; 0,400; 0,700; 1,100; 
      1,400; 1,700 & display = swap " rel=" stylesheet " />
</head>

<body>

  <?php
  date_default_timezone_set('America/Sao_Paulo');
  $pdo = new PDO('mysql:host=localhost;dbname=cadastro_produtos', 'root', '');
  ?>


  <div class="container">
    <div class="planilha">
      <h2>Online Shopping +</h2>
      <form method="POST">
        <input type="text" name="nome" placeholder="Digite o nome do produto">
        <input type="text" name="valor" placeholder="Digite o valor do produto">
        <input type="submit" name="acao" value="Cadastrar">
        <?php
        if (isset($_GET['delete'])) {
          $id = (int)$_GET['delete'];
          $pdo->exec("DELETE FROM produtos WHERE id=$id");
        }


        if (isset($_POST['acao'])) {
          $nome = $_POST['nome'];
          $valor = $_POST['valor'];
          $data_cadastro = date('Y-m-d H:i:s');

          $sql = $pdo->prepare("INSERT INTO `produtos` VALUES (NULL,?,?,?)");

          if ($nome != '' && $valor != '') {
            $sql->execute(array($nome, $valor, $data_cadastro));
            echo '<p style="color:blue;">Produto cadastrado com sucesso!</p>';
          } else {
            echo '<p style="color:green;">Os campos estão inválidos!</p>';
          }
        }
        ?>
      </form>
    </div>
    <div class="lista-produtos">
      <h2>Produtos Cadastrados</h2>
      <?php
      $sql = $pdo->prepare("SELECT * FROM produtos");
      $sql->execute();

      $fetchProdutos = $sql->fetchAll();

      foreach ($fetchProdutos as $key => $value) {
        /*Para deletar clique no (X)*/
        echo '<a title="Deletar produto" style="color:red;" href="?delete='.$value['id']. '"> (Excluir Produto) </a>'.
          $value['nome'].' | R$'.$value['valor'].
          ' - <a class="modal-update__link" href="update.php?update='.$value['id'].'">(Modificar Cadastro) </a>';
        echo '<hr>';
      }
      ?>
    </div>
  </div>

</body>

</html>