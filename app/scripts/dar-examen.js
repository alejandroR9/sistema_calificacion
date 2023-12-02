const enviar = document.getElementById("enviar");
const idExamen = document.getElementById("key");
const idAlumno = document.getElementById("login");

//PAGINANDO PREGUNTAS
const siguiente = document.getElementById("siguiente");

let tiempoRestante = 0;
let tiempoDefinido = 0;
let setTime = null;

/******************************************************************
 * Funcion para insertar
 ******************************************************************/
const insertar = async (data) => {
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  };
  const response = await fetch("./app/entidades/dar-examen/http.php", options);
  const responseData = await response.json();
  if (responseData.message === "success") {
    Swal.fire({
      icon: "success",
      title: "Examen enviado",
      text: "Tu examen a sido enviado de forma satisfactoria",
    });
    await obtnerResultados(idExamen.value, idAlumno.value);
    $("#exampleModal").modal("hide");
  } else if (responseData.message === "error") {
    Swal.fire({
      icon: "error",
      title: "Error al enviar examen",
      text: "No podemos enviar tu examen debido a que hemos tenido unos inconvenientes",
    });
  } else {
    Swal.fire({
      icon: "error",
      title: "Error de validacion",
      text: "Por ingresa los valores requeridos para enviar tu examen.",
    });
  }
};

/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtnerRegistros = async (idExamen) => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/examenes/http.php/?examen=${idExamen}`,
    options
  );
  const respuestaData = await respuesta.json();
  const dataHeader = respuestaData.data.examen;
  tiempoRestante = dataHeader.tiempo;
  tiempoDefinido = dataHeader.tiempo;
  const header = `
            <h2 class="text-secondary">${dataHeader.nombre}</h2>
            <div class="text-secondary">
                <strong>Duracion:</strong> ${dataHeader.tiempo} minutos
                <strong>Expiracion:</strong> ${dataHeader.expiracion}
                <strong class="text-success">Tiempo restante: <strong class="text-danger" id="time">${dataHeader.tiempo}</strong></strong>
            </div>
            <h2 class="text-primary fs-4">${dataHeader.titulo}</h2>
            <p class="text-secondary">
            ${dataHeader.descripcion}
            </p>
    `;
  document.getElementById("header-content").innerHTML = header;

  respuestaData.data.preguntas.forEach((item, index) => {
    body += `
    <div class="examen card-body paginacion" key="${item.id}">
      <h5 class="card-title">
          ${item.descripcion}
      </h5>
      <label class="m-1" style="display: flex; align-items: center; gap:1rem">
          <strong>A:</strong>
          <input type="radio" name="${index}" value="1"> 
          <p class="d-flex col-11 m-0 fs-6 text-secondary">
          ${item.opcion_1}
          </p>
      </label>
      <label class="m-1" style="display: flex; align-items: center; gap:1rem">
          <strong>B:</strong>
          <input type="radio" name="${index}" value="2"> 
          <p class="d-flex col-11 m-0 fs-6 text-secondary">
          ${item.opcion_2}
          </p>
      </label>
      <label class="m-1" style="display: flex; align-items: center; gap:1rem">
          <strong>C:</strong>
          <input type="radio" name="${index}" value="3"> 
          <p class="d-flex col-11 m-0 fs-6 text-secondary">
          ${item.opcion_3}
          </p>
      </label>
      <label class="m-1" style="display: flex; align-items: center; gap:1rem">
          <strong>D:</strong>
          <input type="radio" name="${index}" value="4"> 
          <p class="d-flex col-11 m-0 fs-6 text-secondary">
          ${item.opcion_4}
          </p>
      </label>
    </div>
            `;
  });
  document.getElementById("preguntas").innerHTML = body;
  await restarTiempo();
};

/******************************************************************
 * Funcion para obtener el resultado del examen
 ******************************************************************/
const obtenerRespuestasExamen = async (idExamen, idAlumno) => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/dar-examen/http.php/?examen=${idExamen}&alumno=${idAlumno}&respuestas=true`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item, index) => {
      body += `
    <div class="card-body" >
      <p>
          <strong>Pregunta ${index + 1}</strong> ${item.descripcion} <div>${
        item.estado === 1
          ? '<strong class="text-success">Correcto</strong>'
          : '<strong class="text-danger">Incorrecto</strong>'
      }</div>
        </p>
    </div>
            `;
    });
    document.getElementById("respuestas").innerHTML = body;
  }
};

/******************************************************************
 * Funcion para obtener el resultado del examen
 ******************************************************************/
const obtnerResultados = async (idExamen, idAlumno) => {
  siguiente.style.display = "none";
  enviar.style.display = "none";
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/dar-examen/http.php/?id_examen=${idExamen}&id_alumno=${idAlumno}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    clearInterval(setTime);
    document.getElementById("header-content").innerHTML = "";
    respuestaData.data.forEach((item) => {
      body += `
    <div class="card-body" >
      <h5 class="card-title">
          Resultado del examen
      </h5>
      <div>
        <h3>Tiempo de respuestas: ${item.tiempo} minutos</h3>
        <p>
          <strong>Estado:</strong> ${
            parseInt(item.estado) === 1 ? "Aprobado" : "Desaprobado"
          }
        </p>
        <h3>
          Nota: <strong>${item.nota}</strong>
        </h3>
      </div>
    </div>
    
    <h5 class="card-title mb-3 px-3">
        Respuestas
    </h5>
    <div id="respuestas"></div>
            `;
    });
    document.getElementById("preguntas").innerHTML = body;
    await obtenerRespuestasExamen(idExamen, idAlumno);
  } else {
    siguiente.style.display = "inline-block";
    await obtnerRegistros(idExamen);
  }
};

const obtenerRespuestas = async () => {
  const preguntas = document.querySelectorAll(".examen.card-body");
  const respuestas = [];
  preguntas.forEach((item) => {
    if (item.querySelector("input:checked")) {
      const items = {
        pregunta: parseInt(item.getAttribute("key")),
        respuesta: parseInt(item.querySelector("input:checked").value),
      };
      respuestas.push(items);
    }
  });
  return respuestas;
};

//Funcion para trabajar con los tiempos
const restarTiempo = async () => {
  setTime = setInterval(async () => {
    tiempoRestante -= 1;
    if (tiempoRestante <= 0) {
      const tiempo = document.getElementById("time");
      const respuestas = await obtenerRespuestas();
      const data = {
        id_examen: idExamen.value,
        id_alumno: idAlumno.value,
        tiempo: tiempo.innerText.trim(),
        respuestas,
      };
      await insertar(data);
    }
    document.getElementById("time").innerText = tiempoRestante;
  }, 60000);
};

enviar.addEventListener("click", async () => {
  const tiempo = document.getElementById("time");
  const respuestas = await obtenerRespuestas();
  if (respuestas.length <= 0) {
    Swal.fire({
      icon: "error",
      title: "Error de respuestas",
      text: "Parece que no has respondido o marcado las preguntas del examen.",
    });
    return;
  }
  const data = {
    id_examen: idExamen.value,
    id_alumno: idAlumno.value,
    tiempo: tiempoDefinido - parseInt(tiempo.innerText.trim()),
    respuestas,
  };
  await insertar(data);
});

window.onload = async () => {
  await obtnerResultados(idExamen.value, idAlumno.value);

  let contador = 0;
  const paginacion = document.querySelectorAll(".paginacion");

  siguiente.addEventListener("click", () => {
    const preguntas = document.querySelectorAll(".examen.card-body.paginacion");

    siguiente.innerText = "Siguiente";
    paginacion.forEach((item) => {
      item.classList.remove("active");
    });

    if (contador < paginacion.length) {
      if (preguntas[contador].querySelector("input:checked")) {
        contador++;
      }
      paginacion[contador].classList.add("active");
    }
    if (contador === paginacion.length - 1) {
      siguiente.style.display = "none";
      enviar.style.display = "inline-block";
    }
  });
};
