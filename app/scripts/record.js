import {
  obtnerRegistros,
  obtnerAlumnosCursos,
} from "./funcionReutilizables.js";
const nivel = document.getElementById("nivel");
const periodo = document.getElementById("periodo");
const docente = document.getElementById("login");
const curso = document.getElementById("id_curso");
const alumno = document.getElementById("id_curso_alumno");
const nota = document.getElementById("nota");
const descripcion = document.getElementById("descripcion");

const modal = document.getElementById("register");
let arrayNotas = [];
let arrayNotasDescripcion = [];
let color = [];

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
    await obtnerNotas("");
  }
};

const generarColor = () =>
  "#" + Math.floor(Math.random() * 16777215).toString(16);

/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtnerNotas = async (search = "") => {
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
    `./app/entidades/notas/http.php/?search=${search}&id_periodo=${periodo.value}&id_nivel=${nivel.value}&idcurso=${curso.value}&idalumno=${alumno.value}`,
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

  await generarGrafico();
};

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  if (parseFloat(nota.value) < 0 || parseFloat(nota.value) > 20) {
    Swal.fire({
      icon: "error",
      title: "Error de nota",
      text: "Por favor ingresa una valida del alumno",
    });
    return;
  }
  const data = {
    id_periodo: periodo.value,
    id_nivel: nivel.value,
    idcurso: curso.value,
    idalumno: alumno.value,
    nota: nota.value,
    descripcion: descripcion.value,
  };
  await insertar(data);
  nota.value = "";
});

generarColor();
const contenedorCanvas = document.getElementById("contenedor-canvas");
const generarGrafico = async (data) => {
  const ctx = document.getElementById("grafico");
  contenedorCanvas.removeChild(ctx);
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

window.onload = async () => {
  await obtnerRegistros(periodo.value, nivel.value, docente.value);
  await obtnerAlumnosCursos(
    periodo.value,
    nivel.value,
    curso.value,
    docente.value
  );
  curso.addEventListener("change", async () => {
    await obtnerAlumnosCursos(
      periodo.value,
      nivel.value,
      curso.value,
      docente.value
    );
    await generarGrafico(miChartJS);
  });
  await obtnerNotas("");
  alumno.addEventListener("change", async () => {
    await obtnerNotas("");
    await generarGrafico(miChartJS);
  });
  await generarGrafico(miChartJS);
};
