
let btnBorrar = document.getElementsByClassName("btnBorrar");

for(let i = 0; i < btnBorrar.length; i++) {
  
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