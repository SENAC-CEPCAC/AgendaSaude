<!DOCTYPE html>

<html class="light" lang="pt-BR">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!--TITULO: {{$title}} -->
<title>Novo Agendamento - Seleção</title>
<!-- Google Fonts: Inter & Material Symbols -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS --> 
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<!-- Tailwind Configuration (Unificado para todas as 3 telas do fluxo) -->
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                "colors": {
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#f3f3f9",
                    "surface-container-highest": "#e2e2e8",
                    "surface-container": "#ededf3",
                    "surface-variant": "#e2e2e8",
                    "surface": "#f9f9ff",
                    "background": "#f9f9ff",
                    "on-background": "#1a1c20",
                    "on-surface": "#1a1c20",
                    "on-surface-variant": "#434750",
                    "primary": "#002856",
                    "primary-fixed": "#d6e3ff",
                    "primary-fixed-dim": "#a9c7ff",
                    "on-primary-fixed": "#001b3d",
                    "on-primary": "#ffffff",
                    "primary-container": "#003e7e",
                    "secondary-container": "#fdc008",
                    "secondary-fixed": "#ffdf9d",
                    "on-secondary-fixed": "#251a00",
                    "outline": "#737781",
                    "outline-variant": "#c3c6d2",
                    "error": "#ba1a1a",
                    "error-container": "#ffdad6"
                },
                "spacing": {
                    "margin": "20px",
                    "gutter": "16px",
                    "lg": "24px",
                    "xl": "32px",
                    "md": "16px",
                    "sm": "8px",
                    "xs": "4px"
                },
                "fontSize": {
                    "h1": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                    "h2": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                    "h3": ["20px", { "lineHeight": "28px", "letterSpacing": "0em", "fontWeight": "600" }],
                    "body-lg": ["18px", { "lineHeight": "28px", "letterSpacing": "0em", "fontWeight": "400" }],
                    "body-md": ["16px", { "lineHeight": "24px", "letterSpacing": "0em", "fontWeight": "400" }],
                    "body-sm": ["14px", { "lineHeight": "20px", "letterSpacing": "0em", "fontWeight": "400" }],
                    "label-bold": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "700" }],
                    "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0em", "fontWeight": "500" }]
                }
            }
        }
    }
</script>


<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex flex-col relative selection:bg-primary-fixed selection:text-on-primary-fixed">

<x-header_flx_agendamento></x-header_flx_agendamento>

    <!-- Main Content Canvas -->
    <main class="flex-1 w-full max-w-md mx-auto px-margin pb-32 flex flex-col gap-xl pt-md">

        {{$slot}}

    </main>
</body>