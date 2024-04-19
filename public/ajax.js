const dar_like = (id_imagen, id_usuario)=>{
console.log(id_usuario);

let xhr = new XMLHttpRequest();

xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        // actualiza la cantidad de likes en la pagina
        console.log('servidor '+this.responseText);
        document.getElementById('likes_'+id_imagen).innerHTML = this.responseText; //respuesta del servidor
        
    }
};

xhr.open("GET", `dar_like.php?id=${id_imagen}&usuario=${id_usuario}`, true);
xhr.send();

};