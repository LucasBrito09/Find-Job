//selecting all required elements
const dropArea = document.querySelector(".drag-area"),
    dragText = dropArea.querySelector(".drag-area-h2"),
    button = dropArea.querySelector(".drag-area-btn"),
    input = dropArea.querySelector("#imagem_curriculo"),
    imagensAdd = document.querySelector('.upload-arquivos-add-criados');
let file; //this is a global variable and we'll use it inside multiple functions

button.onclick = () => {
    input.click(); //if user click on the button then the input also clicked
}

input.addEventListener("change", function () {
    //getting user select file and [0] this means if user select multiple files then we'll select only the first one
    file = this.files[0];
    dropArea.classList.add("active");
    showFile(); //calling function
});


//If user Drag File Over DropArea
dropArea.addEventListener("dragover", (event) => {
    event.preventDefault(); //preventing from default behaviour
    dropArea.classList.add("active");
    dragText.textContent = "Liberar para fazer upload do arquivo";
});

//If user leave dragged File from DropArea
dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("active");
    dragText.textContent = "Selecione o arquivo ou arraste e solte";
});

//If user drop File on DropArea
dropArea.addEventListener("drop", (event) => {
    event.preventDefault(); //preventing from default behaviour
    //getting user select file and [0] this means if user select multiple files then we'll select only the first one
    file = event.dataTransfer.files[0];
    showFile(); //calling function
});

function showFile() {
    let fileType = file.type; //getting selected file type
    let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
    if (validExtensions.includes(fileType)) { //if user selected file is an image file
        let fileReader = new FileReader(); //creating new FileReader object
        fileReader.onload = () => {
            let fileURL = fileReader.result; //passing user file source in fileURL variable
            // UNCOMMENT THIS BELOW LINE. I GOT AN ERROR WHILE UPLOADING THIS POST SO I COMMENTED IT
            //let imgTag = `<img src="${fileURL}" alt="image">`; //creating an img tag and passing user selected file source inside src attribute
            //dropArea.innerHTML = imgTag; //adding that created img tag inside dropArea container
            let tamanho = (file.size / 1024).toFixed(0);
            imagensAdd.innerHTML = `<div class="upload-arquivos-add-criados-div">
                            <div class="upload-arquivos-add-criados-informacoes"><i class="fa-solid fa-file-image"></i><span>${file.name}</span><span class="arquivo-tamanho">${tamanho}KB</span></div>
                            <div class="upload-arquivos-add-criados-delete" onclick="removerImagemCarregada()"><span>Remover</span></div>
                        </div>`;

        }
        fileReader.readAsDataURL(file);
    } else {
        alert("This is not an Image File!");
        dropArea.classList.remove("active");
        dragText.textContent = "Selecione o arquivo ou arraste e solte";
    }
}
function removerImagemCarregada(){
    imagensAdd.innerHTML = '';
}