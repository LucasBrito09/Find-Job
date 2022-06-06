const btnAcoes = document.querySelectorAll('.container-btn-acoes button');
const conteudoCadastradas = document.querySelector('.container-vagas-cadastradas');
const conteudoCandidatadas = document.querySelector('.container-vagas-candidatadas');
const paragrafo = document.querySelector('.container-paragrafo');

btnAcoes.forEach((element) => {
    element.addEventListener('click', (e) => {
        let elementBtn = e.target;

        if (elementBtn.dataset.id == 0) {
            btnAcoes[0].classList.add('active');
            btnAcoes[1].classList.remove('active');
            conteudoCadastradas.classList.add('container-vagas-active');
            conteudoCandidatadas.classList.remove('container-vagas-active');
            paragrafo.innerHTML = "Veja abaixo todas as vagas que você cadastrou em nosso sistema";
        } else {
            btnAcoes[0].classList.remove('active');
            btnAcoes[1].classList.add('active');
            conteudoCadastradas.classList.remove('container-vagas-active');
            conteudoCandidatadas.classList.add('container-vagas-active');
            paragrafo.innerHTML = "Veja abaixo todas as vagas que você enviou seu currículo";
        }

    })
})

const postagens = document.querySelectorAll('.deletar-vaga');

postagens.forEach((element)=>{
    element.addEventListener('click', (e)=>{
        let elementPostagem = e.target;
        swal({
            title: "Tem certeza?",
            text: "Uma vez excluído, você não poderá recuperar os dados dessa vaga!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {    
               window.location.href = "PAGES/VAGA/deletar_vaga.php?id="+ elementPostagem.dataset.id;
            } else {
              swal("Sua postagem está seguro!");
            }
          });
    })
})