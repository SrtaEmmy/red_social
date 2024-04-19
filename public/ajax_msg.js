// obtener datos de los formularios y evitar el envio por defecto
const forms = document.querySelectorAll('.form');

forms.forEach(form => {
    form.addEventListener('submit', (e)=>{
        e.preventDefault();

        const mensaje = form.querySelector('input[name="message"]').value;
        const id_destinatario = form.querySelector('input[name="id_destinatario"]').value;

        console.log(mensaje);
        console.log(id_destinatario);

        enviarMensaje(mensaje, id_destinatario, form);
    });
});


function enviarMensaje(msg, destinatario, formulario) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax_msg.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status == 200) {
            // actualizar interfaz: mostrar mensajes nuevos
            const container_msgs = document.getElementById(`container_messages${destinatario}`);
            let p = document.createElement('p');
            p.className = "msg-right m-4" //clase para css

            let span = document.createElement('span');
            span.className = "bg_right";
            span.textContent = msg;
            p.appendChild(span);
            container_msgs.appendChild(p);

            // desplazar el chat hacia abajo para que se muestre siempre el ultimo mensaje enviado
            const chats = document.querySelectorAll('.content_all_messages');
            chats.forEach(chat => {
                chat.scrollTop = chat.scrollHeight;
            });

            formulario.querySelector('input[name="message"]').value = '';

        }
    }
    xhr.send(`message=${msg}&id_destinatario=${destinatario}`);

}






