<?php
$host = 'localhost';
$db   = 'dino-db2';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);

  // Conta quantos registros existem
  $stmt = $pdo->query("SELECT COUNT(*) AS total FROM respostas");
  $total = $stmt->fetch()['total'];

  // Última palavra adicionada
  $stmt = $pdo->query("SELECT titulo, data_criacao FROM respostas ORDER BY id DESC LIMIT 1");
  $ultima = $stmt->fetch();
} catch (PDOException $e) {
  $total = 0;
  $ultima = ['titulo' => 'Erro', 'data_criacao' => '---'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SapientDino</title>
  <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="logo">
        <img src="sapient.png" class="logo">
      </div>
      <nav class="menu">
        <ul>
          <li class="active">
            <a href="index.php">
              <i class="fas fa-home"></i>
              <span>Toca do Dino</span>
            </a>
          </li>
          <li>
            <a href="chat.php">
              <i class="fas fa-compass"></i>
              <span>Chat</span>
            </a>
          </li>
          <li>
            <a href="biblioteca.php">
              <i class="fas fa-chart-simple"></i>
              <span>Biblioteca IA</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <main class="content" style="overflow-y: hidden; display: flex; flex-direction: column;
    align-items: center; justify-content: center;">
      <header>
        <h1>Acervo SapientDino</h1>
        <p>Uma biblioteca de soluçoes de duvidas compartlhadas</p>
      </header>

      <!-- Barra de pesquisa -->
      <div class="barra-pesquisa-container">
        <input type="text" id="barraPesquisa" placeholder="Pesquisar palavra..." onkeyup="filtrarPalavras()">
      </div>

      <!--adiciona perguntas e respostas-->
      <div class="container-biblioteca">
        <?php
        // Busca todas as respostas
        $stmt = $pdo->query("SELECT id, titulo, resposta FROM respostas ORDER BY id DESC");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "
                <div class='bloco-palavra' onclick=\"mostrarDescricao(this)\">
                    <h2 class='titulo-palavra'>{$row['titulo']}</h2>
                    <p class='texto-resposta'>{$row['resposta']}</p>
                    <form method='POST' action='' onsubmit='return confirmarExclusao(event, {$row['id']})'>
                        <input type='hidden' name='delete_id' value='{$row['id']}'>
                        <button type='submit' class='botao-deletar'> Excluir</button>
                    </form>
                </div>";
        }
        ?>
      </div>
  </div>

  </main>
  </div>
  <script src="script.js"></script>

  <script>
    function mostrarDescricao(element) {
      const texto = element.querySelector('.texto-resposta');
      const botao = element.querySelector('.botao-deletar');
      const aberto = texto.classList.contains('aberta');

      // Fecha todos os outros
      document.querySelectorAll('.texto-resposta').forEach(t => {
        t.classList.remove('aberta');
      });
      document.querySelectorAll('.botao-deletar').forEach(b => {
        b.style.display = 'none';
      });

      // Abre só o clicado (sem mexer nas dimensões)
      if (!aberto) {
        texto.classList.add('aberta');
        botao.style.display = 'inline-block';
      }
    }

    function confirmarExclusao(event, id) {
      if (!confirm("Tem certeza que deseja excluir este item (ID " + id + ")?")) {
        event.preventDefault();
        return false;
      }
      return true;
    }

    function filtrarPalavras() {
      const termo = document.getElementById('barraPesquisa').value.toLowerCase();
      const blocos = document.querySelectorAll('.bloco-palavra');

      blocos.forEach(bloco => {
        const titulo = bloco.querySelector('.titulo-palavra').textContent.toLowerCase();
        const resposta = bloco.querySelector('.texto-resposta').textContent.toLowerCase();

        // Exibe o bloco se o termo aparecer no título ou na resposta
        if (titulo.includes(termo) || resposta.includes(termo)) {
          bloco.style.display = "flex";
        } else {
          bloco.style.display = "none";
        }
      });
    }
  </script>
</body>

</html>