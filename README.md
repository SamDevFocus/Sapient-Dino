
# 🦕 SapientDino

Uma plataforma interativa de aprendizado alimentada por **Inteligência Artificial**, criada para transformar **curiosidade em conhecimento**.  
O SapientDino aprende com você — toda pergunta feita vira um item da biblioteca, permitindo revisitar respostas e expandir o entendimento com o tempo.

---

## 📚 Sobre o Projeto

O **SapientDino** é uma aplicação web onde o usuário pode:
- 💬 Fazer perguntas e obter explicações claras e objetivas, geradas pela **IA da OpenAI**  
- 💾 Armazenar automaticamente todas as respostas em um **banco de dados MySQL**  
- 🔍 Pesquisar rapidamente termos já aprendidos na **Biblioteca IA**  
- 📈 Visualizar informações como número total de palavras salvas e a última pesquisa feita  
- 💎 Navegar em uma interface moderna com estilo **Glassmorphism** e **design responsivo**

O objetivo é criar uma **enciclopédia pessoal inteligente**, construída a partir das suas próprias dúvidas.

---

## 🖼️ Interface do Projeto

Veja abaixo algumas telas do **SapientDino** em funcionamento:  

<div align="center">

| 🏠 Página Inicial | 📚 Biblioteca IA | 💬 Chat com a IA |
|------------------|------------------|------------------|
| <img src="home.png" width="280" alt="Home do SapientDino" style="border-radius:12px;box-shadow:0 0 10px rgba(0,0,0,0.3);"> | <img src="biblioteca.png" width="280" alt="Biblioteca IA" style="border-radius:12px;box-shadow:0 0 10px rgba(0,0,0,0.3);"> | <img src="chat.png" width="280" alt="Chat com IA" style="border-radius:12px;box-shadow:0 0 10px rgba(0,0,0,0.3);"> |

</div>

> 💡 As imagens acima representam a interface moderna com estilo **Glassmorphism**, projetada para ser intuitiva, leve e responsiva em qualquer dispositivo.

---

## 🛠️ Tecnologias Utilizadas

| Tipo | Ferramenta |
|------|-------------|
| **Frontend** | HTML5, CSS3, JavaScript |
| **Backend** | PHP (PDO, cURL) |
| **Banco de Dados** | MySQL |
| **API** | OpenAI GPT |
| **Design/UI** | Font Awesome, Google Fonts |
| **Estilo Visual** | Glassmorphism + Layout Responsivo |

---

## ⚙️ Requisitos do Sistema

- 🧩 **PHP** 7.4 ou superior  
- 🗃️ **MySQL** 5.7 ou superior  
- 🌐 **Servidor Apache** (recomendado: XAMPP ou WAMP)  
- 🔑 **Chave da API da OpenAI**  
- 💻 Navegador moderno (Chrome, Edge, Firefox)

---

## 🚀 Instalação e Configuração

### 1️⃣ Clonar o projeto
```bash
git clone https://github.com/seu-usuario/Sapient-Dino.git

### 2️⃣ Iniciar o servidor

Ative o **Apache** e o **MySQL** no **XAMPP Control Panel**.

### 3️⃣ Criar o banco de dados

Acesse [http://localhost/phpmyadmin](http://localhost/phpmyadmin) e execute:

```sql
CREATE DATABASE dino-db2;
USE dino-db2;

CREATE TABLE respostas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) UNIQUE,
    resposta TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4️⃣ Configurar a conexão com o banco (arquivo `api.php`)

```php
$host = 'localhost';
$db   = 'dino-db2';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';
```

> ⚠️ Se a senha do seu MySQL for diferente, altere a variável `$pass`.

### 5️⃣ Inserir dados iniciais (opcional)

Para povoar a biblioteca com exemplos:

```sql
INSERT INTO respostas (titulo, resposta) VALUES
("Resiliência", "Capacidade de se adaptar e se recuperar diante de dificuldades."),
("Empatia", "Habilidade de compreender e compartilhar os sentimentos de outras pessoas."),
("Persistência", "Ato de continuar tentando mesmo diante de obstáculos."),
("Autoconhecimento", "Compreensão de si mesmo — emoções, comportamentos e valores."),
("Disciplina", "Capacidade de manter o foco e seguir hábitos consistentes.");
```

### 6️⃣ Configurar a API da OpenAI

No arquivo `api.php`, substitua o valor de:

```php
$apiKey = 'SUA_CHAVE_DA_OPENAI_AQUI';
```

Você pode gerar uma nova chave em: [https://platform.openai.com/api-keys](https://platform.openai.com/api-keys)

---

## 🧩 Estrutura do Projeto

```
Sapient-Dino/
├── index.php              # Página inicial (estatísticas + boas-vindas)
├── chat.php               # Interface de interação com a IA
├── biblioteca.php         # Exibição e busca das palavras salvas
├── api.php                # Comunicação com a API da OpenAI
├── style.css / style2.css / style3.css   # Arquivos de estilo
├── script.js              # Scripts de interação frontend
├── sapient.png            # Logo principal
└── README.md              # Este arquivo
```

---

## 💡 Como Funciona

1. O usuário envia uma mensagem pelo **chat**
2. O **PHP** envia a requisição para a **API da OpenAI**
3. A resposta é exibida e **armazenada automaticamente** no banco
4. Em **consultas futuras**, o sistema busca a resposta no banco antes de chamar a IA (economizando tokens)
5. A **Biblioteca IA** mostra todas as palavras salvas com pesquisa e filtros

---

## 🧠 Recursos Planejados

* 🗂️ Categorização de palavras por tema
* 🌍 Tradução automática de termos
* 🧩 Sistema de login e perfis de usuário
* 📊 Estatísticas detalhadas de uso (gráficos e histórico)
* 🔔 Notificações sobre novos aprendizados

---

## 💬 Exemplo de Uso

* Você pergunta no chat:
  **"O que é entropia?"**

* O SapientDino responde:

  > “Entropia” é uma medida do grau de desordem ou aleatoriedade em um sistema físico.

* Essa resposta é **salva automaticamente** no banco e aparece na biblioteca para futuras consultas.

---

## 👨‍💻 Grupo

| Integrante | GitHub |
|-------------|---------|
| <img src="https://github.com/SamDevFocus.png" width="80" style="border-radius:50%"> <br> **Samuel C. De Souza** <br> 📍 Desenvolvedor e estudante de Análise e Desenvolvimento de Sistemas <br> 💬 Transformando curiosidade em conhecimento e desafios em conquistas. | [github.com/SamDevFocus](https://github.com/SamDevFocus) |
| <img src="https://github.com/Vini006dev.png" width="80" style="border-radius:50%"> <br> **Vinicius Araujo Alves** <br> 📍 Desenvolvedor e estudante de Análise e Desenvolvimento de Sistemas <br> 💬 Focado em evoluir como programador e transformar desafios em aprendizado constante. | [github.com/Vini006dev](https://github.com/Vini006dev) |
| <img src="https://github.com/NOME_USUARIO_AQUI.png" width="80" style="border-radius:50%"> <br> **Nome do Integrante** <br> 📍 Desenvolvedor e estudante de Análise e Desenvolvimento de Sistemas <br> 💬 Entusiasta em tecnologia, sempre buscando novas formas de inovar e colaborar em equipe. | [github.com/NOME_USUARIO_AQUI](https://github.com/NOME_USUARIO_AQUI) |

---

## 📜 Licença

Este projeto é de uso educacional e experimental.
Você pode estudar, modificar e expandir, desde que mantenha os créditos ao autor original.

---

> 🦖 *SapientDino — “Porque até os dinossauros podem evoluir.”*

