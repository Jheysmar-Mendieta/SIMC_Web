<?php
/**
 * SIMC PRO — API Central de Gestión y Validación de Salas de Monitoreo
 * Sincroniza salas con la base de datos MySQL (simc_db).
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/conexion.php';

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);
if (!$data || !is_array($data)) {
    $data = !empty($_POST) ? $_POST : $_GET;
}

$action = strtolower(trim($data['action'] ?? $_GET['action'] ?? 'verificar'));

try {
    $db = get_db();

    // Asegurar que la tabla exista
    $db->exec("
        CREATE TABLE IF NOT EXISTS `salas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `token` varchar(32) NOT NULL,
            `nombre` varchar(120) NOT NULL,
            `plan` varchar(30) NOT NULL DEFAULT 'ENTERPRISE',
            `limite` int(11) NOT NULL DEFAULT 50,
            `docente_username` varchar(60) DEFAULT NULL,
            `tiempo` varchar(30) DEFAULT 'ilimitado',
            `mostrar_ip` tinyint(1) DEFAULT 1,
            `tipo_actividad` varchar(30) DEFAULT 'pestanas',
            `activa` tinyint(1) NOT NULL DEFAULT 1,
            `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
            `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `uq_token` (`token`),
            KEY `idx_activa` (`activa`, `creado_en`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");

    if ($action === 'crear' || $action === 'guardar') {
        $token = strtoupper(trim(str_replace(['-', ' '], '', $data['token'] ?? '')));
        $nombre = trim($data['nombre'] ?? 'Sala sin nombre');
        $plan = strtoupper(trim($data['plan'] ?? 'ENTERPRISE'));
        $limite = (int) ($data['limite'] ?? 50);
        $docente = trim($data['docente'] ?? $data['docente_username'] ?? '');
        $tiempo = trim($data['tiempo'] ?? 'ilimitado');
        $mostrarIp = isset($data['mostrar_ip']) ? (int)$data['mostrar_ip'] : (isset($data['mostrarIp']) && !$data['mostrarIp'] ? 0 : 1);
        $tipoActividad = trim($data['tipo_actividad'] ?? $data['tipoActividad'] ?? 'pestanas');

        if (!$token) {
            echo json_encode(['ok' => false, 'error' => 'Token de sala no proporcionado.']);
            exit;
        }

        $stmt = $db->prepare("
            INSERT INTO `salas` (`token`, `nombre`, `plan`, `limite`, `docente_username`, `tiempo`, `mostrar_ip`, `tipo_actividad`, `activa`)
            VALUES (:t, :n, :p, :l, :d, :tm, :mip, :ta, 1)
            ON DUPLICATE KEY UPDATE
                `nombre` = VALUES(`nombre`),
                `plan` = VALUES(`plan`),
                `limite` = VALUES(`limite`),
                `docente_username` = COALESCE(VALUES(`docente_username`), `docente_username`),
                `tiempo` = VALUES(`tiempo`),
                `mostrar_ip` = VALUES(`mostrar_ip`),
                `tipo_actividad` = VALUES(`tipo_actividad`),
                `activa` = 1,
                `actualizado_en` = NOW()
        ");

        $stmt->execute([
            ':t'   => $token,
            ':n'   => $nombre,
            ':p'   => $plan,
            ':l'   => $limite,
            ':d'   => $docente ?: null,
            ':tm'  => $tiempo,
            ':mip' => $mostrarIp,
            ':ta'  => $tipoActividad
        ]);

        echo json_encode([
            'ok' => true,
            'mensaje' => "Sala \"{$nombre}\" guardada exitosamente en la base de datos.",
            'token' => $token,
            'nombre' => $nombre,
            'plan' => $plan,
            'limite' => $limite
        ]);
        exit;
    }

    if ($action === 'verificar') {
        $token = strtoupper(trim(str_replace(['-', ' '], '', $data['token'] ?? $_GET['token'] ?? '')));
        if (!$token) {
            echo json_encode(['ok' => false, 'existe' => false, 'error' => 'Token no especificado.']);
            exit;
        }

        $stmt = $db->prepare("SELECT `token`, `nombre`, `plan`, `limite`, `docente_username`, `activa` FROM `salas` WHERE `token` = :t LIMIT 1");
        $stmt->execute([':t' => $token]);
        $sala = $stmt->fetch();

        if ($sala && (int)$sala['activa'] === 1) {
            echo json_encode([
                'ok' => true,
                'existe' => true,
                'sala' => [
                    'token'   => $sala['token'],
                    'nombre'  => $sala['nombre'],
                    'plan'    => $sala['plan'],
                    'limite'  => (int)$sala['limite'],
                    'docente' => $sala['docente_username']
                ]
            ]);
        } else {
            echo json_encode([
                'ok' => true,
                'existe' => false,
                'mensaje' => 'La sala no existe o se encuentra inactiva.'
            ]);
        }
        exit;
    }

    if ($action === 'listar') {
        $stmt = $db->query("SELECT `token`, `nombre`, `plan`, `limite`, `docente_username`, `tiempo`, `creado_en` FROM `salas` WHERE `activa` = 1 ORDER BY `creado_en` DESC LIMIT 50");
        $salas = $stmt->fetchAll();
        echo json_encode(['ok' => true, 'salas' => $salas]);
        exit;
    }

    if ($action === 'cerrar' || $action === 'eliminar') {
        $token = strtoupper(trim(str_replace(['-', ' '], '', $data['token'] ?? $_GET['token'] ?? '')));
        if (!$token) {
            echo json_encode(['ok' => false, 'error' => 'Token no especificado.']);
            exit;
        }

        $stmt = $db->prepare("UPDATE `salas` SET `activa` = 0 WHERE `token` = :t OR REPLACE(REPLACE(`token`, '-', ''), ' ', '') = :tc");
        $stmt->execute([':t' => $token, ':tc' => $token]);

        echo json_encode([
            'ok' => true,
            'mensaje' => "Sala \"{$token}\" cerrada y finalizada exitosamente en la base de datos.",
            'token' => $token
        ]);
        exit;
    }

    echo json_encode(['ok' => false, 'error' => 'Acción no reconocida.']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error en base de datos: ' . $e->getMessage()]);
}
