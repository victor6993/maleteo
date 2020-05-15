let msgBox = document.createElement('div');
msgBox.classList.add("isa_success");
msgBox.style.display = "none";
let icono = document.createElement('i');
icono.classList.add("fa", "fa-check");
let mensaje = document.createElement('h4');
mensaje.style.display = "inline";

let demoBox = document.getElementById("demo-box");
let div = demoBox.parentNode;
msgBox.appendChild(icono);
msgBox.appendChild(mensaje);
// let contacto = document.querySelector(".contacto");
// div.insertBefore(msgBox,demoBox);
demoBox.appendChild(msgBox);
let formDemo = document.getElementById("form-demo"); 

// contacto.appendChild(msgBox);

document.querySelector(".form-btn")
.addEventListener("click", function (e) {
  
  let nombre = document.getElementById("user_form_nombre");
  let email = document.getElementById("user_form_email");
  let ciudad = document.getElementById("user_form_ciudad");
  let data = {
    nombre: nombre.value,
    email: email.value,
    ciudad: ciudad.value,
  }  
  
  if(data.nombre !== "" && data.email !== "" && data.ciudad !== "") {
    console.log(data);
    
    fetch("/newDemo", {
      method: "POST",
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(content => {
      
      msgBox.style.display = "flex";
      msgBox.style.alignItems="center";
      mensaje.innerHTML = content.msg;
      formDemo.reset();
      
    }
    );
  }
  
  e.preventDefault();

});
