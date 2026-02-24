<?php
include "includes/header.php";
?>

<body class="pe">
  <div class="main-login">
    <div class="right-login">
      <div class="card-cadastro">
        <h1>CADASTRO <a href="login.php"><i class="bi bi-door-open-fill lo"></i></a></h1>
        <form action="" id="registrationForm" method="post" enctype="multipart/form-data">
          <div class="textfield">
            <label for="nome">Nome</label>
            <input type="text" id="name" name="nome" placeholder="Nome">
            <div class="error" id="nameError"></div>
          </div>
          <div class="textfield">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail">
            <div class="error" id="emailError"></div>
          </div>
          <div class="textfield">
            <label for="tel">Telefone</label>
            <input type="text" id="phone" name="tel" placeholder="Digite seu telefone (XX) XXXXX-XXXX">
            <div class="error" id="phoneError"></div>
          </div>
          <div class="textfield">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF XXX.XXX.XXX-XX">
            <div class="error" id="cpfError"></div>
          </div>
          <div class="textfield">
            <label for="nascimento">Data de nascimento</label>
            <input type="date" id="nascimento" name="nascimento">
            <div class="error" id="dobError"></div>
          </div>
          <div class="textfield">
            <label for="foto">Foto de perfil</label>
            <input type="file" id="foto" name="foto">
            <div class="error" id="fotoError"></div>
          </div>
          <div class="textfield">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Senha">
            </button>
            <div class="error" id="senhaError"></div>
          </div>
          <button type="submit" class="btn-login b" id="btnEnviar">Cadastrar</button>
        </form>

        <script src="js/adicionarUsuario.js"></script>

        <div id="modalDetalhes" class="modalS">
          <div class="modalS-content">
            <h2>Bem-vindo, usuário cadastrado com sucesso!</h2>
            <div class="modalS-progress-bar"></div>
          </div>
        </div>

        <div id="modalDetalhes1" class="modalH">
          <div class="modalH-content">
            <h2>Usuário já cadastrado com este e-mail!</h2>
            <div class="modalH-progress-bar"></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>

<?php
include "includes/footer.php";
?>