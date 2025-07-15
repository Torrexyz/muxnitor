// Access for student
function showGoogleLogin(buttonNode) {
  const parentNode = buttonNode.parentNode;
  parentNode.style.transform = "scale(0)";

  setTimeout(() => {
    parentNode.innerHTML = `
      <b>
        INGRESO CON
        <span style="background:white;border-radius:5px">
          <span>&nbsp;</span>
          <span style="color: #4285F4">G</span><span style="color: #EA4335">O</span><span style="color: #FBBC05">O</span><span style="color: #4285F4">G</span><span style="color: #34A853">L</span><span style="color: #EA4335">E</span>
          <span>&nbsp;</span>
        </span>
      </b>
    `;
    parentNode.innerHTML+= `
      <button class="default" type="button" onclick="window.location.href='${googleAuthUrl}'">
        <img style="width:30px;height:30px" src="/resources/icon-google.webp">
        <span>&nbsp;</span>
        Iniciar sesión
      </button>
    `;
    parentNode.style.transform = "scale(1)";
  }, 200);
}

// Access for admin
function showFormLogin(buttonNode) {
  const parentNode = buttonNode.parentNode;
  parentNode.style.transform = "scale(0)";

  setTimeout(() => {
    parentNode.innerHTML = `
      <b>
        INGRESO CON
        <span style="background:white;border-radius:5px">
          <span>&nbsp;</span>
          CREDENCIALES
          <span>&nbsp;</span>
        </span>
      </b>
    `;
    parentNode.innerHTML+= `
      <div class="inputbox">
        <p>Usuario</p>
        <input type="text" name="admin-user">
      </div>
      <div class="inputbox">
        <p>Contraseña</p>
        <input type="password" name="admin-password">
      </div>
      <button style="transform:translateY(30px) scale(0.9)" class="default" type="submit" name="admin-login">VALIDAR</button>
    `;
    parentNode.style.transform = "scale(1)";
  }, 200);
}
