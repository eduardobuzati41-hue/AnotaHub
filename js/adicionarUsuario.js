const baseUrl = window.location.origin + '/ws/';

function validaNome(n) {
    let erroNome = document.getElementById("nameError");
    if (n.trim() === "") {
        erroNome.textContent = "É necessário escrever o nome";
        return false;
    }
    erroNome.textContent = "";
    return true;
}

function validaFoto(foto) {
    let erroFoto = document.getElementById("fotoError");
    if (foto.trim() === "") {
        erroFoto.textContent = "É necessário inserir uma foto";
        return false;
    }
    erroFoto.textContent = "";
    return true;
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

    let temMaiuscula = [...s].some(ch => ch >= 'A' && ch <= 'Z');
    if (!temMaiuscula) {
        erroSenha.textContent = "Sua senha deve ter pelo menos 1 letra maiúscula";
        return false;
    }

    let temEspecial = [...s].some(ch => especiais.includes(ch));
    if (!temEspecial) {
        erroSenha.textContent = "Sua senha deve ter pelo menos 1 caractere especial";
        return false;
    }

    erroSenha.textContent = "";
    return true;
}

function validaEmail(em) {
    let erroEmail = document.getElementById("emailError");

    if (em.trim() === "") {
        erroEmail.textContent = "O e-mail não pode ser vazio";
        return false;
    }

    if (!em.includes("@")) {
        erroEmail.textContent = "Digite um formato válido para o e-mail";
        return false;
    }

    let partes = em.split("@");
    if (partes[0].length === 0 || partes[1].length === 0) {
        erroEmail.textContent = "Digite um e-mail válido antes e após o @";
        return false;
    }

    if (!partes[1].includes(".")) {
        erroEmail.textContent = "Digite um domínio válido";
        return false;
    }

    erroEmail.textContent = "";
    return true;
}

function validaTelefone(tel) {
    let erroPhone = document.getElementById("phoneError");

    if (tel.trim() === "") {
        erroPhone.textContent = "O telefone deve ser preenchido";
        return false;
    }

    if (tel.length !== 15) {
        erroPhone.textContent = "O telefone deve ter 15 caracteres";
        return false;
    }

    if (tel[0] !== '(' || tel[3] !== ')') {
        erroPhone.textContent = "O DDD deve estar entre parênteses";
        return false;
    }

    if (tel[10] !== '-') {
        erroPhone.textContent = "O telefone deve conter um hífen entre o 5º e 6º dígito";
        return false;
    }

    const ddd = tel.substring(1, 3);
    const num1 = tel.substring(5, 10);
    const num2 = tel.substring(11);

    if (isNaN(ddd) || isNaN(num1) || isNaN(num2)) {
        erroPhone.textContent = "Apenas números devem ser digitados";
        return false;
    }

    erroPhone.textContent = "";
    return true;
}

function validaDataNasc(d) {
    let erroData = document.getElementById("dobError");

    if (d.trim() === "") {
        erroData.textContent = "A data de nascimento não pode estar vazia";
        return false;
    }

    let partes = d.split("-");
    if (partes.length !== 3) {
        erroData.textContent = "O formato da data deve ser YYYY-MM-DD";
        return false;
    }

    erroData.textContent = "";
    return true;
}

function validaCpf(cpf) {
    let erroCpf = document.getElementById("cpfError");

    if (cpf.trim() === "") {
        erroCpf.textContent = "O cpf deve ser preenchido";
        return false;
    }

    if (cpf.length !== 14) {
        erroCpf.textContent = "O cpf deve conter 14 caracteres";
        return false;
    }

    if (cpf[3] !== '.' || cpf[7] !== '.' || cpf[11] !== '-') {
        erroCpf.textContent = "O cpf deve estar no formato XXX.XXX.XXX-XX";
        return false;
    }

    let numeros = cpf.replace(/\D/g, "");
    if (isNaN(numeros)) {
        erroCpf.textContent = "Apenas números devem ser digitados";
        return false;
    }

    erroCpf.textContent = "";
    return true;
}

document.getElementById("phone").addEventListener("input", function () {
    let tel = this.value.replace(/\D/g, "").substring(0, 11);

    let f = "";
    if (tel.length > 0) f = "(" + tel.substring(0, 2);
    if (tel.length > 2) f += ") " + tel.substring(2, 7);
    if (tel.length > 7) f += "-" + tel.substring(7);

    this.value = f;
});

document.getElementById("cpf").addEventListener("input", function () {
    let cpf = this.value.replace(/\D/g, "").substring(0, 11);

    let f = "";
    if (cpf.length > 0) f = cpf.substring(0, 3);
    if (cpf.length > 3) f += "." + cpf.substring(3, 6);
    if (cpf.length > 6) f += "." + cpf.substring(6, 9);
    if (cpf.length > 9) f += "-" + cpf.substring(9);

    this.value = f;
});

document.getElementById("btnEnviar").addEventListener("click", function (e) {
    e.preventDefault();

    const nome = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const tel = document.getElementById("phone").value;
    const cpf = document.getElementById("cpf").value;
    const foto = document.getElementById("foto").value;
    const dob = document.getElementById("nascimento").value;
    const senha = document.getElementById("senha").value;

    const NomeValido = validaNome(nome);
    const EmailValido = validaEmail(email);
    const TelefoneValido = validaTelefone(tel);
    const cpfValido = validaCpf(cpf);
    const fotoValida = validaFoto(foto);
    const DataValida = validaDataNasc(dob);
    const senhaValida = validaSenha(senha);

    if (!(NomeValido && EmailValido && TelefoneValido && DataValida && cpfValido && fotoValida && senhaValida)) {
        return; 
    }

    const form = document.getElementById("registrationForm");
    const formData = new FormData(form);

    fetch(baseUrl + "wsAdicionarUsuario.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            let modalSucesso = document.getElementById("modalDetalhes");
            let modalErro = document.getElementById("modalDetalhes1");

            if (data.sucess) {
                modalSucesso.style.display = "block";

                setTimeout(() => {
                    modalSucesso.style.display = "none";
                    window.location.href = "./login.php";
                }, 1000);

            } else {
                modalErro.style.display = "block";
                setTimeout(() => {
                    modalErro.style.display = "none";
                }, 4000);
            }
        })
        .catch(err => console.log(err));
});
