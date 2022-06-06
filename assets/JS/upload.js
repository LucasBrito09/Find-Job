const dropArea = document.querySelector(".drag-area"),
    dragText = dropArea.querySelector(".drag-area-h2"),
    button = dropArea.querySelector(".drag-area-btn"),
    input = dropArea.querySelector("#imagem_curriculo"),
    imagensAdd = document.querySelector('.upload-arquivos-add-criados');
let file; 

button.onclick = () => {
    input.click(); 
}

input.addEventListener("change", function () {
    file = this.files[0];
    dropArea.classList.add("active");
    showFile();
});



dropArea.addEventListener("dragover", (event) => {
    event.preventDefault(); 
    dropArea.classList.add("active");
    dragText.textContent = "Liberar para fazer upload do arquivo";
});


dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("active");
    dragText.textContent = "Selecione o arquivo ou arraste e solte";
});


dropArea.addEventListener("drop", (event) => {
    event.preventDefault(); 
    file = event.dataTransfer.files[0];
    showFile();
});

function showFile() {
    let fileType = file.type; 
    let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; 
    if (validExtensions.includes(fileType)) { 
        let fileReader = new FileReader(); 
        fileReader.onload = () => {
            let fileURL = fileReader.result;
            let tamanho = (file.size / 1024).toFixed(0);
            imagensAdd.innerHTML = `<div class="upload-arquivos-add-criados-div">
                            <div class="upload-arquivos-add-criados-informacoes"><i class="fa-solid fa-file-image"></i><span>${file.name}</span><span class="arquivo-tamanho">${tamanho}KB</span></div>
                            <div class="upload-arquivos-add-criados-delete"><span>Remover</span></div>
                        </div>`;

        }
        fileReader.readAsDataURL(file);
    } else {
        alert("This is not an Image File!");
        dropArea.classList.remove("active");
        dragText.textContent = "Selecione o arquivo ou arraste e solte";
    }
}