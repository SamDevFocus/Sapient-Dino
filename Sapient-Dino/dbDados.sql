<?php
// ==========================================================
// 🔌 CONEXÃO COM O BANCO DE DADOS
// ==========================================================
// Aqui você configura a comunicação entre o PHP e o MySQL.
// É ESSENCIAL que os dados de conexão estejam corretos, senão
// o sistema não conseguirá salvar nem buscar as informações.

$host = 'localhost';   // Local onde o banco está rodando.
                       // "localhost" = mesma máquina onde está o XAMPP.

$db   = 'dino-db2';    // Nome do banco de dados que você criou no phpMyAdmin.
$user = 'root';        // Usuário padrão do MySQL no XAMPP.
$pass = 'root';        // Senha do MySQL (mude se você definiu outra).
$charset = 'utf8mb4';  // Padrão de caracteres moderno (suporta acentos e emojis).

// ==========================================================
// 💻 CONECTANDO USANDO PDO
// ==========================================================
// O PDO é uma forma segura e moderna de conectar o PHP ao banco.
// Ele ajuda a evitar falhas e facilita o tratamento de erros.

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green;'>✅ Conexão bem-sucedida com o banco de dados!</p>";
} catch (PDOException $e) {
    echo "<p style='color:red;'>❌ Erro na conexão: " . $e->getMessage() . "</p>";
    exit;
}

// ==========================================================
// 📚 COMANDOS SQL PARA CRIAR, VISUALIZAR E GERENCIAR OS DADOS
// ==========================================================
// Os comandos abaixo devem ser executados no phpMyAdmin
// (ou você pode copiar e rodar via terminal SQL).

$sql_explicativo = <<<SQL

-- ==========================================================
-- 🗂️ CRIAÇÃO DA TABELA 'respostas'
-- ==========================================================
-- Essa tabela armazena todas as palavras e seus significados.
-- Cada item recebe automaticamente um ID (número único).
-- O campo 'data_criacao' marca quando a palavra foi cadastrada.

CREATE TABLE respostas (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Identificador único
    titulo VARCHAR(255) UNIQUE,                 -- Palavra (não pode repetir)
    resposta TEXT,                              -- Significado ou explicação
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data automática
);

-- ==========================================================
-- 🔎 VISUALIZAR O QUE JÁ ESTÁ SALVO
-- ==========================================================
-- Esse comando mostra todas as palavras cadastradas no banco:
SELECT * FROM respostas;

-- ==========================================================
-- 🧹 APAGAR ALGUM ITEM ESPECÍFICO
-- ==========================================================
-- Exemplo: apaga todos os registros com ID menor que 12:
DELETE FROM respostas WHERE id < 12;

-- Para deletar apenas um registro específico:
DELETE FROM respostas WHERE id = 5;

-- ==========================================================
-- 🧩 INSERIR NOVOS ITENS (PALAVRAS E SEUS SIGNIFICADOS)
-- ==========================================================
-- Exemplo de povoamento inicial com explicações prontas:
INSERT INTO respostas (titulo, resposta) VALUES
("Resiliência", "\"Resiliência\" é a capacidade de se adaptar e se recuperar diante de dificuldades, traumas ou mudanças. Representa a força emocional de seguir em frente mesmo após situações adversas."),
("Empatia", "\"Empatia\" é a habilidade de compreender e compartilhar os sentimentos de outra pessoa, colocando-se em seu lugar para entender suas emoções e perspectivas."),
("Persistência", "\"Persistência\" é a atitude de continuar tentando alcançar um objetivo, mesmo diante de obstáculos ou fracassos."),
("Autoconhecimento", "\"Autoconhecimento\" é a compreensão que uma pessoa tem sobre si mesma — suas emoções, comportamentos, motivações e valores."),
("Disciplina", "\"Disciplina\" é a capacidade de manter o foco e seguir regras ou hábitos consistentes para atingir metas e objetivos.");

SQL;

// ==========================================================
// 🧾 MOSTRANDO AS INSTRUÇÕES NA TELA
// ==========================================================
// Essa parte apenas exibe os comandos e explicações no navegador
// para facilitar o aprendizado e a consulta.
echo "<hr>";
echo "<h2>🧠 INSTRUÇÕES DE USO E COMANDOS SQL</h2>";
echo "<pre style='background:#111;color:#0f0;padding:15px;border-radius:10px;'>";
echo htmlspecialchars($sql_explicativo);
echo "</pre>";

// ==========================================================
// 📋 RESUMO FINAL
// ==========================================================
// 1️⃣ Abra o XAMPP e inicie o Apache + MySQL.
// 2️⃣ Acesse http://localhost/phpmyadmin.
// 3️⃣ Crie o banco chamado 'dino-db2'.
// 4️⃣ Copie e execute os comandos SQL acima.
// 5️⃣ Teste a conexão abrindo este arquivo no navegador:
//     👉 http://localhost/Sapient-Dino/banco_explicado.php
// 6️⃣ Se aparecer "✅ Conexão bem-sucedida", tudo está certo!
// ==========================================================
?>
