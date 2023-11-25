import {
    cursosDelDocente
  } from "./funcionReutilizables.js";
  const modal = document.getElementById("register");
  const search = document.getElementById("search");
  
  const id_curso_docente = document.getElementById("id_curso_docente");
  const titulo = document.getElementById("titulo");
  const tiempo = document.getElementById("tiempo");
  const descripcion = document.getElementById("descripcion");
  const id_docente = document.getElementById("login");
  const expiracion = document.getElementById("expiracion");
  
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
    const response = await fetch("./app/entidades/examenes/http.php", options);
    const responseData = await response.json();
    if (responseData.message === "success") {
      Swal.fire({
        icon: "success",
        title: "Examen creado",
        text: "El examen del curso a sido creado con éxito",
      });
      await obtnerRegistros("",id_docente.value);
      $("#exampleModal").modal("hide");
    }  else {
      Swal.fire({
        icon: "error",
        title: "Error de validacion",
        text: "Por ingresa los valores requeridos para matricular alumno.",
      });
    }
  };
  
  /******************************************************************
   * Funcion para obtener el listado de registros
   ******************************************************************/
  const obtnerRegistros = async (search = "",id_docente) => {
    let body = "";
    const options = {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    };
    const respuesta = await fetch(
      `./app/entidades/examenes/http.php/?search=${search}&id_docente=${id_docente}`,
      options
    );
    const respuestaData = await respuesta.json();
    if (respuestaData.data.length > 0) {
      respuestaData.data.forEach((item) => {
        body += `
            <tr>
              <th>${item.nombre}</th>
              <td>${item.titulo}</td>
              <td>${item.descripcion}</td>
              <td>${item.tiempo} minutos</td>
              <td>${item.expiracion}</td>
              <td class="text-end">              
                <a href="./app/reportes/reporte.php?examen=${item.id}" target="_blank" class="btn btn-secondary btn-sm">
                    Ver resultados
                </a>
              </td>
            </tr>
            `;
      });
      document.getElementById("dataBody").innerHTML = body;
    } else {
      document.getElementById("dataBody").innerHTML = "";
    }
  };

  //funcion para crear la preguntas 
  let preguntaCounter = 1;
  document.getElementById("agregar-pregunta").addEventListener("click", function () {
    const preguntasContainer = document.getElementById("preguntas");
  
    // Crear una nueva pregunta
    const preguntaDiv = document.createElement("div");
    preguntaDiv.classList.add("mb-3", "card", "p-4", "mt-3",'preguntas');
    preguntaDiv.id = `pregunta${preguntaCounter}`;
  
    preguntaDiv.innerHTML = `
      <h3 class="fs-5">Pregunta ${preguntaCounter}</h3>
      <textarea class="form-control" cols="30" rows="2" placeholder="Pregunta"></textarea>
      <div>
        Opción 01:
        <input type="text" class="form-control response block" placeholder="Respuesta">
      </div>
      <div>
        Opción 02:
        <input type="text" class="form-control response block" placeholder="Respuesta">
      </div>
      <div>
        Opción 03:
        <input type="text"  class="form-control response block" placeholder="Respuesta">
      </div>
      <div>
        Opción 04:
        <input type="text"  class="form-control response block" placeholder="Respuesta">
      </div>
      <div>
        Respuesta correcta
        <input type="number"  min="1" max="4" class="form-control response block" placeholder="Respuesta">
      </div>
    `;
  
    // Agregar la nueva pregunta al contenedor
    preguntasContainer.appendChild(preguntaDiv);
  
    // Incrementar el contador de preguntas
    preguntaCounter++;
  });

  /**
   * Otener las preguntas del examen
   */
const obtenerPreguntas = async () => {
  const preguntasGeneradas = document.querySelectorAll(".preguntas");

  const preguntasArray = [];

  preguntasGeneradas.forEach((preguntaDiv) => {
    const preguntaTexto = preguntaDiv.querySelector("textarea").value;
    const respuestas = preguntaDiv.querySelectorAll(".response");
    const opciones = [];
    for (let j = 0; j < respuestas.length; j++) {
      const respuestaInput = respuestas[j].value;
      opciones.push(respuestaInput);
    }

    const preguntaObj = {
      pregunta: preguntaTexto,
      respuesta1: opciones[0],
      respuesta2: opciones[1],
      respuesta3: opciones[2],
      respuesta4: opciones[3],
      respuesta_correcta: opciones[4],
    };

    preguntasArray.push(preguntaObj);
  });

  return preguntasArray;
}













  
  modal.addEventListener("submit", async (e) => {
    e.preventDefault();
    const preguntas = await obtenerPreguntas()
    if(preguntas.length <= 0) {      
      Swal.fire({
        icon: "error",
        title: "Preguntas vacias",
        text: "Por favor ingresa las preguntas del examen",
      });
      return
    }
    const data = {
      id_curso_docente : id_curso_docente .value,
      titulo: titulo.value,
      descripcion: descripcion.value,
      tiempo: tiempo.value,
      expiracion: expiracion.value,
      preguntas,
    };
    await insertar(data);
    modal.reset();
    document.getElementById('preguntas').innerHTML = ''
  });
  
  //Funcion para buscar un registro
  search.addEventListener("keydown", async (e) => {
    if (e.key === "Enter") {
      await obtnerRegistros(search.value,id_docente.value);
    }
  });
  
  window.onload = async () => {
    const idPeriodo = document.getElementById('periodo')
    document.getElementById("id_curso_docente").innerHTML =
    await cursosDelDocente(id_docente.value,idPeriodo.value);
    await obtnerRegistros("",id_docente.value);  
  };
  