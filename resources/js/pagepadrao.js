
        lucide.createIcons();


        const colaboradores = [
            { nome: "Gabriel", matricula: "111.222.333-44", email: "gabriel@email.com" },
            { nome: "Mateus", matricula: "111.222.333-44", email: "mateus@email.com" },
            { nome: "William", matricula: "111.222.333-44", email: "william@email.com" },
            { nome: "Rafael", matricula: "111.222.333-44", email: "rafael@email.com" },
            { nome: "Isabela", matricula: "111.222.333-44", email: "isabela@email.com" },
            { nome: "Vinicius", matricula: "111.222.333-44", email: "vinicius@email.com" }
        ];

        // Função para renderizar a tabela
        function renderTable(data) {
            const tbody = document.getElementById('colaboradoresTable');
            tbody.innerHTML = '';

            data.forEach((colab, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="col-name">${colab.nome}</td>
                    <td>${colab.matricula}</td>
                    <td>${colab.email}</td>
                    <td>
                        <div class="actions-cell">
                            <button class="btn-action" onclick="desativar(${index})">
                                <i data-lucide="calendar-check"></i> Desativar
                            </button>
                            <button class="btn-action" onclick="editar(${index})">
                                <i data-lucide="calendar-check"></i> Editar
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            
            // Recarrega os ícones dinâmicos inseridos via JavaScript
            lucide.createIcons();
        }

        // Função de busca simples
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const filtered = colaboradores.filter(c => 
                c.nome.toLowerCase().includes(query) || 
                c.matricula.includes(query) || 
                c.email.toLowerCase().includes(query)
            );
            renderTable(filtered);
        });

        // Ações mockadas para simulação
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

        // Renderização inicial
        renderTable(colaboradores);
    