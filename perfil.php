<?php
if (!(isset($_COOKIE["token"]))) {
  header("Location: login.php");
  exit();
}
include "includes/header.php";
?>

<body class="pe">
  <main>

    <?php
    $con = conectar();
    $usuario = SelecionarUsuarioPorId($con, $usuarioToken['id_usuario']);
    ?>

    <div class="perfil scroll-reveal">
      <h1 class="h1perfil">Olá, <?= $usuario["nome"] ?>!</h1>
      <img class=" rounded-circle mx-auto d-block" width="250px" height="250px" src="<?= $usuario["foto"] ?>"
        alt="<?= $usuario["foto"] ?>">
      <div class="perfil2 scroll-reveal">
        <p>Nome: <?= $usuario["nome"] ?></p>
        <p>Email: <?= $usuario["email"] ?></p>
        <p>Cpf: <?= $usuario["cpf"] ?></p>
        <p>Telefone: <?= $usuario["tel"] ?></p>
        <p>Data de nascimento: <?= $usuario["nascimento"] ?></p>
        <input type="hidden" id="usuario_id" name="usuario_id" value="<?= $usuarioToken['id_usuario'] ?>">
        <button type="submit" class="btn btn-success" id="btnEnviar"><i class="bi bi-pencil-square"></i></button>
        <button type="button" class="btn btn-danger" id="Excluir"><i class="bi bi-trash"></i></button>
        <button type="button" class="btn senha" id="btnEnviar2">Alterar senha</button>
      </div>
    </div>

    <div id="modalDetalhes" class="modal">
      <div class="modal-content modal-shadow">
        <span class="close" data-modal-id="modalDetalhes">&times;</span>
        <h2>Editar</h2>
        <p id="modalDescription"></p>
        <form id="formEditar" method="post" enctype="multipart/form-data">
          <div class="textfield">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Nome" value="<?= $usuario['nome'] ?>">
            <div class="error" id="nameError"></div>
          </div>
          <div class="textfield">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail"
              value="<?= $usuario['email'] ?>">
            <div class="error" id="emailError"></div>
          </div>
          <div class="textfield">
            <label for="tel">Telefone</label>
            <input type="text" id="phone" name="tel" placeholder="Digite seu telefone (XX) XXXXX-XXXX"
              value="<?= $usuario['tel'] ?>">
            <div class="error" id="phoneError"></div>
          </div>
          <div class="textfield">
            <label for="cpf">Cpf</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF XXX.XXX.XXX-XX"
              value="<?= $usuario['cpf'] ?>">
            <div class="error" id="cpfError"></div>
          </div>
          <div class="textfield">
            <label for="nascimento">Data de nascimento</label>
            <input type="date" id="nascimento" name="nascimento" value="<?= $usuario['nascimento'] ?>">
            <div class="error" id="dobError"></div>
          </div>
          <div class="textfield">
            <label for="foto">Foto de perfil</label>
            <input type="file" id="foto" name="foto">
            <div class="error" id="fotoError"></div>
          </div>
          <br>
          <button type="submit" class="bd" id="Atualizar">Enviar</button>
        </form>
      </div>
    </div>


    <div id="modalDetalhes2" class="modal">
      <div class="modal-content modal-shadow">
        <span class="close5" data-modal-id="modalDetalhes2">&times;</span>
        <h2>Editar Senha</h2>
        <p id="modalDescription"></p>
        <form id="formEditarSenha" method="post" enctype="multipart/form-data">
          <div class="textfield">
            <label for="senha">Senha atual</label>
            <input type="password" id="senha" name="senha" placeholder="senha">
            <div class="error" id="senhaAtualError"></div>
          </div>
          <div class="textfield">
            <label for="senha">Senha nova</label>
            <input type="password" id="senhanova" name="senhanova" placeholder="senha nova">
            <div class="error" id="senhaNovaError"></div>
          </div>
          <br>
          <button type="submit" class="bd" id="AtualizarSenha">Enviar</button>
        </form>
      </div>
    </div>

    <div id="modalC" class="modalS">
      <div class="modalS-content">
        <h2>Usuário atualizado com sucesso!</h2>
        <div class="modalS-progress-bar"></div>
      </div>
    </div>

    <div id="modalK" class="modalS">
      <div class="modalS-content">
        <h2>Usuário atualizado com sucesso!</h2>
        <div class="modalS-progress-bar"></div>
      </div>
    </div>

    <div id="modalL" class="modalS">
      <div class="modalS-content">
        <h2>Sua senha antiga está incorreta!</h2>
        <div class="modalS-progress-bar"></div>
      </div>
    </div>


    <div id="modalE" class="modalE">
      <div class="modalL-content">
        <h2>Tem certeza que deseja remover sua conta?</h2>
        <button type="button" class="btn btn-danger b1" id="remover">Sim</i></button>
        <button type="button" class="btn btn-success b2" id="manter">Não</i></button>
      </div>
    </div>
  </main>
</body>

<script src="./js/editarUsuario.js"></script>
<script src="./js/scroll.js"></script>

<?php
include "includes/footer.php";
?>