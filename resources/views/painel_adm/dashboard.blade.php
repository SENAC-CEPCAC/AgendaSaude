<!DOCTYPE html>

<html lang="pt-BR"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Agenda Saúde - Dashboard de Gestão</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "tertiary-fixed-dim": "#ffb692",
                      "surface-container-lowest": "#ffffff",
                      "error": "#ba1a1a",
                      "on-primary-fixed-variant": "#114686",
                      "surface-container": "#ededf3",
                      "primary-fixed": "#d6e3ff",
                      "secondary": "#785a00",
                      "outline-variant": "#c3c6d2",
                      "inverse-on-surface": "#f0f0f6",
                      "error-container": "#ffdad6",
                      "surface-variant": "#e2e2e8",
                      "primary-fixed-dim": "#a9c7ff",
                      "surface-container-highest": "#e2e2e8",
                      "surface-container-low": "#f3f3f9",
                      "on-background": "#1a1c20",
                      "on-primary": "#ffffff",
                      "background": "#f9f9ff",
                      "tertiary-container": "#6d2b01",
                      "secondary-fixed": "#ffdf9d",
                      "on-error": "#ffffff",
                      "on-tertiary-fixed": "#341100",
                      "inverse-primary": "#a9c7ff",
                      "on-primary-container": "#82abf2",
                      "primary": "#002856",
                      "surface-dim": "#d9d9e0",
                      "on-primary-fixed": "#001b3d",
                      "surface-tint": "#325ea0",
                      "on-tertiary": "#ffffff",
                      "secondary-fixed-dim": "#f9bd00",
                      "on-tertiary-container": "#f29261",
                      "surface": "#f9f9ff",
                      "primary-container": "#003e7e",
                      "secondary-container": "#fdc008",
                      "on-secondary": "#ffffff",
                      "on-surface-variant": "#434750",
                      "outline": "#737781",
                      "on-secondary-fixed": "#251a00",
                      "on-tertiary-fixed-variant": "#773207",
                      "surface-container-high": "#e8e8ee",
                      "on-surface": "#1a1c20",
                      "surface-bright": "#f9f9ff",
                      "tertiary": "#4a1b00",
                      "on-error-container": "#93000a",
                      "on-secondary-fixed-variant": "#5b4300",
                      "on-secondary-container": "#6c5000",
                      "inverse-surface": "#2f3035",
                      "tertiary-fixed": "#ffdbcb"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "unit": "4px",
                      "lg": "24px",
                      "gutter": "16px",
                      "margin": "20px",
                      "xs": "4px",
                      "xl": "32px",
                      "md": "16px",
                      "sm": "8px"
              },
              "fontFamily": {
                      "h3": [
                              "Inter"
                      ],
                      "label-bold": [
                              "Inter"
                      ],
                      "body-sm": [
                              "Inter"
                      ],
                      "body-md": [
                              "Inter"
                      ],
                      "body-lg": [
                              "Inter"
                      ],
                      "h2": [
                              "Inter"
                      ],
                      "label-md": [
                              "Inter"
                      ],
                      "h1": [
                              "Inter"
                      ]
              },
              "fontSize": {
                      "h3": [
                              "20px",
                              {
                                      "lineHeight": "28px",
                                      "letterSpacing": "0em",
                                      "fontWeight": "600"
                              }
                      ],
                      "label-bold": [
                              "12px",
                              {
                                      "lineHeight": "16px",
                                      "letterSpacing": "0.05em",
                                      "fontWeight": "700"
                              }
                      ],
                      "body-sm": [
                              "14px",
                              {
                                      "lineHeight": "20px",
                                      "letterSpacing": "0em",
                                      "fontWeight": "400"
                              }
                      ],
                      "body-md": [
                              "16px",
                              {
                                      "lineHeight": "24px",
                                      "letterSpacing": "0em",
                                      "fontWeight": "400"
                              }
                      ],
                      "body-lg": [
                              "18px",
                              {
                                      "lineHeight": "28px",
                                      "letterSpacing": "0em",
                                      "fontWeight": "400"
                              }
                      ],
                      "h2": [
                              "24px",
                              {
                                      "lineHeight": "32px",
                                      "letterSpacing": "-0.01em",
                                      "fontWeight": "600"
                              }
                      ],
                      "label-md": [
                              "12px",
                              {
                                      "lineHeight": "16px",
                                      "letterSpacing": "0em",
                                      "fontWeight": "500"
                              }
                      ],
                      "h1": [
                              "32px",
                              {
                                      "lineHeight": "40px",
                                      "letterSpacing": "-0.02em",
                                      "fontWeight": "700"
                              }
                      ]
              }
      },
          },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-md text-body-md antialiased flex">
<!-- SideNavBar -->
<nav class="hidden md:flex flex-col fixed left-0 top-0 h-screen py-6 bg-white dark:bg-slate-900 h-full w-64 border-r border-r border-slate-200 dark:border-slate-800 z-40">
<div class="px-6 mb-8 flex flex-col items-center">
<div class="w-16 h-16 rounded-full bg-surface-variant overflow-hidden mb-4">
<img alt="Gestor" class="w-full h-full object-cover" data-alt="A professional headshot of a medical administrator in a modern, well-lit office environment. The lighting is soft and natural, creating an approachable yet authoritative presence. The overall color palette features clean whites and subtle blues to align with a healthcare aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRpqwtwilo7T_SJJWex6nRD4sXjP8Y4qHZ7cRnv0pFTK8ZBO3ijubTW2O059buMEVpapnHj0bXCRE4B5YBAouPqCdyIKjwuokhv1jbUlOgSjaNKgQqNGQrWyIFtke8mTZUY7GUvE6UI7JLFpmKgk7HYL_qSFQ4WlsvSny8RRnZ0YuUnYyqhxGVJ7xnRZ8JkHXvITJ_Kk454mHoj2w6-ed08ziXGKDQBLQv1GIgnd1Mz22W0_ei3JAMffEiBuY_aXI_vh5vkkmatOw"/>
</div>
<div class="text-xl font-black text-[#003E7E] dark:text-blue-400 font-h2 text-h2 mb-1">Portal Gestão</div>
<div class="text-sm text-slate-500 font-body-sm text-body-sm">Administrador</div>
</div>
<ul class="flex-1 flex flex-col gap-2 px-3"><li>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-[#003E7E] dark:text-blue-300 border-l-4 border-[#003E7E] font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">calendar_month</span>
                    Agendamentos
                </a>
</li><li>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">list</span>
                    Lista de Espera
                </a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">rv_hookup</span>
                    Unidades Móveis
                </a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">groups</span>
                    Pacientes
                </a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">analytics</span>
                    Relatórios
                </a>
</li></ul>
<div class="mt-auto px-3 border-t border-slate-200 dark:border-slate-800 pt-4">
<ul class="flex flex-col gap-2"><li>
<a class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">settings</span>
                        Configurações
                    </a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 font-['Inter'] text-sm font-medium hover:text-[#003E7E] dark:hover:text-blue-300 transition-all active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">logout</span>
                        Sair
                    </a>
</li></ul>
</div>
</nav>
<!-- Main Content Area -->
<main class="flex-1 ml-0 md:ml-64 w-full min-h-screen pb-20 md:pb-0">
<!-- TopAppBar (Mobile & Web) -->
<header class="sticky top-0 z-30 flex justify-between items-center px-5 h-16 w-full bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm font-['Inter'] antialiased">
<div class="flex items-center gap-4">
<!-- Mobile Menu Button (visible only on md:hidden) -->
<button class="md:hidden text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors p-2 rounded-full">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="text-lg font-bold text-[#003E7E] dark:text-blue-400 font-h3 text-h3 md:hidden">Agenda Saúde</div>
<div class="hidden md:block font-h3 text-h3 text-on-surface">Visão Geral</div>
</div>
<div class="flex items-center gap-2">
<button class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors rounded-full active:opacity-80 transition-opacity">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors rounded-full active:opacity-80 transition-opacity">
<span class="material-symbols-outlined">account_circle</span>
</button>
</div>
</header>
<!-- Canvas -->
<div class="p-margin mx-auto max-w-7xl flex flex-col gap-lg">
<!-- Welcome Header -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mt-sm">
<div>
<h1 class="font-h1 text-h1 text-on-surface">Bom dia, Gestor</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-1">Aqui está o resumo das operações de hoje.</p>
</div>
<div class="text-sm font-label-md text-label-md text-on-surface-variant bg-surface-container-low px-3 py-1.5 rounded-full border border-outline-variant">
                    Última atualização: Hoje, 08:42
                </div>
</div>
<!-- Top Row: KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
<!-- Card 1 -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_12px_rgba(0,62,126,0.04)] border border-surface-variant flex flex-col gap-4">
<div class="flex justify-between items-start">
<div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed-variant">
<span class="material-symbols-outlined">event_available</span>
</div>
<span class="flex items-center text-green-600 text-sm font-label-bold text-label-bold">
<span class="material-symbols-outlined text-[16px] mr-1">trending_up</span>
                            +12%
                        </span>
</div>
<div>
<div class="text-on-surface-variant font-body-sm text-body-sm mb-1">Agendamentos do Dia</div>
<div class="text-on-surface font-h1 text-h1">148</div>
</div>
</div>
<!-- Card 2 -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_12px_rgba(0,62,126,0.04)] border border-surface-variant flex flex-col gap-4">
<div class="flex justify-between items-start">
<div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed-variant">
<span class="material-symbols-outlined">airline_seat_recline_normal</span>
</div>
<span class="flex items-center text-red-600 text-sm font-label-bold text-label-bold">
<span class="material-symbols-outlined text-[16px] mr-1">trending_down</span>
                            -5%
                        </span>
</div>
<div>
<div class="text-on-surface-variant font-body-sm text-body-sm mb-1">Vagas Disponíveis</div>
<div class="text-on-surface font-h1 text-h1">24</div>
</div>
</div>
<!-- Card 3 -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_4px_12px_rgba(0,62,126,0.04)] border border-surface-variant flex flex-col gap-4">
<div class="flex justify-between items-start">
<div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed-variant">
<span class="material-symbols-outlined">pie_chart</span>
</div>
<span class="flex items-center text-slate-500 text-sm font-label-bold text-label-bold">
<span class="material-symbols-outlined text-[16px] mr-1">remove</span>
                            0%
                        </span>
</div>
<div>
<div class="text-on-surface-variant font-body-sm text-body-sm mb-1">Taxa de Ocupação</div>
<div class="text-on-surface font-h1 text-h1">85%</div>
</div>
</div>
</div>
<!-- Middle & Bottom Layout Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
<!-- Lista de Espera Inteligente (Takes 2 columns on large screens) -->
<div class="lg:col-span-2 bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,62,126,0.04)] border border-surface-variant overflow-hidden flex flex-col">
<div class="p-5 border-b border-surface-variant flex justify-between items-center bg-surface-bright">
<h2 class="font-h3 text-h3 text-on-surface">Lista de Espera Inteligente</h2>
<button class="text-primary-container hover:text-primary font-label-md text-label-md">Ver todos</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low text-on-surface-variant font-label-bold text-label-bold uppercase tracking-wider text-[10px]">
<th class="p-4 border-b border-surface-variant">Prioridade</th>
<th class="p-4 border-b border-surface-variant">Paciente</th>
<th class="p-4 border-b border-surface-variant">Especialidade</th>
<th class="p-4 border-b border-surface-variant text-right">Tempo de Espera</th>
</tr>
</thead>
<tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-surface-variant">
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="p-4">
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-error-container text-on-error-container">
                                            Alta
                                        </span>
</td>
<td class="p-4 font-medium">Maria Silva</td>
<td class="p-4 text-on-surface-variant">Clínico Geral</td>
<td class="p-4 text-right text-error font-medium">45 min</td>
</tr>
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="p-4">
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-secondary-fixed text-on-secondary-fixed-variant">
                                            Média
                                        </span>
</td>
<td class="p-4 font-medium">João Batista</td>
<td class="p-4 text-on-surface-variant">Odontologia</td>
<td class="p-4 text-right">20 min</td>
</tr>
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="p-4">
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-fixed text-on-primary-fixed-variant">
                                            Normal
                                        </span>
</td>
<td class="p-4 font-medium">Ana Oliveira</td>
<td class="p-4 text-on-surface-variant">Vacinação</td>
<td class="p-4 text-right">10 min</td>
</tr>
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="p-4">
<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-fixed text-on-primary-fixed-variant">
                                            Normal
                                        </span>
</td>
<td class="p-4 font-medium">Carlos Mendes</td>
<td class="p-4 text-on-surface-variant">Triagem</td>
<td class="p-4 text-right">5 min</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Atendimentos Realizados (Takes 1 column on large screens) -->
<div class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,62,126,0.04)] border border-surface-variant p-5 flex flex-col h-[380px]">
<div class="flex justify-between items-center mb-6">
<h2 class="font-h3 text-h3 text-on-surface">Atendimentos</h2>
<span class="text-on-surface-variant font-label-md text-label-md">Últimos 7 dias</span>
</div>
<!-- Faux Line Chart Area -->
<div class="flex-1 relative flex items-end pt-4">
<!-- Y-Axis Labels -->
<div class="absolute left-0 top-0 bottom-8 flex flex-col justify-between text-xs text-on-surface-variant font-label-md h-full pb-8 pr-2 border-r border-surface-variant w-8">
<span>200</span>
<span>150</span>
<span>100</span>
<span>50</span>
<span>0</span>
</div>
<!-- Grid Lines -->
<div class="absolute left-8 right-0 top-0 bottom-8 flex flex-col justify-between h-full pb-8 z-0">
<div class="w-full border-t border-dashed border-surface-variant h-0"></div>
<div class="w-full border-t border-dashed border-surface-variant h-0"></div>
<div class="w-full border-t border-dashed border-surface-variant h-0"></div>
<div class="w-full border-t border-dashed border-surface-variant h-0"></div>
<div class="w-full border-t border-surface-variant h-0"></div>
</div>
<!-- Data Points & Line (Stylized with div structure for demonstration without JS/SVG) -->
<div class="relative w-full h-full ml-8 z-10 flex items-end justify-between px-2 pb-8">
<!-- Mon -->
<div class="w-full flex justify-center group relative h-[60%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Tue -->
<div class="w-full flex justify-center group relative h-[75%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Wed -->
<div class="w-full flex justify-center group relative h-[50%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Thu -->
<div class="w-full flex justify-center group relative h-[90%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Fri -->
<div class="w-full flex justify-center group relative h-[80%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Sat -->
<div class="w-full flex justify-center group relative h-[40%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Sun -->
<div class="w-full flex justify-center group relative h-[30%]">
<div class="absolute bottom-0 w-2 h-2 rounded-full bg-primary-container z-20 transition-transform group-hover:scale-150 group-hover:bg-secondary-container cursor-pointer"></div>
</div>
<!-- Decorative Line Connection (Simplified via gradient background for visual effect in HTML) -->
<div class="absolute inset-0 bottom-8 pointer-events-none" style="background: linear-gradient(to right, transparent, rgba(0,62,126,0.05) 50%, transparent); clip-path: polygon(0 100%, 0 40%, 16% 25%, 33% 50%, 50% 10%, 66% 20%, 83% 60%, 100% 70%, 100% 100%);"></div>
<!-- Connecting Line segment visual hack -->
<svg class="absolute inset-0 w-full h-[calc(100%-32px)] overflow-visible" preserveaspectratio="none" style="bottom: 32px; z-index: 10;" viewbox="0 0 100 100">
<polyline fill="none" points="5,40 20,25 35,50 50,10 65,20 80,60 95,70" stroke="#003E7E" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" vector-effect="non-scaling-stroke"></polyline>
</svg>
</div>
<!-- X-Axis Labels -->
<div class="absolute left-8 right-0 bottom-0 h-8 flex justify-between items-center px-2 text-xs text-on-surface-variant font-label-md">
<span>Seg</span>
<span>Ter</span>
<span>Qua</span>
<span>Qui</span>
<span>Sex</span>
<span>Sáb</span>
<span>Dom</span>
</div>
</div>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center h-16 pb-safe px-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-t border-slate-100 dark:border-slate-800 shadow-[0_-4px_12px_rgba(0,62,126,0.04)] rounded-t-2xl font-['Inter'] text-[10px] uppercase tracking-wider">
<a class="flex flex-col items-center justify-center text-[#003E7E] dark:text-blue-400 font-bold active:bg-slate-50 dark:active:bg-slate-800 tap-highlight-transparent transition-transform active:scale-90 p-2 rounded-lg w-16" href="#">
<span class="material-symbols-outlined mb-1">home</span>
            Início
        </a>
<a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 active:bg-slate-50 dark:active:bg-slate-800 tap-highlight-transparent transition-transform active:scale-90 p-2 rounded-lg w-16" href="#">
<span class="material-symbols-outlined mb-1">list</span>
            Agenda
        </a>
<a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 active:bg-slate-50 dark:active:bg-slate-800 tap-highlight-transparent transition-transform active:scale-90 p-2 rounded-lg w-16" href="#">
<span class="material-symbols-outlined mb-1">location_on</span>
            Unidades
        </a>
<a class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 active:bg-slate-50 dark:active:bg-slate-800 tap-highlight-transparent transition-transform active:scale-90 p-2 rounded-lg w-16" href="#">
<span class="material-symbols-outlined mb-1">person</span>
            Perfil
        </a>
</nav>
</body></html>