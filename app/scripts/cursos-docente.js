import {
  obtenerCursos,
  obtenerDocentes,
  obtenerPeriodos,
  obtenerNiveles  
} from "./funcionReutilizables.js";
const modal = document.getElementById("register");
const search = document.getElementById("search");

const id_curso = document.getElementById("id_curso");
const id_docente = document.getElementById("id_docente");
const id_periodo = document.getElementById("id_periodo");
const id_nivel = document.getElementById("id_nivel");
let cursos = [];

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
  const response = await fetch(
    "./app/entidades/cursos-docente/http.php",
    options
  );
  const responseData = await response.json();
  if (responseData.message === "success") {
    Swal.fire({
      icon: "success",
      title: "Cursos asignados",
      text: "Los cursos han sido asignados con éxito",
    });
    await obtnerRegistros("");
    $("#exampleModal").modal("hide");
    cursos = []
    actualizarContenido()
  } else if(responseData.message === 'error') {
    Swal.fire({
      icon: "error",
      title: "EL DOCENTE YA A SIDO ASIGNADO A UNO O MAS CURSOS",
      text: "Parece que ya has asignado uno o mas cursos seleccionados con anterioridad",
    });

  } else {
    Swal.fire({
      icon: "error",
      title: "Por favor selecciona uno o mas cursos para asignar al docente",
      text: "Parece que no has seleccionado cursos para asignarle al docente",
    });
  }
};

/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async () => {
  Swal.fire({
    title: "Eliminando curso",
    text: "Estas seguro que deseas eliminar el curso!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const options = {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      };
      const respuesta = await fetch(
        `./app/entidades/cursos-docente/http.php/?delete=${id}`,
        options
      );
      const respuestaData = await respuesta.json();
      if (respuestaData.message === "error") {
        Swal.fire({
          icon: "error",
          title: "Oppss....",
          text: "No pudimos eliminar el registro",
        });
      } else {
        Swal.fire(
          "Curso eliminado!",
          "El curso a sido eliminado de la base de datos",
          "success"
        );
      }
    }
  });
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
    `./app/entidades/cursos-docente/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.nombre}</th>
          <td>${item.docente}</td>
          <td>${item.nivel}</td>
          <td>${item.descripcion}</td>
          <td class="text-end">              
            <button class="btn btn-danger btn-sm badge" onClick="eliminar(${item.id})">
                Eliminar
            </button>
          </td>
        </tr>
        `;
    });
    document.getElementById("dataBody").innerHTML = body;
  } else {
    document.getElementById("dataBody").innerHTML = '';
  }
};

const contenido = document.getElementById("cursos-asignados");
const seleccionarCurso = () => {
  if (parseInt(id_curso.value) === 0) {
    return;
  }
  const selectedOption = id_curso.options[id_curso.selectedIndex];

  if (!cursos.some((item) => item.id_curso === id_curso.value)) {
    const nuevoCurso = {
      id_curso: id_curso.value,
      name_curso: selectedOption.textContent,
      id_docente: id_docente.value,
      id_periodo: id_periodo.value,
      id_nivel: id_nivel.value,
    };
    cursos.push(nuevoCurso);
    actualizarContenido();
  }
};

// Función para actualizar el contenido en el div
const actualizarContenido = () => {
  let body = "";
  cursos.forEach((item) => {
    body += `
      <div class="alert alert-light" role="alert">
      <button class="btn btn-danger badge btn-sm" id="btn-quitar-${item.id_curso}">Quitar</button>
        ${item.name_curso}
      </div>
    `;
  });
  contenido.innerHTML = body;

  // Agregar el evento de clic a los botones "Quitar"
  cursos.forEach((item) => {
    const btnQuitar = document.getElementById(`btn-quitar-${item.id_curso}`);
    btnQuitar.addEventListener("click", () => {
      eliminarCurso(item.id_curso);
    });
  });
};

// Función para eliminar un curso por su id_curso
const eliminarCurso = (idCurso) => {
  const indice = cursos.findIndex((item) => item.id_curso === idCurso);
  if (indice !== -1) {
    cursos.splice(indice, 1);
    actualizarContenido();
  }
};

id_curso.addEventListener("change", () => {
  seleccionarCurso();
});

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = {
    cursos,
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


  document.getElementById("id_curso").innerHTML = await obtenerCursos("");
  document.getElementById("id_periodo").innerHTML = await obtenerPeriodos("");
  document.getElementById("id_docente").innerHTML = await obtenerDocentes("");
  document.getElementById("id_nivel").innerHTML = await obtenerNiveles("");  
};
