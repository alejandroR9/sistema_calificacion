import {
  obtnerRegistros,
  obtnerAlumnosParaNotasCursos,
} from "./funcionReutilizables.js";
const nivel = document.getElementById("nivel");
const periodo = document.getElementById("periodo");
const docente = document.getElementById("login");
const curso = document.getElementById("id_curso");
const alumnos = document.getElementById("id_alumnos");

let arrayNotas = [];
let arrayNotasDescripcion = [];
let color = [];
let promedio = 0;
const searchAlumnos = document.getElementById("search");
let idAlumnos = 0;

let listaAlumnos = [];

let miChartJS = null;

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
  const respuesta = await fetch("./app/entidades/notas/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nota vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de nota",
      text: "Por favor ingresa una valida del alumno",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Nota registrado",
      text: "La nota del alumno a sido registrado con éxito",
    });
    descripcion.value = "";
    listaAlumnos = [];
    $("#exampleModal").modal("hide");
  }
};

const generarColor = () =>
  "#" + Math.floor(Math.random() * 16777215).toString(16);

/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtnerNotas = async (search = "") => {
  promedio = 0;
  let notas = 0;
  arrayNotas = [];
  arrayNotasDescripcion = [];
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/notas/http.php/?search=${search}&id_periodo=${periodo.value}&id_nivel=${nivel.value}&idcurso=${curso.value}&idalumno=${idAlumnos}`,
    options
  );
  const respuestaData = await respuesta.json();

  if (respuestaData.data.length <= 0) {
    document.getElementById("dataBody").innerHTML = "";
  } else {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.descripcion}</th>
          <td>${item.nota}</td>
          <td>${item.fecha}</td>
        </tr>
        `;
      color.push(generarColor());

      arrayNotas.push(parseFloat(item.nota));
      arrayNotasDescripcion.push(item.descripcion);
      notas += parseFloat(item.nota);
      promedio = notas / respuestaData.data.length;
    });
    document.getElementById("dataBody").innerHTML = body;
  }

  miChartJS = {
    labels: arrayNotasDescripcion,
    datasets: [
      {
        label: "test",
        data: arrayNotas,
        borderColor: color,
        backgroundColor: color,
      },
    ],
  };
  if (alumnos.value !== "") {
    await generarGrafico(miChartJS);
    document.getElementById("promedio").innerHTML =
      `Promedio final:   ${promedio}  <br> <a href="./app/reportes/reporteNotas.php?id_periodo=${periodo.value}&id_nivel=${nivel.value}&idcurso=${curso.value}&idalumno=${idAlumnos}" target="_blank" class="btn btn-warning" >Exportar</a>`;
  } else {
    const ctx = document.getElementById("grafico");
    if (ctx) {
      contenedorCanvas.removeChild(ctx);
    }
    document.getElementById("promedio").innerText = "";
  }
};

generarColor();
const contenedorCanvas = document.getElementById("contenedor-canvas");
const generarGrafico = async (data) => {
  const ctx = document.getElementById("grafico");
  if (ctx) contenedorCanvas.removeChild(ctx);

  const canvas = document.createElement("canvas");
  canvas.id = "grafico";
  contenedorCanvas.appendChild(canvas);

  new Chart(canvas, {
    type: "bar",
    data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      plugins: {
        title: {
          display: true,
          text: "REPORTE DE GRAFICO DE BARRAS",
        },
      },
    },
  });
};

const mostrarAlumnos = async () => {
  let body = "";
  const alumnos = await obtnerAlumnosParaNotasCursos(
    periodo.value,
    nivel.value,
    curso.value,
    docente.value
  );

  alumnos.forEach((item) => {
    body += `
      <div class="alumnos mb-3" key="${item.id}">
        <h2 class="fs-4">${item.nombres} ${item.apellidos}</h2>
        <input type="number" class="form-control" min="0" max="20" />
      </div>
      `;
  });
  document.getElementById("dataAlumnos").innerHTML = body;
};

const mostrarAlumnosBody = async (search = "") => {
  let body = "";
  const contenedor = document.querySelector(".content-search");
  const alumnos = await obtnerAlumnosParaNotasCursos(
    periodo.value,
    nivel.value,
    curso.value,
    docente.value,
    search
  );

  if (alumnos.length > 0) {
    alumnos.forEach((item) => {
      body += `
    <div key="${item.id}">${item.nombres} ${item.apellidos}</div>
      `;
    });
    document.getElementById("id_alumnos").innerHTML = body;
    contenedor.style.display = "block";
  } else {
    contenedor.style.display = "none";
  }
};

const obtenerNotasDelFormulario = () => {
  const alumnos = document.querySelectorAll(".alumnos");
  alumnos.forEach((item) => {
    const id = item.getAttribute("key");
    const nota = item.querySelector("input").value;
    if (nota === null || nota === "") {
      return;
    }
    const alumno = {
      id: parseInt(id),
      nombres: item.querySelector("h2").innerText,
      nota: parseInt(nota),
    };
    const existe = listaAlumnos.some((item) => item.id === parseInt(id));
    if (!existe) {
      listaAlumnos.push(alumno);
    }
  });
};
const modal = document.getElementById("registrar");

modal.addEventListener("click", async (e) => {
  obtenerNotasDelFormulario();
  e.preventDefault();
  if (listaAlumnos.length <= 0) {
    Swal.fire({
      icon: "error",
      title: "Error de notas",
      text: "Por favor ingresa las notas del alumno",
    });
    return;
  }
  const data = {
    id_periodo: periodo.value,
    id_nivel: nivel.value,
    idcurso: curso.value,
    descripcion: descripcion.value,
    notas: listaAlumnos,
  };
  await insertar(data);
  nota.value = "";
});

window.onload = async () => {
  await obtnerRegistros(periodo.value, nivel.value, docente.value);
  const contenedor = document.querySelector(".content-search");

  await mostrarAlumnos();
  searchAlumnos.addEventListener(
    "keyup",
    async () => await mostrarAlumnosBody(searchAlumnos.value)
  );
  if (searchAlumnos !== "") {
    contenedor.addEventListener("click", async (e) => {
      idAlumnos = e.target.getAttribute("key");
      await obtnerNotas("");
      searchAlumnos.value = e.target.innerText;
      contenedor.style.display = "none";
    });
  }
  document
    .getElementById("consultation")
    .addEventListener("click", async () => await obtnerNotas(""));
};
