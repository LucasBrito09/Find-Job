function openViewCurriculo(src) {
    document.querySelector('.view-curriculo-img').src = `UPLOAD/curriculo/${src}`;
    document.querySelector('.view-curriculo').classList.add('view-curriculo-active')
}
document.querySelector('.view-curriculo-close').addEventListener('click', ()=>{
    document.querySelector('.view-curriculo').classList.remove('view-curriculo-active')
})
document.querySelector('.view-curriculo-btnClose').addEventListener('click', ()=>{
    document.querySelector('.view-curriculo').classList.remove('view-curriculo-active')
})