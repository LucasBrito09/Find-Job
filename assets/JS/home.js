const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

// show sidebar
menuBtn.addEventListener('click', () => {
    sideMenu.classList.add('aside-menu-show');
})

// close sidebar
closeBtn.addEventListener('click', () => {
    sideMenu.classList.remove('aside-menu-show');
})


const settingOpen = document.querySelector('.open-setting');
const settingOpenAlerta = document.querySelector('.alerta-configuracao');
const settingBtn = document.querySelectorAll('.configuracao-diretorio-btn');
const settingBtnClose = document.querySelectorAll('.configuracao-btn-close');

settingOpen.addEventListener('click', ()=>{
    settingOpenAlerta.classList.add('alerta-configuracao-active')
})
settingBtnClose[0].addEventListener('click', ()=>{
    settingOpenAlerta.classList.remove('alerta-configuracao-active')
})
settingBtnClose[1].addEventListener('click', ()=>{
    settingOpenAlerta.classList.remove('alerta-configuracao-active')
})

settingBtn.forEach(element => {
    element.addEventListener('click',(e)=>{
        let valueClassSetting = e.target.dataset.id
        document.querySelector(`.configuracao-${valueClassSetting}`);

        if(valueClassSetting == "password"){
            document.querySelector(`.configuracao-password`).classList.add('configuracao-form-active')
            document.querySelector(`.configuracao-setting`).classList.remove('configuracao-form-active')
            document.querySelector(`.config-password`).classList.add('configuracao-diretorio-btn-active')
            document.querySelector(`.config-setting`).classList.remove('configuracao-diretorio-btn-active')
        }else{
            document.querySelector(`.configuracao-password`).classList.remove('configuracao-form-active')
            document.querySelector(`.configuracao-setting`).classList.add('configuracao-form-active')
            document.querySelector(`.config-password`).classList.remove('configuracao-diretorio-btn-active')
            document.querySelector(`.config-setting`).classList.add('configuracao-diretorio-btn-active')
        }
    })
})
function copiarLinkVaga() {
    /* Selecionamos por ID o nosso input */
    var textoCopiado = document.getElementById("linkvaga");
    /* Deixamos o texto selecionado (em azul) */
    textoCopiado.select();
    textoCopiado.setSelectionRange(0, 99999); /* Para mobile */
  
    /* Copia o texto que está selecionado */
    document.execCommand("copy");
  
    swal("Sucesso!", "Link da vaga copiado com sucesso");
  }
const partilhar = document.querySelectorAll('.partilharVagaEmprego');
partilhar.forEach((element)=>{
    element.addEventListener('click', (e)=>{
        let id = e.target.dataset.id;
        let urlPartilhamento = window.location.protocol + "//" + window.location.host + "/vaga.php?id="+ id;
        document.getElementById("linkvaga").value = urlPartilhamento;
        copiarLinkVaga();
    })
})