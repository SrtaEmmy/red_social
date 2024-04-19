document.addEventListener('DOMContentLoaded', ()=>{

    const btn_publicar = document.getElementById('btn_publicar');
    const textarea = document.getElementById('textarea');

    // mostrar el boton si se pulsa en el textarea
    textarea.addEventListener('click', ()=>{
        console.log('se ha pulsado el textarea');
        btn_publicar.classList.remove('hide');
    });

    // ocultar el boton 
    document.addEventListener('click', (e)=>{
        if (e.target !== textarea && e.target !== btn_publicar) {
            btn_publicar.classList.add('hide');
        }
    })


// boton mensaje
let envelope = document.getElementById('envelope');
// Seleccionar el elemento con la clase chat_contactos
let chatContactos = document.querySelector('.chat_contactos');

// Agregar evento click al botón
envelope.addEventListener('click', () => {
    // Alternar la clase activeAnimation en el elemento chat_contactos
    chatContactos.classList.toggle('activeAnimation');
});





});
// comentarios
const show_coments = (id_post)=>{
    let caja = document.getElementById('caja'+id_post);
    // console.log(caja);

    caja.classList.toggle('hide_comentarios');
};



