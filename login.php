<?php
include "includes/header.php";
?>

<body class="pe">
  <div class="main-login">
    <div class="right-login">
      <div class="card-login">
        <h1>LOGIN</h1>

        <form action="proc/procLogin.php" id="registrationForm" method="post">
          <div class="textfield">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="Usuário">
            <div class="error" id="emailError"></div>
          </div>
          <div class="textfield">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" placeholder="Senha">
            <div class="error" id="senhaError"></div>
          </div>
          <?php if (isset($_GET['erro'])): ?>
            <div style="color: red; margin-bottom: 10px;">
              <?php echo ($_GET['erro']); ?>
            </div>
          <?php endif; ?>
          <button type="submit" class="btn-login b">Login</button>
        </form>
        <script src="./js/validaLogin.js"></script>
      </div>
    </div>
  </div>
</body>

<?php
include "includes/footer.php";
?>