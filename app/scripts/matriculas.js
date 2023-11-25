import {
  obtenerPeriodos,
  obtenerNiveles,
  obtenerAlumnosMatricula,
} from "./funcionReutilizables.js";
const modal = document.getElementById("register");
const search = document.getElementById("search");

const id_alumno = document.getElementById("id_alumno");
const id_usuario = document.getElementById("login");
const id_periodo_academico = document.getElementById("id_periodo_academico");
const id_nivel = document.getElementById("id_nivel");
const monto_matricula = document.getElementById("monto_matricula");

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
  const response = await fetch("./app/entidades/matriculas/http.php", options);
  const responseData = await response.json();
  if (responseData.message === "success") {
    Swal.fire({
      icon: "success",
      title: "Alumno matriculado",
      text: "El alumno a sido matriculado con éxito",
    });
    await obtnerRegistros("");
    $("#exampleModal").modal("hide");
  } else if (responseData.message === "error") {
    Swal.fire({
      icon: "error",
      title: "Alumno matriculado",
      text: "Parece que ya has matriculado al alumno con anterioridada este periodo",
    });
  } else {
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
const obtnerRegistros = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/matriculas/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
          <tr>
            <th>${item.nombre}</th>
            <td>${item.periodo}</td>
            <td>${item.nivel}</td>
            <td>${item.fecha_matricula}</td>
            <td>S/${item.monto_matricula}</td>
            <td class="text-end">              
              <button class="btn btn-secondary btn-sm badge">
                  imprimir
              </button>
            </td>
          </tr>
          `;
    });
    document.getElementById("dataBody").innerHTML = body;
  } else {
    document.getElementById("dataBody").innerHTML = "";
  }
};

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = {
    id_alumno: id_alumno.value,
    id_usuario: id_usuario.value,
    id_periodo_academico: id_periodo_academico.value,
    id_nivel: id_nivel.value,
    monto_matricula: monto_matricula.value,
  };
  await insertar(data);
  modal.reset();
});

//Funcion para buscar un registro
search.addEventListener("keydown", async (e) => {
  if (e.key === "Enter") {
    await obtnerRegistros(search.value);
  }
});

window.onload = async () => {
  await obtnerRegistros("");

  document.getElementById("id_periodo_academico").innerHTML =
    await obtenerPeriodos("");
  document.getElementById("id_nivel").innerHTML = await obtenerNiveles("");
  document.getElementById("id_alumno").innerHTML =
    await obtenerAlumnosMatricula("");
};
