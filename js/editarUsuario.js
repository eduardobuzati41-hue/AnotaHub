const baseUrl = "http://localhost/tcc_smart/ws/"

document.getElementById("btnEnviar").addEventListener("click", function (e) {
    document.getElementById("modalDetalhes").style.display = "block";
    e.preventDefault();
});

document.getElementById("btnEnviar2").addEventListener("click", function (e) {
    document.getElementById("modalDetalhes2").style.display = "block";
    e.preventDefault();
});


document.getElementById("Excluir").addEventListener("click", function (e) {
    document.getElementById("modalE").style.display = "block";

    remover.addEventListener("click", function(e) {
        e.preventDefault();

        const usuarioId = document.getElementById("usuario_id").value;
        
        let formData = new FormData();
        formData.append("id", usuarioId);  

        fetch(baseUrl + "wsExcluirUsuario.php", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Resposta ao excluir:", data);
            window.location.href = "login.php";
            document.getElementById("modalE").style.display = "none";  
        })
        .catch(error => {
            console.error("Erro ao excluir:", error);
        });
    });

     manter.addEventListener("click", function(e) {
        document.getElementById("modalE").style.display = "none"; 
     });

    e.preventDefault();
});

document.getElementById("Atualizar").addEventListener("click", function (e) {
    e.preventDefault();

    const usuarioId = document.getElementById("usuario_id").value;
    const inputNome = document.getElementById("nome");
    const inputEmail = document.getElementById("email");
    const inputNasc = document.getElementById("nascimento");
    const inputCpf = document.getElementById("cpf");
    const inputTel = document.getElementById("phone");
    const inputFoto = document.getElementById("foto");

    const NomeValido = validaNome(inputNome.value);
    const EmailValido = validaEmail(inputEmail.value);
    const TelefoneValido = validaTelefone(inputTel.value);
    const cpfValido = validaCpf(inputCpf.value);
    const fotoValida = validaFoto(inputFoto.value);
    const DataValida = validaDataNasc(inputNasc.value);

    if (!(NomeValido && EmailValido && TelefoneValido && DataValida && cpfValido && fotoValida)) {
        return; 
    }

    let formData = new FormData();
    formData.append("id", usuarioId); 
    formData.append("nome", inputNome.value);
    formData.append("email", inputEmail.value);
    formData.append("tel", inputTel.value);
    formData.append("nascimento", inputNasc.value);
    formData.append("cpf", inputCpf.value);
    
    if (inputFoto.files.length > 0) {
        formData.append("foto", inputFoto.files[0]);
    }

    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    fetch(baseUrl + "wsAtualizarUsuario.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Resposta ao atualizar:", data);
        document.getElementById("modalC").style.display = "block";

            document.getElementById("nome").value = "";

            setTimeout(() => {
                document.getElementById("modalC").style.display = "none";
                location.reload();
            }, 1000);

        document.getElementById("modalDetalhes").style.display = "none";
    })
    .catch(error => {
        console.error("Erro ao atualizar:", error);
    });
});

const fechar = document.querySelector(".close");
fechar.addEventListener("click", function () {
    document.getElementById("modalDetalhes").style.display = "none";
});

const modal = document.getElementById("modalDetalhes");
modal.addEventListener("click", function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

document.getElementById("AtualizarSenha").addEventListener("click", function (e) {
    e.preventDefault();

    const usuarioId = document.getElementById("usuario_id").value;
    const inputsenha = document.getElementById("senha");
    const inputsenha2 = document.getElementById("senhanova");

    const senhaAntigavalida = validaSenhaAntiga(inputsenha.value);
    const senhaValida = validaSenhaNova(inputsenha2.value);
    
    if (!(senhaAntigavalida && senhaValida)) {
        return; 
    }

    let formData = new FormData();
    formData.append("id", usuarioId); 
    formData.append("senha", inputsenha.value);
    formData.append("senhanova", inputsenha2.value);

    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    fetch(baseUrl + "wsAtualizarSenha.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success){
        document.getElementById("modalK").style.display = "block";

            setTimeout(() => {
                document.getElementById("modalK").style.display = "none";
                location.reload();
            }, 1000);

            document.getElementById("modalDetalhes2").style.display = "none";
        }
        else {
            document.getElementById("modalL").style.display = "block";

            setTimeout(() => {
                document.getElementById("modalL").style.display = "none";
                location.reload();
            }, 2000);

            document.getElementById("modalDetalhes2").style.display = "none";

        }
    })
    .catch(error => {
        console.error("Erro ao atualizar:", error);
    });
});

const fechar2 = document.querySelector(".close5");
fechar2.addEventListener("click", function () {
    document.getElementById("modalDetalhes2").style.display = "none";
});

const modal2 = document.getElementById("modalDetalhes2");
modal2.addEventListener("click", function (event) {
    if (event.target === modal2) {
        modal2.style.display = "none";
    }
});


function validaNome(n){
    let erroNome = document.getElementById("nameError");
    if(n.trim() === ""){
       erroNome.textContent = "É necessário escrever o nome";
       return false;
   }

   erroNome.textContent = "";
   return true;
}

function validaFoto(foto){
    let erroFoto = document.getElementById("fotoError");
    if(foto.trim() === ""){
       erroFoto.textContent = "É necessário inserir uma foto";
       return false;
   }

   erroFoto.textContent = "";
   return true;
}

function validaEmail(em){
   let erroEmail = document.getElementById("emailError");

   if(!(em.trim() === "")){
       if(em.includes('@')){
           let chkEmail = em.split('@');
           if(chkEmail[0].length === 0 || chkEmail[1].length === 0){
               erroEmail.textContent = "Digite um e-mail válido antes e após o @";
               return false;
           }else{
               let chkDomainEmail = chkEmail[1].split('.');
               if(chkDomainEmail.length < 2){
                   erroEmail.textContent = "Digite um domínio válido";
                   return false;
               }
           }
       }else{
           erroEmail.textContent = "Digite um formato válido para o e-mail";
           return false;
       }
   }else{
       erroEmail.textContent = "O e-mail não pode ser vazio";
       return false;
   }

   erroEmail.textContent = "";
   return true;
}


function validaTelefone(tel){
   let erroPhone = document.getElementById("phoneError");

   if(tel.trim()==""){
       erroPhone.textContent = "O telefone deve ser preenchido";
       return false;
   }

   if(tel.length !== 15){
       erroPhone.textContent = "O telefone ter 15 caracteres contando o espaço";
       return false;
   }

   if(tel[0] !== '(' && tel[3] !== ')'){
       erroPhone.textContent = "O DDD deve estar entre parenteses";
       return false;
   }

   if(tel[10] !== '-'){
       erroPhone.textContent = "O telefone deve conter um hífen entre o 5º e 6º dígito";
       return false;
   }

   const ddd = tel.substring(1,3);
   const num = tel.substring(5,10)
   const num2 = tel.substring(11);

   if(isNaN(ddd) || isNaN(num) || isNaN(num2)){
       erroPhone.textContent = "Apenas números devem ser digitados";
       return false;
   }

   erroPhone.textContent = "";
   return true;
}


function validaDataNasc(d){
   let erroDataNasc = document.getElementById("dobError");

   if(d.trim() === ""){
       erroDataNasc.textContent = "A data de nascimento não pode estar vazia";

       return false;
   }

   const partesData = d.split("-");

   if(partesData.length !== 3){
       erroDataNasc.textContent = "O formato da data deve ser DD-MM-YYYY";
       return false;
   }

   const dia = partesData[2];
   const mes = partesData[1];
   const ano = partesData[0];

   if(isNaN(dia) || isNaN(mes) || isNaN(ano)){
       erroDataNasc.textContent = "A data deve conter apenas números no formato DD-MM-YYYY";
       return false;
   }



   erroDataNasc.textContent ="";
   return true;
}

const phoneInput = document.getElementById("phone");

phoneInput.addEventListener("input", function () {
    let tel = this.value.replace(/\D/g, "");
    if (tel.length > 11) tel = tel.substring(0, 11); 

    let telFormatado = "";
    if (tel.length > 0) telFormatado = "(" + tel.substring(0, 2);
    if (tel.length > 2) telFormatado += ") " + tel.substring(2, 7);
    if (tel.length > 7) telFormatado += "-" + tel.substring(7, 11);

    this.value = telFormatado;
});

function validaCpf(cpf){
    let erroCpf = document.getElementById("cpfError");
 
    if(cpf.trim()==""){
        erroCpf.textContent = "O cpf deve ser preenchido";
        return false;
    }
 
    if(cpf.length !== 14){
        erroCpf.textContent = "O cpf deve conter no máximo 14 caracteres";
        return false;
    }
 
    if(cpf[3] !== '.' && cpf[7] !== '.'  && cpf[11] !== '-'){
        erroCpf.textContent = "O cpf deve estar no formato XXX.XXX.XXX-XX";
        return false;
    }
 
    const num = cpf.substring(1,3);
    const num2 = cpf.substring(5,7)
    const num3 = cpf.substring(9,11);
    const num4 = cpf.substring(13,14);
 
    if(isNaN(num) || isNaN(num2) || isNaN(num3) || isNaN(num4)){
        erroCpf.textContent = "Apenas números devem ser digitados";
        return false;
    }
 
    erroCpf.textContent = "";
    return true;
 }
 
document.getElementById("cpf").addEventListener("input", function () {
    let cpf = this.value.replace(/\D/g, "");
    if (cpf.length > 11) cpf = cpf.substring(0, 11);

    let cpfFormatado = "";
    if (cpf.length > 0) cpfFormatado = cpf.substring(0, 3);
    if (cpf.length > 3) cpfFormatado += "." + cpf.substring(3, 6);
    if (cpf.length > 6) cpfFormatado += "." + cpf.substring(6, 9);
    if (cpf.length > 9) cpfFormatado += "-" + cpf.substring(9, 11);

    this.value = cpfFormatado;
});


function validaSenhaAntiga(s){
    let erroSenha = document.getElementById("senhaAtualError");
    const especiais = "!@#$%^&*(),.?\":{}|<>";

    if(s.trim() === ""){
       erroSenha.textContent = "É necessário escrever a senha";
       return false;
   }

   if(s.length < 8){
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

function validaSenhaNova(s){
    let erroSenha = document.getElementById("senhaNovaError");
    const especiais = "!@#$%^&*(),.?\":{}|<>";

    if(s.trim() === ""){
       erroSenha.textContent = "É necessário escrever a senha";
       return false;
   }

   if(s.length < 8){
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