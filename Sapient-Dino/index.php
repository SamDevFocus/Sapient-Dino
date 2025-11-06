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
    <main class="content">
      <header>
        <h1>Bem vindo dino - IA</h1>
        <p>Uma biblioteca de soluçoes de duvidas compartlhadas</p>
      </header>
      <div class="card-container">
        <div class="card">
          <div class="card-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="card-info">
            <h3><?= $total ?></h3>
            <p>Palavras salvas</p>
          </div>
        </div>
        <div class="card">
          <div class="card-icon">
            <i class="fas fa-clock"></i>
          </div>
          <div class="card-info">
            <h3><?= htmlspecialchars($ultima['titulo']) ?></h3>
            <p><?= date('d/m/Y H:i', strtotime($ultima['data_criacao'])) ?></p>
            <p>Última palavra</p>
          </div>
        </div>
      </div>
      <section class="home-intro">
        <h1>Bem-vindo ao <span class="nome-projeto">SapientDino</span></h1>
        <p>Um espaço onde conhecimento e curiosidade caminham lado a lado.</p>
        <p class="slogan">"Aprender nunca foi tão instintivo!"</p>
      </section>

      <section class="how-it-works">
        <h2>Como funciona?</h2>
        <ol>
          <li>🐾 Pesquise um termo ou dúvida na Biblioteca IA.</li>
          <li>📖 Explore as respostas geradas pela inteligência do Dino.</li>
          <li>💾 Suas descobertas ficam salvas na biblioteca para consulta futura.</li>
        </ol>
      </section>

      <section class="about">
        <h2>Sobre o SapientDino</h2>
        <p>
          O SapientDino nasceu com o objetivo de transformar curiosidade em conhecimento.
          Cada palavra salva representa uma nova descoberta, um novo passo na evolução do aprendizado.
        </p>
        <p>
          Desenvolvido com dedicação e inspirado na força da evolução, ele é o companheiro perfeito
          para estudantes, criadores e curiosos que nunca param de aprender.
        </p>
      </section>

      <footer class="footer">
        <p>Feito com 🦕 por <strong>SapientDino</strong> • Crescendo com o conhecimento desde 2025</p>
      </footer>
      <script src="script.js"></script>
</body>

</html>