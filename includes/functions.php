<?php

function conectar()
{
    $servidor = "sql213.infinityfree.com";
    $usuario = "if0_41240169";
    $senha = "fLTHEyEcGxpojf8";
    $bd = "if0_41240169_anotahub";

    $conexao = mysqli_connect($servidor, $usuario, $senha, $bd);

    if (!$conexao) {
        die("Erro ao conectar no banco de dados " . mysqli_connect_error());
    }

    mysqli_set_charset($conexao, "utf8");

    return $conexao;
}


function desconectar($conexao)
{
    if (isset($conexao)) {
        mysqli_close($conexao);
        return true;
    } else {
        return false;
    }
}

function adicionarUsuario($conexao, $nome, $email, $tel, $cpf, $nascimento, $senha)
{
    $sql = "Insert into usuarios(nome, email, tel, cpf, nascimento,senha) values (?, ?, ?, ?, ?, ?)";

    $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "ssssss", $nome, $email, $tel, $cpf, $nascimento, $senhaCripto);

    $result = mysqli_stmt_execute($stmt);

    return $result ? mysqli_insert_id($conexao) : false;
}

function fotoUsuario($conexao, $foto, $id)
{
    $sql = "update usuarios set foto = ? where id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "si", $foto, $id);

    $resultado = mysqli_stmt_execute($stmt);

    return $resultado;
}

function validaLogin($conexao, $email, $senha)
{
    $usuario = false;

    $sql = "select id, nome, email, senha from usuarios where email = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario["id"] == 1) {
            $senhaHash = hash('sha256', $senha);
            if (!hash_equals($senhaHash, $usuario["senha"])) {
                $usuario = false;
            } else {
                unset($usuario["senha"]);
            }
        } else {
            if (!password_verify($senha, $usuario["senha"])) {
                $usuario = false;
            } else {
                unset($usuario["senha"]);
            }
        }
    } else {
        $usuario = false;
    }

    return $usuario;
}

function editarSenhaUsuario($conexao, $id, $senhaAtual, $senhaNova)
{
    $sql = "SELECT senha FROM usuarios WHERE id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        if (password_verify($senhaAtual, $usuario["senha"])) {

            $senhaCripto = password_hash($senhaNova, PASSWORD_DEFAULT);

            $sqlUpdate = "UPDATE usuarios SET senha = ? WHERE id = ?";

            $stmtUpdate = mysqli_prepare($conexao, $sqlUpdate);

            mysqli_stmt_bind_param($stmtUpdate, "si", $senhaCripto, $id);

            return mysqli_stmt_execute($stmtUpdate);
        } else {
            return false;
        }
    }

    return false;
}


function gerarToken($conexao, $usuario)
{
    $bytes = random_bytes(16);
    $token = bin2hex($bytes);

    $validade = date('Y-m-d H:i:s', strtotime('+10 days'));

    $sql = "Insert into usuario_token(id_usuario, token, data_expiracao) values (?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "iss", $usuario["id"], $token, $validade);

    $result = mysqli_stmt_execute($stmt);

    return $result ? $token : false;
}

function buscarComentario($conexao)
{
    $sql = "select id, usuario_id, nome, comentario, data_publicada FROM sugestoes WHERE id_pai IS NULL ORDER BY data_publicada DESC";

    $comentarios = array();

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $comentarios[] = $linha;
        }
    }

    return $comentarios;
}

function buscarComentarioAdm($conexao)
{
    $sql = "select * from sugestoes where id_pai is not null order by data_publicada desc";

    $comentarios = array();

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $comentarios[] = $linha;
        }
    }

    return $comentarios;
}

function temRespostaAdmin($conexao, $idComentarioUsuario)
{
    $sql = "select COUNT(*) as total from sugestoes where id_pai = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $idComentarioUsuario);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $linha = mysqli_fetch_assoc($resultado);

    return $linha['total'] > 0;
}



function buscarTokenPorUsuario($conexao, $token)
{

    $sql = "select t.id_usuario, t.data_expiracao, u.nome from usuario_token t join usuarios u on t.id_usuario = u.id where token = ?";

    $usuarioToken = false;

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "s", $token);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado) {
        $usuarioToken = mysqli_fetch_assoc($resultado);
    }

    return $usuarioToken;
}

function atualizarConcluido($conexao, $id, $usuario_id, $concluido)
{
    $sql = "update agenda set concluido = ? where id = ? and usuario_id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "iii", $concluido, $id, $usuario_id);

    return mysqli_stmt_execute($stmt);
}

function atualizarFavorito($conexao, $caderno_id, $usuario_id, $favoritar)
{
    $sql = "update caderno set favoritar = ? where id = ? and usuario_id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "iii", $favoritar, $caderno_id, $usuario_id);

    return mysqli_stmt_execute($stmt);
}

function ocultar($conexao, $caderno_id, $usuario_id, $ocultar)
{
    $sql = "update caderno set ocultar = ? where id = ? and usuario_id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "iii", $ocultar, $caderno_id, $usuario_id);

    return mysqli_stmt_execute($stmt);
}


function adicionarNota($conexao, $usuario_id, $descricao, $data_publicada, $hora_publicada)
{
    $sql = "Insert into agenda(usuario_id,descricao,data_publicada,hora_publicada) values (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "isss", $usuario_id, $descricao, $data_publicada, $hora_publicada);

    $result = mysqli_stmt_execute($stmt);

    return $result ? mysqli_insert_id($conexao) : false;
}

function adicionarComentario($conexao, $usuario_id, $nome, $comentario, $data, $id_pai = NULL)
{
    $sql = "insert into sugestoes (usuario_id, nome, comentario, data_publicada, id_pai) values (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "isssi", $usuario_id, $nome, $comentario, $data, $id_pai);

    $result = mysqli_stmt_execute($stmt);

    return $result ? mysqli_insert_id($conexao) : false;
}

function adicionarVideo($conexao, $usuario_id, $caderno_id, $descricao, $link)
{
    $sql = "Insert into videos(usuario_id,caderno_id,descricao,link) values (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "iiss", $usuario_id, $caderno_id, $descricao, $link);

    $result = mysqli_stmt_execute($stmt);

    return $result ? mysqli_insert_id($conexao) : false;
}

function adicionarCaderno($conexao, $usuario_id, $nome, $cor)
{
    $sql = "Insert into caderno(usuario_id,nome,cor) values (?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "iss", $usuario_id, $nome, $cor);

    $result = mysqli_stmt_execute($stmt);

    return $result ? mysqli_insert_id($conexao) : false;
}


function SelecionarUsuarioPorId($conexao, $id)
{
    $sql = "select id,nome,email,cpf,tel,nascimento,senha,foto from usuarios where id = ?";

    $usuario = array();

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
    }

    return $usuario;
}

function verificarEmailExistente($conexao, $email)
{
    $sql = "select id from usuarios where email = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($resultado) > 0;
}

function atualizarUltimoAcesso($conexao, $caderno_id)
{
    $sql = "UPDATE caderno SET ultimo_acesso = NOW() WHERE id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $caderno_id);

    mysqli_stmt_execute($stmt);
}

function obterUltimoCadernoAcessado($conexao, $usuario_id)
{
    $sql = "select id, usuario_id, nome, conteudo, cor from caderno where usuario_id = ? order by ultimo_acesso DESC LIMIT 1";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $usuario_id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $caderno = null;
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $caderno = mysqli_fetch_assoc($resultado);
    }

    return $caderno;
}

function obterNotaPorUsuario($conexao, $usuario_id): array
{
    $sql = " select id, usuario_id, descricao, data_publicada, hora_publicada, concluido from agenda where usuario_id = ? order by TIMESTAMP(data_publicada, hora_publicada) >= NOW() desc, ABS(TIMESTAMPDIFF(SECOND, TIMESTAMP(data_publicada, hora_publicada), NOW())) ASC";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $usuario_id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $notas = array();

    if (mysqli_num_rows($resultado) > 0) {
        while ($n = mysqli_fetch_assoc($resultado)) {
            $notas[] = $n;
        }
    }

    return $notas;
}


function obterCadernoPorUsuario($conexao, $usuario_id)
{
    $sql = "select id,usuario_id,nome,cor,favoritar,ocultar from caderno WHERE usuario_id = ? order by favoritar desc, id asc";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $usuario_id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $cadernos = array();

    if (mysqli_num_rows($resultado) > 0) {
        while ($n = mysqli_fetch_assoc($resultado)) {
            $cadernos[] = $n;
        }
    }

    return $cadernos;
}

function buscarVideo($conexao, $usuario_id, $caderno_id = null)
{
    $sql = "select id, usuario_id, caderno_id, descricao, link from videos WHERE usuario_id = ?";

    if ($caderno_id) {
        $sql .= " and caderno_id = ?";
    }

    $stmt = mysqli_prepare($conexao, $sql);

    if ($caderno_id) {
        mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $caderno_id);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    }

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $videos = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $videos[] = $row;
    }

    return $videos;
}

function obterCadernoComMaisConteudo($conexao, $usuario_id)
{
    $sql = "select id, usuario_id, nome, conteudo, cor, char_length(conteudo) as tamanho from caderno where usuario_id = ? order by tamanho desc limit 1";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $usuario_id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $cadernos = array();

    if (mysqli_num_rows($resultado) > 0) {
        while ($n = mysqli_fetch_assoc($resultado)) {
            $cadernos[] = $n;
        }
    }

    return $cadernos;
}


function obterCadernoPorId($conexao, $idCaderno, $usuario_id)
{
    $sql = "select id,usuario_id,nome,conteudo from caderno WHERE id = ? AND usuario_id = ?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "ii", $idCaderno, $usuario_id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $cadernos = array();

    if (mysqli_num_rows($resultado) > 0) {
        while ($n = mysqli_fetch_assoc($resultado)) {
            $cadernos[] = $n;
        }
    }

    return $cadernos;

}

function obterNotasDoDia($conexao, $usuario_id)
{
    $data_atual = date('Y-m-d');

    $sql = "select id,usuario_id,descricao,data_publicada,hora_publicada from agenda where usuario_id = ? and data_publicada = ? order by hora_publicada DESC";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "is", $usuario_id, $data_atual);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $notas = array();

    if (mysqli_num_rows($resultado) > 0) {
        while ($n = mysqli_fetch_assoc($resultado)) {
            $notas[] = $n;
        }
    }

    return $notas;
}

function excluirNota($conexao, $id)
{
    $sql = "delete from agenda where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    return $resultado;
}

function excluirComentario($conexao, $id)
{
    $sql = "delete from sugestoes where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    return $resultado;
}

function excluirVideo($conexao, $id)
{
    $sql = "delete from videos where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    return $resultado;
}


function excluirMateria($conexao, $id)
{
    $sql = "delete from caderno where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    return $resultado;
}


function editarMateria($conexao, $nome, $id, $cor)
{
    $sql = "update caderno set nome=?, cor=? where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, 'ssi', $nome, $cor, $id);

    $result = mysqli_stmt_execute($stmt);

    return $result;
}

function editarAgenda($conexao, $hora, $data, $descricao, $id)
{
    $sql = "update agenda set hora_publicada=?, data_publicada=?, descricao=? where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, 'sssi', $hora, $data, $descricao, $id);

    $result = mysqli_stmt_execute($stmt);

    return $result;
}

function editarConteudo($conexao, $conteudo, $id)
{
    $sql = "update caderno set conteudo=? where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, 'si', $conteudo, $id);

    $result = mysqli_stmt_execute($stmt);

    return $result;
}


function editarUsuario($conexao, $nome, $email, $tel, $cpf, $nascimento, $id)
{
    $sql = "update usuarios set nome=?, email=?, tel=?, cpf=?, nascimento=? where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, 'sssssi', $nome, $email, $tel, $cpf, $nascimento, $id);

    $result = mysqli_stmt_execute($stmt);

    return $result;
}

function excluirUsuario($conexao, $id)
{
    $sql = "delete from usuarios where id=?";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    return $resultado;
}

function selectAtividadesSemana($conexao, $usuarioId)
{
    $sql = "select DAYNAME(data_publicada) AS dia_semana, COUNT(*) AS quantidade FROM agenda WHERE usuario_id = ? AND YEARWEEK(STR_TO_DATE(data_publicada, '%Y-%m-%d'), 1) = YEARWEEK(CURDATE(), 1) GROUP BY dia_semana ORDER BY FIELD(dia_semana, 'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')";

    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $usuarioId);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    $dias = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];

    while ($linha = mysqli_fetch_assoc($resultado)) {
        $dias[$linha['dia_semana']] = (int) $linha['quantidade'];
    }

    return $dias;
}

?>