<?php
/**
 * SIMC ADMIN SUITE — Módulo de Exportaciones a CSV
 */

if (!defined('SIMC_ADMIN_INIT')) {
    die('Acceso denegado.');
}

if (isset($_GET['export'])) {
    $exportType = $_GET['export'];

    if ($exportType === 'consultas_csv') {
        $filename = 'simc_consultas_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8 para Excel
        
        fputcsv($output, ['ID', 'Nombre', 'Email', 'Mensaje', 'Estado', 'IP', 'Fecha de Registro']);
        
        $stmt = $pdo->query("SELECT id, nombre, email, mensaje, leido, ip, creado_en FROM consultas ORDER BY creado_en DESC");
        while ($row = $stmt->fetch()) {
            fputcsv($output, [
                $row['id'],
                $row['nombre'],
                $row['email'],
                $row['mensaje'],
                $row['leido'] ? 'Leído' : 'Nuevo / Sin leer',
                $row['ip'] ?? 'N/A',
                $row['creado_en']
            ]);
        }
        fclose($output);
        exit;
    }

    if ($exportType === 'usuarios_csv') {
        $filename = 'simc_usuarios_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Usuario', 'Email', 'Rol', 'Estado', 'IP Registro', 'Último Login', 'Fecha Creación']);
        
        $stmt = $pdo->query("SELECT id, username, email, rol, activo, ip_registro, ultimo_login, creado_en FROM usuarios ORDER BY id ASC");
        while ($row = $stmt->fetch()) {
            fputcsv($output, [
                $row['id'],
                $row['username'],
                $row['email'],
                $row['rol'],
                $row['activo'] ? 'Activo' : 'Bloqueado',
                $row['ip_registro'] ?? 'N/A',
                $row['ultimo_login'] ?? 'Nunca',
                $row['creado_en']
            ]);
        }
        fclose($output);
        exit;
    }

    if ($exportType === 'logs_csv') {
        $filename = 'simc_logs_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['ID', 'Usuario ID', 'Usuario', 'Acción', 'IP', 'User Agent', 'Fecha y Hora']);
        
        $stmt = $pdo->query("
            SELECT l.id, l.usuario_id, u.username, l.accion, l.ip, l.user_agent, l.creado_en 
            FROM sesiones_log l 
            LEFT JOIN usuarios u ON l.usuario_id = u.id 
            ORDER BY l.creado_en DESC 
            LIMIT 1000
        ");
        while ($row = $stmt->fetch()) {
            fputcsv($output, [
                $row['id'],
                $row['usuario_id'] ?? 'N/A',
                $row['username'] ?? 'Anónimo / Desconocido',
                $row['accion'],
                $row['ip'],
                $row['user_agent'],
                $row['creado_en']
            ]);
        }
        fclose($output);
        exit;
    }
}
