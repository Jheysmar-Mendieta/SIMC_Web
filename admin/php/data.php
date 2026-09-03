<?php
if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}

$activeTab = $_GET['tab'] ?? 'resumen';
if (!in_array($activeTab, ['resumen', 'consultas', 'usuarios', 'logs', 'sistema'])) {
    $activeTab = 'resumen';
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Estadísticas generales (KPIs)
$totalConsultas   = (int) $pdo->query("SELECT COUNT(*) FROM consultas")->fetchColumn();
$sinLeer          = (int) $pdo->query("SELECT COUNT(*) FROM consultas WHERE leido = 0")->fetchColumn();
$totalUsuarios    = (int) $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$usuariosActivos  = (int) $pdo->query("SELECT COUNT(*) FROM usuarios WHERE activo = 1")->fetchColumn();
$totalAdmins      = (int) $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'")->fetchColumn();

// Actividad en 24 horas
$logins24h        = (int) $pdo->query("SELECT COUNT(*) FROM sesiones_log WHERE accion = 'login' AND creado_en >= NOW() - INTERVAL 24 HOUR")->fetchColumn();
$fallos24h        = (int) $pdo->query("SELECT COUNT(*) FROM sesiones_log WHERE accion = 'login_fallido' AND creado_en >= NOW() - INTERVAL 24 HOUR")->fetchColumn();
$consultasSemana  = (int) $pdo->query("SELECT COUNT(*) FROM consultas WHERE creado_en >= NOW() - INTERVAL 7 DAY")->fetchColumn();

// Datos para la pestaña de resumen
$ultimasConsultas = $pdo->query("SELECT id, nombre, email, mensaje, leido, creado_en FROM consultas ORDER BY creado_en DESC LIMIT 5")->fetchAll();
$ultimosAccesos   = $pdo->query("
    SELECT l.id, l.accion, l.ip, l.creado_en, u.username 
    FROM sesiones_log l 
    LEFT JOIN usuarios u ON l.usuario_id = u.id 
    ORDER BY l.creado_en DESC 
    LIMIT 6
")->fetchAll();

// Gráfico de consultas por día (últimos 7 días)
$diasGrafico = [];
for ($i = 6; $i >= 0; $i--) {
    $fecha = date('Y-m-d', strtotime("-$i days"));
    $stmtG = $pdo->prepare("SELECT COUNT(*) FROM consultas WHERE DATE(creado_en) = :f");
    $stmtG->execute([':f' => $fecha]);
    $diasGrafico[] = [
        'dia' => date('d/m', strtotime($fecha)),
        'total' => (int) $stmtG->fetchColumn()
    ];
}
$maxGrafico = max(1, max(array_column($diasGrafico, 'total')));

// Datos para la pestaña de consultas
$filtroConsulta = $_GET['filtro'] ?? 'todos';
$busquedaConsulta = trim($_GET['q'] ?? '');

$sqlConsultas = "SELECT id, nombre, email, mensaje, leido, ip, creado_en FROM consultas WHERE 1=1 ";
$paramsConsultas = [];

if ($filtroConsulta === 'sin_leer') {
    $sqlConsultas .= "AND leido = 0 ";
} elseif ($filtroConsulta === 'leidos') {
    $sqlConsultas .= "AND leido = 1 ";
}

if ($busquedaConsulta !== '') {
    $sqlConsultas .= "AND (nombre LIKE :q1 OR email LIKE :q2 OR mensaje LIKE :q3) ";
    $paramsConsultas[':q1'] = "%$busquedaConsulta%";
    $paramsConsultas[':q2'] = "%$busquedaConsulta%";
    $paramsConsultas[':q3'] = "%$busquedaConsulta%";
}

$sqlConsultas .= "ORDER BY creado_en DESC LIMIT 100";
$stmtCons = $pdo->prepare($sqlConsultas);
$stmtCons->execute($paramsConsultas);
$listaConsultas = $stmtCons->fetchAll();

// Datos para la pestaña de usuarios
$listaUsuarios = $pdo->query("
    SELECT id, username, email, rol, activo, ip_registro, ultimo_login, creado_en 
    FROM usuarios 
    ORDER BY creado_en DESC
")->fetchAll();

// Datos para la pestaña de logs
$filtroLog = $_GET['filtro_log'] ?? 'todos';
$sqlLogs = "
    SELECT l.id, l.usuario_id, l.ip, l.user_agent, l.accion, l.creado_en, u.username 
    FROM sesiones_log l 
    LEFT JOIN usuarios u ON l.usuario_id = u.id 
";
if ($filtroLog === 'login_fallido') {
    $sqlLogs .= "WHERE l.accion = 'login_fallido' ";
} elseif ($filtroLog === 'login') {
    $sqlLogs .= "WHERE l.accion = 'login' ";
} elseif ($filtroLog === 'logout') {
    $sqlLogs .= "WHERE l.accion = 'logout' ";
}
$sqlLogs .= "ORDER BY l.creado_en DESC LIMIT 100";
$listaLogs = $pdo->query($sqlLogs)->fetchAll();
