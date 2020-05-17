
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
      if(confirm !== false) {
        let data = {
          autor: document.getElementById('opinion_form_autor').value,
          comentario: document.getElementById('opinion_form_comentario').value,
          ciudad: document.getElementById('opinion_form_ciudad').value,
        }
      
        fetch(`/opiniones/${id}/editar`, {
          method: "POST",
          body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then((datosActualizados) => {
          btnEditar[i].parentNode.parentNode.childNodes[3].innerText = datosActualizados.autor;
          btnEditar[i].parentNode.parentNode.childNodes[5].innerText = datosActualizados.ciudad;
          btnEditar[i].parentNode.parentNode.childNodes[7].innerText = datosActualizados.comentario;
          document.getElementById('opinion_form_autor').parentNode.parentNode.reset();
        });
      } else {
        return;
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
        fetch(`/opiniones/${id}/borrar`, {
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