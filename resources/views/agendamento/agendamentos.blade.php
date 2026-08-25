@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout>


    {{--
    resources/views/agendamentos/index.blade.php

    Tela "Agendamentos" - Agenda Saúde
    Requer Tailwind CSS configurado no projeto (via Vite) e a fonte padrão do Tailwind.
    Os agendamentos podem vir de um controller (ex: AgendamentoController@index) via
    variável $agendamentos. Um fallback estático é usado caso a variável não exista,
    apenas para facilitar a visualização da tela.
--}}
    @extends('layouts.app')

    @section('content')

    @php
    // Fallback estático apenas para preview da tela.
    // Substitua por dados vindos do controller: return view('agendamentos.index', compact('agendamentos'));
    $agendamentos = $agendamentos ?? [
    [
    'especialidade' => 'Clínica Geral',
    'data' => '24 OUT 2023',
    'hora' => '14:30',
    'status' => 'confirmado', // confirmado | espera | cancelado
    'unidade' => 'Unidade Móvel Centro',
    'endereco' => 'Praça da Matriz, ao lado do coreto',
    ],
    [
    'especialidade' => 'Odontologia',
    'data' => '05 NOV 2023',
    'hora' => '09:00',
    'status' => 'espera',
    'unidade' => 'Unidade Móvel Norte',
    'endereco' => 'Terminal Rodoviário, Setor B',
    ],
    ];
    @endphp


    <div class="min-h-screen bg-slate-50 pb-24">


        {{-- Header --}}
        <header class="sticky top-0 z-20 bg-white border-b border-slate-100">
            <div class="max-w-md mx-auto flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/avatar-placeholder.png') }}"
                        alt="Foto do usuário"
                        class="w-9 h-9 rounded-full object-cover ring-1 ring-slate-200">
                    <h1 class="text-lg font-bold text-blue-900">Agendamentos</h1>
                </div>

                <button type="button" class="relative p-1 text-slate-500 hover:text-slate-700" aria-label="Notificações">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </button>
            </div>
        </header>

        <main class="max-w-md mx-auto px-4 pt-4">

            {{-- Aviso importante --}}
            <div class="flex gap-3 bg-slate-100 border border-slate-200 rounded-xl p-4 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-slate-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <div class="text-sm text-slate-600 leading-relaxed">
                    <p class="font-semibold text-slate-700 mb-1">AVISO IMPORTANTE</p>
                    <p>
                        Cancelamentos ou remarcações devem ser feitos com no mínimo
                        <strong class="font-semibold text-slate-700">24 horas de antecedência</strong>
                        para liberar a vaga para outro paciente.
                    </p>
                </div>
            </div>

            {{-- Lista de agendamentos --}}
            <div class="space-y-4">
                @foreach ($agendamentos as $agendamento)
                @php
                $statusConfig = [
                'confirmado' => [
                'border' => 'border-l-blue-900',
                'badge' => 'bg-blue-50 text-blue-900',
                'label' => 'CONFIRMADO',
                'icon' => 'check',
                ],
                'espera' => [
                'border' => 'border-l-amber-400',
                'badge' => 'bg-amber-50 text-amber-600',
                'label' => 'EM ESPERA',
                'icon' => 'clock',
                ],
                'cancelado' => [
                'border' => 'border-l-red-400',
                'badge' => 'bg-red-50 text-red-500',
                'label' => 'CANCELADO',
                'icon' => 'x',
                ],
                ][$agendamento['status']];
                @endphp

                <article class="bg-white rounded-xl border border-slate-100 border-l-4 {{ $statusConfig['border'] }} shadow-sm p-4">

                    {{-- Data / status --}}
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span>{{ $agendamento['data'] }} • {{ $agendamento['hora'] }}</span>
                        </div>

                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $statusConfig['badge'] }}">
                            @if($statusConfig['icon'] === 'check')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                            </svg>
                            @elseif($statusConfig['icon'] === 'clock')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .27.136.523.362.671l3.5 2.3a.75.75 0 0 0 .826-1.253l-3.188-2.093V5Z" clip-rule="evenodd" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 8.586l4.293-4.293a1 1 0 1 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 1.414-1.414L10 8.586Z" clip-rule="evenodd" />
                            </svg>
                            @endif
                            {{ $statusConfig['label'] }}
                        </span>
                    </div>

                    {{-- Especialidade --}}
                    <h2 class="text-base font-bold text-slate-800 mb-3">{{ $agendamento['especialidade'] }}</h2>

                    {{-- Local --}}
                    <div class="flex items-start gap-2 bg-slate-50 rounded-lg p-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-slate-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <div class="text-sm text-slate-600 leading-snug">
                            <p class="font-semibold text-slate-700">{{ $agendamento['unidade'] }}</p>
                            <p>{{ $agendamento['endereco'] }}</p>
                        </div>
                    </div>

                    <hr class="border-slate-100 mb-3">

                    {{-- Ações --}}
                    <div class="flex items-center gap-3">
                        <form action="{{ route('agendamento.remarcar', $agendamento['id'] ?? 0) }}" method="GET" class="flex-1">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 text-sm font-medium text-slate-700 border border-slate-200 rounded-lg py-2 hover:bg-slate-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                Remarcar
                            </button>
                        </form>

                        <form action="{{ route('agendamentos.cancelar', $agendamento['id'] ?? 0) }}" method="POST"
                            onsubmit="return confirm('Tem certeza que deseja cancelar este agendamento?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-1.5 text-sm font-medium text-red-500 hover:text-red-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Cancelar
                            </button>
                        </form>
                    </div>
                </article>
                @endforeach
            </div>
        </main>

        {{-- Bottom navigation --}}
        <nav class="fixed bottom-0 inset-x-0 z-20 bg-white border-t border-slate-100">
            <div class="max-w-md mx-auto grid grid-cols-4">
                @php
                $navItems = [
                ['label' => 'Início', 'route' => 'inicio', 'active' => request()->routeIs('inicio')],
                ['label' => 'Agenda', 'route' => 'agendamentos', 'active' => request()->routeIs('agendamentos*')],
                ['label' => 'Histórico', 'route' => 'historico', 'active' => request()->routeIs('historico')],
                ['label' => 'Perfil', 'route' => 'perfil', 'active' => request()->routeIs('perfil')],
                ];
                @endphp

                @foreach ($navItems as $item)
                <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                    class="flex flex-col items-center gap-1 py-2.5 text-xs font-medium
                          {{ $item['active'] ? 'text-blue-900' : 'text-slate-400' }}">

                    <span class="{{ $item['active'] ? 'bg-blue-100 rounded-lg px-3 py-1' : '' }}">
                        @switch($item['label'])
                        @case('Início')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        @break
                        @case('Agenda')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        @break
                        @case('Histórico')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                        </svg>
                        @break
                        @case('Perfil')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        @break
                        @endswitch
                    </span>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </div>
        </nav>        

    </div>

    @endsection

</x-layout>