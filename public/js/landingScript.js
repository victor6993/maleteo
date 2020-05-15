let msgBox = document.createElement('div');
msgBox.classList.add("isa_success");
msgBox.style.display = "none";
let icono = document.createElement('i');
icono.classList.add("fa", "fa-check");
let mensaje = document.createElement('h4');
mensaje.style.display = "inline";
msgBox.appendChild(icono);
msgBox.appendChild(mensaje);

let demoBox = document.getElementById("demo-box");
demoBox.appendChild(msgBox);

// let contacto = document.querySelector(".contacto");
// div.insertBefore(msgBox,demoBox);

let formDemo = document.getElementById("form-demo"); 

// contacto.appendChild(msgBox);

formDemo.addEventListener("submit", function (e) {
  
  let data = {
    nombre: document.getElementById("user_form_nombre").value,
    email: document.getElementById("user_form_email").value,
    ciudad: document.getElementById("user_form_ciudad").value,
  } 
    
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
    
    e.preventDefault();
    
});
  