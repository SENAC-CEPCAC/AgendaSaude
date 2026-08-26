<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Novo Agendamento - Agenda Saúde' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN com suporte a fallback imediato -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        azul: '#004c99',
                        amarelo: '#f6be00',
                        'cinza-escuro': '#30567c',
                        'cinza-claro': '#d0d0ce',
                        branco: '#fafafa',
                        background: '#f8fafc',
                        surface: '#f8fafc',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-low': '#f3f3f9',
                        'surface-container': '#ededf3',
                        'surface-container-highest': '#e2e2e8',
                        'surface-variant': '#e2e8f0',
                        'on-background': '#0f172a',
                        'on-surface': '#0f172a',
                        'on-surface-variant': '#64748b',
                        primary: '#002856',
                        'primary-container': '#003e7e',
                        'primary-fixed': '#dbeafe',
                        'primary-fixed-dim': '#bfdbfe',
                        'on-primary': '#ffffff',
                        'on-primary-fixed': '#1e3a8a',
                        'secondary-container': '#f59e0b',
                        'secondary-fixed': '#fef3c7',
                        'on-secondary-fixed': '#78350f',
                        outline: '#94a3b8',
                        'outline-variant': '#e2e8f0',
                        error: '#ef4444',
                        'error-container': '#fee2e2',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#f8fafc] text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    <x-agendamento.header />

    <main class="flex-1 w-full max-w-lg mx-auto px-4 sm:px-6 py-6">

        {{ $slot }}
        
    </main>

    <x-agendamento.footer />

</body>

</html>