document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("registrationForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const email = document.getElementById("email").value;
        const senha = document.getElementById("password").value;

        const EmailValido = validaEmail(email);
        const senhaValida = validaSenha(senha);

        if (EmailValido && senhaValida) {
            this.submit();
        }
    });

    olho();
    
    function olho( ) {
        const passwordInput = document.getElementById("password");
        const toggleSenha = document.getElementById("toggleSenha");
        const icon = toggleSenha.querySelector("i");

        toggleSenha.addEventListener("click", () => {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        });
    }



    function validaSenha(s) {
        let erroSenha = document.getElementById("senhaError");
        const especiais = "!@#$%^&*(),.?\":{}|<>";

        if (s.trim() === "") {
            erroSenha.textContent = "É necessário escrever a senha";
            return false;
        }

        if (s.length < 8) {
            erroSenha.textContent = "Sua senha deve ter 8 ou mais caracteres";
            return false;
        }

        let temMaiuscula = false;
        for (let i = 0; i < s.length; i++) {
            if (s[i] >= 'A' && s[i] <= 'Z') {
                temMaiuscula = true;
                break;
            }
        }
        if (!temMaiuscula) {
            erroSenha.textContent = "Sua senha deve ter pelo menos 1 letra maiúscula";
            return false;
        }

        let temEspecial = false;
        for (let i = 0; i < s.length; i++) {
            if (especiais.includes(s[i])) {
                temEspecial = true;
                break;
            }
        }
        if (!temEspecial) {
            erroSenha.textContent = "Sua senha deve ter pelo menos 1 caractere especial";
            return false;
        }


        erroSenha.textContent = "";
        return true;
    }

    function validaEmail(em) {
        let erroEmail = document.getElementById("emailError");

        if (!(em.trim() === "")) {
            if (em.includes('@')) {
                let chkEmail = em.split('@');
                if (chkEmail[0].length === 0 || chkEmail[1].length === 0) {
                    erroEmail.textContent = "Digite um e-mail válido antes e após o @";
                    return false;
                } else {
                    let chkDomainEmail = chkEmail[1].split('.');
                    if (chkDomainEmail.length < 2) {
                        erroEmail.textContent = "Digite um domínio válido";
                        return false;
                    }
                }
            } else {
                erroEmail.textContent = "Digite um formato válido para o e-mail";
                return false;
            }
        } else {
            erroEmail.textContent = "O e-mail não pode ser vazio";
            return false;
        }

        erroEmail.textContent = "";
        return true;
    }

});