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
        <h1>Explore com o Dino</h1>
        <p>Faça perguntas e veja o conhecimento evoluir</p>
      </header>
      <div class="camp-mensagens" id="chat">
        <!-- mensagens aparecerão aqui -->
      </div>

      <!-- camp-inputChat -->
      <div class="camp-inputChat">
        <input type="text" class="inputChat" id="mensagem" placeholder="DIGITE SUA PERGUNTA:">
        <button class="camp-iconeEnvioChat" title="Enviar">
          <!-- icone enviado (pode manter seu SVG) -->
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 29 29" fill="none">
            <path d="M28.2137 0.317338C28.7858 0.713741 29.086 1.39895 28.9784 2.08416L25.3533 25.6418C25.2684 26.1911 24.9342 26.6724 24.4471 26.9442C23.9599 27.2161 23.3765 27.25 22.8611 27.0348L16.0868 24.2204L12.2068 28.4166C11.7027 28.9659 10.9097 29.1471 10.2131 28.8753C9.51636 28.6035 9.06323 27.9296 9.06323 27.1821V22.4479C9.06323 22.2214 9.14819 22.0062 9.30112 21.8363L18.7942 11.4846C19.1228 11.1278 19.1114 10.5785 18.7716 10.2387C18.4317 9.89895 17.8823 9.8763 17.5255 10.1991L6.00459 20.4319L1.00314 17.9289C0.402745 17.6288 0.0175824 17.0285 0.000589952 16.3603C-0.0164025 15.6921 0.334775 15.0692 0.912518 14.7351L26.2879 0.238058C26.894 -0.107378 27.6416 -0.073401 28.2137 0.317338Z" fill="white" />
          </svg>
        </button>
      </div>
      <!-- FIM camp-inputChat -->
    </main>
  </div>
  <script src="script.js"></script>
  <script>
    const chat = document.getElementById('chat');
    const input = document.getElementById('mensagem');
    const botaoEnviar = document.querySelector('.camp-iconeEnvioChat');

    // função para adicionar mensagens no chat
    function adicionarMensagem(texto, tipo) {
      const msg = document.createElement('div');
      msg.classList.add('mensagem', tipo === 'usuario' ? 'msg-usuario' : 'msg-bot');
      msg.textContent = texto;
      chat.appendChild(msg);
      chat.scrollTop = chat.scrollHeight;
      return msg;
    }

    // função principal de envio
    async function enviarMensagem() {
      const texto = input.value.trim();
      if (texto === '') return;

      adicionarMensagem(texto, 'usuario');
      input.value = '';

      const pensando = adicionarMensagem('Pensando...', 'bot');

      try {
        const resposta = await fetch('api.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            message: texto
          })
        });

        const dados = await resposta.json();
        pensando.remove();

        if (dados.success && dados.reply) {
          adicionarMensagem(dados.reply, 'bot');
        } else {
          adicionarMensagem('Ocorreu um erro ao obter resposta.', 'bot');
        }

      } catch (erro) {
        pensando.remove();
        adicionarMensagem('Erro ao conectar com o servidor.', 'bot');
        console.error('Erro:', erro);
      }
    }

    // eventos: clique no botão e pressionar Enter
    botaoEnviar.addEventListener('click', enviarMensagem);
    input.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') enviarMensagem();
    });
  </script>
</body>

</html>