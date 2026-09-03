<?php
if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        http_response_code(403);
        die('Error de seguridad: Token CSRF inválido o expirado.');
    }

    $accion = $_POST['accion'] ?? '';
    $currentTab = $_POST['tab_origin'] ?? 'resumen';

    // 1. Acciones sobre consultas
    if ($accion === 'marcar_leido') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("UPDATE consultas SET leido = 1 WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => "Consulta #$id marcada como leída."];
        }
    } elseif ($accion === 'marcar_no_leido') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("UPDATE consultas SET leido = 0 WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => "Consulta #$id marcada como no leída."];
        }
    } elseif ($accion === 'marcar_todas_leidas') {
        $pdo->query("UPDATE consultas SET leido = 1 WHERE leido = 0");
        $_SESSION['flash'] = ['type' => 'success', 'msg' => "Todas las consultas fueron marcadas como leídas."];
    } elseif ($accion === 'eliminar_consulta') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM consultas WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => "Consulta #$id eliminada correctamente."];
        }
    }

    // 2. Acciones sobre usuarios
    elseif ($accion === 'crear_usuario') {
        $user = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass = $_POST['password'] ?? '';
        $rol = in_array($_POST['rol'] ?? '', ['admin', 'operador']) ? $_POST['rol'] : 'operador';

        if ($user === '' || $email === '' || strlen($pass) < 8) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Datos incompletos. La contraseña debe tener al menos 8 caracteres.'];
        } elseif (!preg_match('/^[a-zA-Z0-9_.]{3,40}$/', $user)) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'El nombre de usuario contiene caracteres inválidos.'];
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'El correo electrónico no es válido.'];
        } else {
            // Comprobar si ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE username = :u OR email = :e LIMIT 1");
            $stmt->execute([':u' => $user, ':e' => $email]);
            if ($stmt->fetch()) {
                $_SESSION['flash'] = ['type' => 'error', 'msg' => 'El nombre de usuario o correo ya está registrado.'];
            } else {
                $hash = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
                $stmt = $pdo->prepare("
                    INSERT INTO usuarios (username, email, password, rol, activo, ip_registro, creado_en)
                    VALUES (:u, :e, :p, :r, 1, :ip, NOW())
                ");
                $stmt->execute([
                    ':u'  => $user,
                    ':e'  => $email,
                    ':p'  => $hash,
                    ':r'  => $rol,
                    ':ip' => get_client_ip()
                ]);
                $_SESSION['flash'] = ['type' => 'success', 'msg' => "Usuario '$user' creado exitosamente."];
            }
        }
    } elseif ($accion === 'toggle_activo') {
        $id = (int) ($_POST['id'] ?? 0);
        $estadoActual = (int) ($_POST['estado_actual'] ?? 1);
        $nuevoEstado = $estadoActual ? 0 : 1;

        if ($id === $currentUserId) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No podés desactivar tu propia cuenta de administrador.'];
        } elseif ($id > 0) {
            $stmt = $pdo->prepare("UPDATE usuarios SET activo = :s WHERE id = :id");
            $stmt->execute([':s' => $nuevoEstado, ':id' => $id]);
            $msg = $nuevoEstado ? "Usuario #$id activado." : "Usuario #$id bloqueado/desactivado.";
            $_SESSION['flash'] = ['type' => 'success', 'msg' => $msg];
        }
    } elseif ($accion === 'cambiar_password') {
        $id = (int) ($_POST['id'] ?? 0);
        $nuevaPass = $_POST['nueva_password'] ?? '';

        if ($id > 0 && strlen($nuevaPass) >= 8) {
            $hash = password_hash($nuevaPass, PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $pdo->prepare("UPDATE usuarios SET password = :p WHERE id = :id");
            $stmt->execute([':p' => $hash, ':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => "Contraseña del usuario #$id actualizada con éxito."];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'La nueva contraseña debe tener un mínimo de 8 caracteres.'];
        }
    } elseif ($accion === 'eliminar_usuario') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id === $currentUserId) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'No podés eliminar tu propia cuenta de administrador.'];
        } elseif ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => "Usuario #$id eliminado permanentemente."];
        }
    }

    header("Location: dashboard.php?tab=$currentTab");
    exit;
}
