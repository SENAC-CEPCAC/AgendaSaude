function inicializarUploadPreview({
    inputId,
    placeholderId,
    previewContainerId,
    previewImgId,
    fileInfoId,
    fileNameId,
    fileSizeId,
    btnRemoverId
}) {
    const input = document.getElementById(inputId);
    const placeholder = document.getElementById(placeholderId);
    const previewContainer = document.getElementById(previewContainerId);
    const previewImg = document.getElementById(previewImgId);
    const fileInfo = document.getElementById(fileInfoId);
    const fileName = document.getElementById(fileNameId);
    const fileSize = document.getElementById(fileSizeId);
    const btnRemover = document.getElementById(btnRemoverId);

    if (!input) return;

    input.addEventListener('change', (evento) => {
        const arquivo = evento.target.files[0];

        if (arquivo) {
            // Se for imagem
            if (arquivo.type.startsWith('image/')) {
                const leitor = new FileReader();

                leitor.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    if (fileInfo) fileInfo.classList.add('hidden');

                    // Mostra container do preview e esconde placeholder
                    placeholder.classList.add('hidden');
                    previewContainer.classList.remove('hidden');

                    // Reinicia a animação com reflow
                    previewImg.classList.remove('animado');
                    void previewImg.offsetWidth;
                    previewImg.classList.add('animado');
                };

                leitor.readAsDataURL(arquivo);
            } else {
                // Se for outro arquivo (como PDF)
                previewImg.classList.add('hidden');
                if (fileInfo) {
                    fileInfo.classList.remove('hidden');
                    fileName.textContent = arquivo.name;
                    fileSize.textContent = (arquivo.size / (1024 * 1024)).toFixed(2) + ' MB';
                }

                placeholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');

                previewContainer.classList.remove('animado');
                void previewContainer.offsetWidth;
                previewContainer.classList.add('animado');
            }
        }
    });

    // Botão de remover arquivo
    btnRemover?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        input.value = '';
        previewImg.src = '';
        previewImg.classList.remove('animado');
        previewContainer.classList.add('hidden');
        placeholder.classList.remove('hidden');
    });
}

function inicializarEtapa3() {
    // Inicializa para RG/CPF
    inicializarUploadPreview({
        inputId: 'input-rg-cpf',
        placeholderId: 'placeholder-rg-cpf',
        previewContainerId: 'preview-container-rg-cpf',
        previewImgId: 'preview-img-rg-cpf',
        fileInfoId: 'file-info-rg-cpf',
        fileNameId: 'file-name-rg-cpf',
        fileSizeId: 'file-size-rg-cpf',
        btnRemoverId: 'btn-remover-rg-cpf'
    });

    // Inicializa para Requisição Médica
    inicializarUploadPreview({
        inputId: 'input-requisicao',
        placeholderId: 'placeholder-requisicao',
        previewContainerId: 'preview-container-requisicao',
        previewImgId: 'preview-img-requisicao',
        fileInfoId: 'file-info-requisicao',
        fileNameId: 'file-name-requisicao',
        fileSizeId: 'file-size-requisicao',
        btnRemoverId: 'btn-remover-requisicao'
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarEtapa3);
} else {
    inicializarEtapa3();
}
