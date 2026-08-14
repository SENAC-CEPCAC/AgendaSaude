export function createModalController({
  obterColaboradores,
  obterUsuariosSistema,
  salvarColaboradores,
  salvarUsuariosSistema,
  renderTable
}) {
  function onModalKeydown(event) {
    if (event.key === 'Escape') {
      fecharModal();
    }
  }

  function fecharModal() {
    document.getElementById('cadastrarModal')?.remove();
    document.removeEventListener('keydown', onModalKeydown);
  }

  function abrirModal(modal) {
    document.body.appendChild(modal);
    document.addEventListener('keydown', onModalKeydown);
  }

  function editar(id) {
    const colaboradores = obterColaboradores();
    const usuarios = obterUsuariosSistema();
    const colab = colaboradores[id];

    if (!colab) return;

    fecharModal();

    const modal = document.createElement('div');
    modal.id = 'cadastrarModal';
    modal.className = 'fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
      <div class="bg-white rounded-xl shadow-2xl border border-slate-100 max-w-md w-full p-6 space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
          <h3 class="text-lg font-bold text-slate-800">Alterar Permissão</h3>
          <button type="button" onclick="fecharModal()" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>
        <form id="formAlterarPermissao" class="space-y-3">
          <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Permissão</label>
            <select id="novoNivel" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm">
              <option value="1" ${colab.permissao === 'N1' ? 'selected' : ''}>N1 - Paciente</option>
              <option value="2" ${colab.permissao === 'N2' ? 'selected' : ''}>N2 - Operador</option>
              <option value="3" ${colab.permissao === 'N3' ? 'selected' : ''}>N3 - Colaborador</option>
              <option value="4" ${colab.permissao === 'N4' ? 'selected' : ''}>N4 - Administrador</option>
            </select>
          </div>
          <div class="flex justify-end gap-2 pt-3 border-t">
            <button type="button" onclick="fecharModal()" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-[#00478f] text-white text-xs font-bold rounded-lg hover:bg-[#00366d]">Salvar</button>
          </div>
        </form>
      </div>
    `;

    abrirModal(modal);

    document.getElementById('formAlterarPermissao').addEventListener('submit', (e) => {
      e.preventDefault();
      const nivel = parseInt(document.getElementById('novoNivel').value);

      colab.permissao = `N${nivel}`;

      const idxUser = usuarios.findIndex(u => u.username.toLowerCase() === colab.nome.toLowerCase());
      if (idxUser !== -1) {
        usuarios[idxUser].nivel = nivel;
      }

      salvarColaboradores(colaboradores);
      salvarUsuariosSistema(usuarios);
      renderTable(colaboradores);
      fecharModal();
    });
  }

  function cadastrarColaborador() {
    document.getElementById('cadastrarModal')?.remove();

    const modal = document.createElement('div');
    modal.id = 'cadastrarModal';
    modal.className = 'fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
      <div class="bg-white rounded-xl shadow-2xl border border-slate-100 max-w-md w-full p-6 space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
          <h3 class="text-lg font-bold text-slate-800">Cadastrar Novo Colaborador</h3>
          <button type="button" onclick="fecharModal()" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>
        <form id="formNovoColaborador" class="space-y-3">
          <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Nome / Usuário</label>
            <input type="text" id="novoNome" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm" required>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
            <input type="email" id="novoEmail" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm" required>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Senha</label>
            <input type="password" id="novaSenha" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm" required>
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Permissão</label>
            <select id="novoNivel" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-sm">
              <option value="1">N1 - Paciente</option>
              <option value="2">N2 - Operador</option>
              <option value="3">N3 - Colaborador</option>
              <option value="4">N4 - Administrador</option>
            </select>
          </div>
          <div class="flex justify-end gap-2 pt-3 border-t">
            <button type="button" onclick="fecharModal()" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200">Cancelar</button>
            <button type="submit" class="px-4 py-2 bg-[#00478f] text-white text-xs font-bold rounded-lg hover:bg-[#00366d]">Salvar</button>
          </div>
        </form>
      </div>
    `;

    abrirModal(modal);

    document.getElementById('formNovoColaborador').addEventListener('submit', (e) => {
      e.preventDefault();
      const nome = document.getElementById('novoNome').value.trim();
      const email = document.getElementById('novoEmail').value.trim();
      const senha = document.getElementById('novaSenha').value;
      const nivel = parseInt(document.getElementById('novoNivel').value);

      const colaboradores = obterColaboradores();
      const usuarios = obterUsuariosSistema();

      colaboradores.push({
        nome: nome,
        permissao: `N${nivel}`,
        email: email,
        ativo: true
      });

      usuarios.push({
        username: nome.toLowerCase(),
        password: senha,
        nivel: nivel,
        ativo: true
      });

      salvarColaboradores(colaboradores);
      salvarUsuariosSistema(usuarios);
      renderTable(colaboradores);

      fecharModal();
    });
  }

  return {
    fecharModal,
    editar,
    cadastrarColaborador
  };
}
