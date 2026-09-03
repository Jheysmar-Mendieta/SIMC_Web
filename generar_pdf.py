# -*- coding: utf-8 -*-
"""
SIMC — Generador de PDF para el Manual del Programador
Convierte MANUAL_PROGRAMADOR_SIMC.md a HTML estilizado y renderiza a PDF con Microsoft Edge Headless.
"""

import os
import sys
import subprocess
import re
import markdown

EDGE_PATH = r"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"
if not os.path.exists(EDGE_PATH):
    EDGE_PATH = r"C:\Program Files\Microsoft\Edge\Application\msedge.exe"

DIR_ACTUAL = os.path.dirname(os.path.abspath(__file__))
MD_PATH = os.path.join(DIR_ACTUAL, "MANUAL_PROGRAMADOR_SIMC.md")
HTML_PATH = os.path.join(DIR_ACTUAL, "manual_temp.html")
PDF_PATH = os.path.join(DIR_ACTUAL, "MANUAL_PROGRAMADOR_SIMC.pdf")

def procesar_markdown_a_html(md_content):
    # Proteger y formatear bloques Mermaid
    def replace_mermaid(match):
        code = match.group(1).strip()
        return f'\n<div class="mermaid-container"><pre class="mermaid">\n{code}\n</pre></div>\n'

    md_content = re.sub(r'```mermaid\s*([\s\S]*?)```', replace_mermaid, md_content)

    # Convertir con extensiones de markdown
    html_body = markdown.markdown(
        md_content,
        extensions=['tables', 'fenced_code', 'toc', 'sane_lists', 'attr_list']
    )

    # Reemplazar alertas de GitHub si existen
    html_body = re.sub(r'<blockquote>\s*<p>\[!NOTE\]\s*(.*?)</p>\s*</blockquote>', r'<div class="callout callout-note"><strong>NOTA:</strong> \1</div>', html_body, flags=re.DOTALL)
    html_body = re.sub(r'<blockquote>\s*<p>\[!IMPORTANT\]\s*(.*?)</p>\s*</blockquote>', r'<div class="callout callout-important"><strong>IMPORTANTE:</strong> \1</div>', html_body, flags=re.DOTALL)
    html_body = re.sub(r'<blockquote>\s*<p>\[!WARNING\]\s*(.*?)</p>\s*</blockquote>', r'<div class="callout callout-warning"><strong>ADVERTENCIA:</strong> \1</div>', html_body, flags=re.DOTALL)
    html_body = re.sub(r'<blockquote>\s*<p>\[!TIP\]\s*(.*?)</p>\s*</blockquote>', r'<div class="callout callout-tip"><strong>CONSEJO:</strong> \1</div>', html_body, flags=re.DOTALL)

    return html_body

def generar_html_completo(body_content):
    template = f"""<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>SIMC — Manual del Programador</title>
  
  <!-- Tipografías de Alta Calidad -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Orbitron:wght@700;900&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  
  <!-- Highlight.js para Sintaxis de Código -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
  
  <!-- Mermaid.js para Diagramas -->
  <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>

  <style>
    @page {{
      size: A4;
      margin: 20mm 15mm 20mm 15mm;
      @bottom-center {{
        content: "Página " counter(page) " de " counter(pages);
        font-family: 'Inter', sans-serif;
        font-size: 8pt;
        color: #64748b;
      }}
    }}

    *, *::before, *::after {{
      box-sizing: border-box;
    }}

    body {{
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      font-size: 10pt;
      line-height: 1.6;
      color: #1e293b;
      background-color: #ffffff;
      margin: 0;
      padding: 0;
    }}

    /* Portada Ejecutiva */
    .cover-page {{
      page-break-after: always;
      min-height: 95vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: linear-gradient(145deg, #030712 0%, #0f172a 60%, #1e1b4b 100%);
      color: #ffffff;
      padding: 60px 45px;
      border-radius: 12px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.25);
      position: relative;
      overflow: hidden;
    }}

    .cover-page::before {{
      content: "";
      position: absolute;
      top: -100px;
      right: -100px;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(6, 182, 212, 0.25) 0%, rgba(139, 92, 246, 0) 70%);
      border-radius: 50%;
    }}

    .cover-page::after {{
      content: "";
      position: absolute;
      bottom: -100px;
      left: -100px;
      width: 350px;
      height: 350px;
      background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, rgba(6, 182, 212, 0) 70%);
      border-radius: 50%;
    }}

    .cover-top {{
      position: relative;
      z-index: 2;
    }}

    .cover-badge {{
      display: inline-block;
      padding: 6px 14px;
      background: rgba(6, 182, 212, 0.15);
      border: 1px solid rgba(6, 182, 212, 0.4);
      color: #38bdf8;
      font-family: 'JetBrains Mono', monospace;
      font-size: 8.5pt;
      font-weight: 600;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      border-radius: 6px;
      margin-bottom: 24px;
    }}

    .cover-title {{
      font-family: 'Orbitron', 'Syne', sans-serif;
      font-size: 26pt;
      font-weight: 900;
      line-height: 1.2;
      color: #ffffff;
      margin: 0 0 16px 0;
      letter-spacing: -0.5px;
    }}

    .cover-title span {{
      background: linear-gradient(135deg, #06b6d4 0%, #38bdf8 50%, #818cf8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }}

    .cover-subtitle {{
      font-size: 13pt;
      font-weight: 400;
      color: #94a3b8;
      max-width: 550px;
      margin: 0 0 30px 0;
      line-height: 1.5;
    }}

    .cover-tags {{
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 20px;
    }}

    .cover-tag {{
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.12);
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 8pt;
      color: #cbd5e1;
      font-family: 'JetBrains Mono', monospace;
    }}

    .cover-footer {{
      position: relative;
      z-index: 2;
      border-top: 1px solid rgba(255, 255, 255, 0.15);
      padding-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }}

    .cover-meta {{
      font-size: 8.5pt;
      color: #94a3b8;
      line-height: 1.6;
    }}

    .cover-meta strong {{
      color: #f8fafc;
    }}

    .cover-logo-text {{
      font-family: 'Orbitron', sans-serif;
      font-size: 20pt;
      font-weight: 900;
      letter-spacing: 2px;
      color: #38bdf8;
      text-align: right;
    }}

    /* Estilos del Contenido */
    h1, h2, h3, h4, h5, h6 {{
      font-family: 'Syne', 'Inter', sans-serif;
      color: #0f172a;
      font-weight: 700;
      margin-top: 24pt;
      margin-bottom: 10pt;
      page-break-after: avoid;
    }}

    h1 {{
      font-size: 18pt;
      border-bottom: 2px solid #0284c7;
      padding-bottom: 6px;
      margin-top: 30pt;
      page-break-before: always;
    }}

    h2 {{
      font-size: 14pt;
      border-bottom: 1px solid #e2e8f0;
      padding-bottom: 4px;
      margin-top: 20pt;
      color: #0369a1;
    }}

    h3 {{
      font-size: 11.5pt;
      color: #1e293b;
      margin-top: 16pt;
    }}

    h4 {{
      font-size: 10pt;
      color: #334155;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }}

    p, ul, ol {{
      margin-top: 0;
      margin-bottom: 10pt;
      color: #334155;
    }}

    ul, ol {{
      padding-left: 20px;
    }}

    li {{
      margin-bottom: 4pt;
    }}

    /* Tablas */
    table {{
      width: 100%;
      border-collapse: collapse;
      margin: 14pt 0;
      font-size: 8.5pt;
      page-break-inside: avoid;
    }}

    th, td {{
      padding: 7pt 10pt;
      border: 1px solid #cbd5e1;
      text-align: left;
    }}

    th {{
      background: #0f172a;
      color: #ffffff;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      letter-spacing: 0.3px;
    }}

    tr:nth-child(even) {{
      background-color: #f8fafc;
    }}

    tr:hover {{
      background-color: #f1f5f9;
    }}

    /* Bloques de Código */
    pre {{
      background: #090d16 !important;
      color: #f8fafc !important;
      border: 1px solid #1e293b;
      border-radius: 8px;
      padding: 12pt;
      font-family: 'JetBrains Mono', Consolas, Monaco, monospace;
      font-size: 8pt;
      line-height: 1.5;
      overflow-x: auto;
      page-break-inside: avoid;
      margin: 12pt 0;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }}

    code {{
      font-family: 'JetBrains Mono', Consolas, Monaco, monospace;
      font-size: 8.5pt;
      background: #f1f5f9;
      color: #0369a1;
      padding: 2px 5px;
      border-radius: 4px;
      border: 1px solid #e2e8f0;
    }}

    pre code {{
      background: transparent !important;
      color: inherit !important;
      padding: 0 !important;
      border: none !important;
      font-size: 8pt !important;
    }}

    /* Diagramas Mermaid */
    .mermaid-container {{
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 16pt;
      margin: 16pt 0;
      text-align: center;
      page-break-inside: avoid;
    }}

    .mermaid {{
      font-family: 'Inter', sans-serif !important;
    }}

    /* Alertas / Callouts */
    .callout {{
      padding: 10pt 14pt;
      margin: 12pt 0;
      border-radius: 6px;
      font-size: 9pt;
      line-height: 1.5;
      page-break-inside: avoid;
    }}

    .callout-note {{
      background: #eff6ff;
      border-left: 4px solid #3b82f6;
      color: #1e40af;
    }}

    .callout-important {{
      background: #fef2f2;
      border-left: 4px solid #ef4444;
      color: #991b1b;
    }}

    .callout-warning {{
      background: #fffbeb;
      border-left: 4px solid #f59e0b;
      color: #92400e;
    }}

    .callout-tip {{
      background: #ecfdf5;
      border-left: 4px solid #10b981;
      color: #065f46;
    }}

    hr {{
      border: none;
      border-top: 1px solid #e2e8f0;
      margin: 24pt 0;
    }}

    a {{
      color: #0284c7;
      text-decoration: none;
    }}

    strong {{
      color: #0f172a;
      font-weight: 600;
    }}
  </style>
</head>
<body>

  <!-- PORTADA -->
  <div class="cover-page">
    <div class="cover-top">
      <div class="cover-badge">Documentación Técnica Oficial</div>
      <h1 class="cover-title">MANUAL DEL PROGRAMADOR<br><span>SISTEMA WEB SIMC</span></h1>
      <p class="cover-subtitle">Especificación Técnica Integral, Arquitectura de Software, Seguridad, Endpoints de Licenciamiento y Panel de Administración.</p>
      
      <div class="cover-tags">
        <span class="cover-tag">PHP 8.x PDO</span>
        <span class="cover-tag">MySQL / MariaDB</span>
        <span class="cover-tag">Apache 2.4</span>
        <span class="cover-tag">Vanilla JS ES6+</span>
        <span class="cover-tag">CSS3 Modular</span>
        <span class="cover-tag">RBAC & Anti-CSRF</span>
        <span class="cover-tag">API REST JSON</span>
      </div>
    </div>

    <div class="cover-footer">
      <div class="cover-meta">
        <strong>Proyecto:</strong> SIMC — Monitoreo y Control<br>
        <strong>Módulo:</strong> Portal Web & Servidor Backend (/SIMC/SIMC/)<br>
        <strong>Versión:</strong> 2.5 (Edición Producción Modular)<br>
        <strong>Fecha de Emisión:</strong> Septiembre 2026<br>
        <strong>Estado:</strong> Aprobado para Producción
      </div>
      <div class="cover-logo-text">
        SIMC PRO
      </div>
    </div>
  </div>

  <!-- CUERPO DEL MANUAL -->
  <div class="content-wrapper">
    {body_content}
  </div>

  <script>
    // Inicializar Highlight.js
    hljs.highlightAll();

    // Inicializar Mermaid
    mermaid.initialize({{
      startOnLoad: true,
      theme: 'default',
      securityLevel: 'loose',
      flowchart: {{ useMaxWidth: true, htmlLabels: true, curve: 'basis' }},
      sequence: {{ useMaxWidth: true, showSequenceNumbers: true }}
    }});
  </script>
</body>
</html>
"""
    return template

def main():
    print(f"[1/4] Leyendo archivo markdown: {MD_PATH}")
    if not os.path.exists(MD_PATH):
        print(f"ERROR: No se encontró {MD_PATH}")
        sys.exit(1)

    with open(MD_PATH, 'r', encoding='utf-8') as f:
        md_text = f.read()

    print("[2/4] Convirtiendo Markdown a HTML con estilos ejecutivos...")
    html_body = procesar_markdown_a_html(md_text)
    html_final = generar_html_completo(html_body)

    with open(HTML_PATH, 'w', encoding='utf-8') as f:
        f.write(html_final)
    print(f"HTML generado en: {HTML_PATH}")

    print(f"[3/4] Renderizando PDF con Microsoft Edge Headless...")
    print(f"Binario Edge: {EDGE_PATH}")

    # Ejecutar Edge en modo Headless con tiempo de espera para que Mermaid y fuentes se procesen
    cmd = [
        EDGE_PATH,
        "--headless=new",
        "--disable-gpu",
        "--allow-file-access-from-files",
        "--run-all-compositor-stages-before-draw",
        "--virtual-time-budget=6000",
        "--no-pdf-header-footer",
        f"--print-to-pdf={PDF_PATH}",
        HTML_PATH
    ]

    result = subprocess.run(cmd, capture_output=True, text=True)

    print("[4/4] Verificando resultado...")
    if os.path.exists(PDF_PATH) and os.path.getsize(PDF_PATH) > 1000:
        tam_kb = os.path.getsize(PDF_PATH) / 1024
        print(f"¡ÉXITO! PDF generado correctamente:")
        print(f"Ruta: {PDF_PATH}")
        print(f"Tamaño: {tam_kb:.2f} KB")
        # Limpiar archivo temporal si se desea, o dejarlo
    else:
        print(f"ERROR: No se pudo generar el archivo PDF.")
        print(f"STDOUT: {result.stdout}")
        print(f"STDERR: {result.stderr}")
        sys.exit(1)

if __name__ == "__main__":
    main()
