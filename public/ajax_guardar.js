// Función para obtener el estado guardado del botón del localStorage al cargar la página
window.onload = function() {
    let buttons = document.querySelectorAll('[id^="save"]');
    buttons.forEach(button => {
        let id = button.id.replace('save', '');
        let savedState = localStorage.getItem(`save_${id}`);
        if (savedState === 'true') {
            button.classList.add('true');
        }
    });
};

// Función que se ejecuta al hacer clic en el botón
const guardar = (id_img, id_user) => {
    console.log('id foto: ' + id_img + ', id usuario: ' + id_user);

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Actualizar interfaz
            let respuesta = JSON.parse(this.responseText);
            let btn_save = document.getElementById(`save${id_img}`);
            btn_save.classList.toggle('true'); // Cambia el estado del botón
            // Guardar estado en localStorage
            localStorage.setItem(`save_${id_img}`, btn_save.classList.contains('true'));
            // Modificar apariencia del botón
            modificarEstilo(btn_save, id_img);
        }
    };

    xhr.open('GET', `guardar.php?id=${id_img}&usuario=${id_user}`, true);
    xhr.send();
};


  // Función para guardar el estado del botón en localStorage
  function guardarEstado(idBoton, estado) {
    localStorage.setItem('boton_' + idBoton, estado);
  }

  // Función para cargar el estado del botón desde localStorage
  function cargarEstado(idBoton) {
    return localStorage.getItem('boton_' + idBoton);
  }

  // Función para cambiar el estilo del botón
  function modificarEstilo(boton, idBoton) {
    var estadoGuardado = cargarEstado(idBoton);

    if (estadoGuardado === 'true') {
     
      boton.innerHTML = '<i class="bi bi-save-fill"></i>'; // Cambia el color del botón si ha sido pulsado
    } else {
        boton.innerHTML = '<i class="bi bi-save"></i>';
           }
  }

// Función para modificar la apariencia del botón
const modificar_btn = (idBoton, userId) => {
    var boton = document.getElementById('save' + idBoton);

    // Cambia el estado del botón
    if (cargarEstado(idBoton) === 'true') {
      guardarEstado(idBoton, 'false');
    } else {
      guardarEstado(idBoton, 'true');
    }

    // Modifica el estilo del botón
    modificarEstilo(boton, idBoton);
};

  // Llamamos a la función para modificar el estilo de todos los botones al cargar la página
  window.onload = function() {
    // Obtener todos los botones con ID empezando por 'save'
    var botones = document.querySelectorAll('[id^="save"]');
    // Iterar sobre los botones para modificar su estilo
    botones.forEach(function(boton) {
      var idBoton = boton.getAttribute('id').substring(4); // Obtiene el ID numérico del botón
      modificarEstilo(boton, idBoton);
    });
  };
