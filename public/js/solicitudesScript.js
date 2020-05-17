let politica = document.getElementById('user_form_politica');
politica.parentNode.remove();


let btnEditar = document.getElementsByClassName("btnEdit");

let btnBorrar = document.getElementsByClassName("btnBorrar");

for(let i = 0; i < btnBorrar.length; i++) {

  btnEditar[i].addEventListener("click", (e) => {
    let id = e.target.id;

    let editar = (callback) => {
      $('#btnEditar').on('click', () => {
        callback(true);
      });

      $('#btnCancelarEdit').on('click', () => {
        callback(false);
      });
    }

    editar((confirm) => {
      if(confirm) {
        let data = {
          nombre: document.getElementById('user_form_nombre').value,
          email: document.getElementById('user_form_email').value,
          ciudad: document.getElementById('user_form_ciudad').value,
        }
      
        fetch(`/solicitudes/${id}/editar`, {
          method: "POST",
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then((datosActualizados) => {
          btnEditar[i].parentNode.parentNode.childNodes[3].innerText = datosActualizados.nombre;
          btnEditar[i].parentNode.parentNode.childNodes[5].innerText = datosActualizados.email;
          btnEditar[i].parentNode.parentNode.childNodes[7].innerText = datosActualizados.ciudad;
          document.getElementById('user_form_nombre').parentNode.parentNode.reset();
        });
      }
    });
  });
  
  btnBorrar[i].addEventListener("click", (e) => {
    let id = e.target.id;

    let borrar = (callback) => {
      $("#btnAceptar").on("click", function(){
        callback(true);
      });
    
      $("#btnCancelar").on("click", function(){
        callback(false);
      });
    }

    borrar((confirm) => {
      if(confirm) {
        fetch(`/solicitudes/${id}/borrar`, {
          method: "POST",
          body: JSON.stringify(id)
        })
        .then(response => response.json())
        .then(() => {
          btnBorrar[i].parentElement.parentElement.style.display = "none";
        });
      }
    });
  });
}