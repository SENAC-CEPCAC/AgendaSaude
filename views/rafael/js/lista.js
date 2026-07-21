lucide.createIcons();

const colaboradores = [
    { nome: "Gabriel", matricula: "111.222.333-44", email: "gabriel@email.com" },
    { nome: "Mateus", matricula: "111.222.333-44", email: "mateus@email.com" },
    { nome: "William", matricula: "111.222.333-44", email: "william@email.com" },
    { nome: "Rafael", matricula: "111.222.333-44", email: "rafael@email.com" },
    { nome: "Isabela", matricula: "111.222.333-44", email: "isabela@email.com" },
    { nome: "Vinicius", matricula: "111.222.333-44", email: "vinicius@email.com" }
];

function renderTable(data) {
    const tbody = document.getElementById('colaboradoresTable');
    tbody.innerHTML = '';

    data.forEach((colab, index) => {
        const tr = document.createElement('tr');
        tr.className = "hover:bg-slate-50/50 transition-colors";
        tr.innerHTML = `
            <td class="py-4 px-6 font-bold text-slate-800">${colab.nome}</td>
            <td class="py-4 px-6 text-slate-500">${colab.matricula}</td>
            <td class="py-4 px-6 text-slate-500">${colab.email}</td>
            <td class="py-4 px-6">
                <div class="flex items-center justify-center gap-2">
                    <button class="bg-[#00478f] hover:bg-[#00366d] text-white text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5 px-3 py-2 rounded-lg shadow-sm transition-all cursor-pointer" onclick="desativar(${index})">
                        <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i> Desativar
                    </button>
                    <button class="bg-[#00478f] hover:bg-[#00366d] text-white text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5 px-3 py-2 rounded-lg shadow-sm transition-all cursor-pointer" onclick="editar(${index})">
                        <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i> Editar
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
        
    lucide.createIcons();
}

document.getElementById('searchInput').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const filtered = colaboradores.filter(c => 
        c.nome.toLowerCase().includes(query) || 
        c.matricula.includes(query) || 
        c.email.toLowerCase().includes(query)
    );
    renderTable(filtered);
});

function desativar(id) {
    alert("Desativar colaborador: " + colaboradores[id].nome);
}

function editar(id) {
    alert("Editar colaborador: " + colaboradores[id].nome);
}

function cadastrarColaborador() {
    alert("Abrir modal de cadastro");
}

function mudarPagina(direcao) {
    alert("Mudar página: " + direcao);
}

renderTable(colaboradores);