
let formDemo = document.getElementById("form-demo"); 

formDemo.addEventListener("submit", function (e) {
  
  let data = {
    nombre: document.getElementById("user_form_nombre").value,
    email: document.getElementById("user_form_email").value,
    ciudad: document.getElementById("user_form_ciudad").value,
  } 

  let mensajeBox = document.getElementById("msgDemo");
  let iconoMsg = document.getElementById("icono-msg");
  let spanBox = document.getElementById("panMsg");
    
    fetch("/newDemo", {
      method: "POST",
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(content => {

      mensajeBox.style.display = "inline-block";
      mensajeBox.classList.remove("alert-danger");
      mensajeBox.classList.add("alert-success");
      iconoMsg.classList.remove("fa-times-circle");
      iconoMsg.classList.add("fa-check");
      spanBox.innerHTML = content.msg;
      formDemo.reset();
      
    })
    .catch( () => {
      mensajeBox.style.display = "inline-block";
      mensajeBox.classList.remove("alert-success");
      mensajeBox.classList.add("alert-danger");
      iconoMsg.classList.remove("fa-success");
      iconoMsg.classList.add("fa-times-circle");
      spanBox.innerHTML = "Ha ocurrido un error! Inténtelo de nuevo";
    });

    e.preventDefault();
});
  