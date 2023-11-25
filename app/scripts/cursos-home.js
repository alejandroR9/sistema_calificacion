const nivel = document.getElementById('nivel')
const periodo = document.getElementById('periodo')
const idAlumno = document.getElementById('login')
/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtnerRegistros = async (search = "") => {
    let body = "";
    const options = {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    };
    const respuesta = await fetch(
      `./app/entidades/cursos/http.php/?periodo_id=${periodo.value}&nivel_id=${nivel.value}&alumno_id=${idAlumno.value}`,
      options
    );
    const respuestaData = await respuesta.json();
    if (respuestaData.data.length <= 0) {
      Swal.fire({
        icon: "warning",
        title: "Datos vacios",
        text: "Parece que no tienes  cursos registrados",
      });
    } else {
        console.log(respuestaData.data);
      respuestaData.data.forEach((item) => {
        body += `
        <article class="main-curso">
            <header class="header-curso">
                <img src="${item.foto === null?'./assets/imagenes/default.webp':item.foto}">
            </header>
            <div class="contenido-del-curso">
                <h2 class="titulo-del-curso">${item.nombre}</h2>
                
                <a href="./contenido.php?key=${item.id}&nombre=${item.nombre}" class="boton-del-curso">
                    Ir al curso
                </a>
            </div>
        </article>
          `;
      });
      document.getElementById("curso").innerHTML = body;
    }
  };

  

  window.onload = async () => {
    await obtnerRegistros()
  }