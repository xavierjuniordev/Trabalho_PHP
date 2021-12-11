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

  <div class="modal">
    <div class="modal-update">
      <h2>Atualizar Produto</h2>
      <?php
      if (isset($_GET['update'])) {
        $id = (int)$_GET['update'];
        $sql = $pdo->prepare("SELECT * FROM produtos WHERE id=:id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
      }
      ?>
      <form class="form-update" method="POST">
        <input type="text" name="nome" placeholder="Digite o nome do Produto" value="<?php echo ($rows[0]["nome"]) ?>">
        <input type="text" name="valor" placeholder="Digite o valor do Produto"
          value="<?php echo ($rows[0]["valor"]) ?>">
        <input type="submit" name="atualizar" value="Atualizar">
      </form>

      <?php
      if (isset($_POST['atualizar'])) {
        $nome = $_POST['nome'];
        $valor = $_POST['valor'];
        $update = $pdo->prepare("UPDATE produtos SET nome=:nome,valor=:valor WHERE id=:id");
        $update->bindParam(':id', $id);
        $update->bindParam(':nome', $nome);
        $update->bindParam(':valor', $valor);
        $update->execute();
        echo '<p style="color:green; text-align:center">Cadastro atualizado!</p>';
        echo '<br>';
        echo '<a style="text-align:center" href="index.php">Voltar a página de cadastro</a>';
      }
      ?>
    </div>
  </div>

</body>

</html>