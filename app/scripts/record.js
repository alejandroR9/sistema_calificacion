import {
  obtnerRegistros,
  obtnerAlumnosParaNotasCursos
} from "./funcionReutilizables.js";
const nivel = document.getElementById("nivel");
const periodo = document.getElementById("periodo");
const docente = document.getElementById("login");
const curso = document.getElementById("id_curso");
const alumno = document.getElementById("id_curso_alumno");

let arrayNotas = [];
let arrayNotasDescripcion = [];
let color = [];

let listaAlumnos = []

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
    descripcion.value = ''
    listaAlumnos = []
    $("#exampleModal").modal("hide");
    // await obtnerNotas("");
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

const mostrarAlumnos = async () => {
  let body = ''
  const alumnos = await obtnerAlumnosParaNotasCursos(
    periodo.value,
    nivel.value,
    curso.value,
    docente.value)
    
    alumnos.forEach(item => {
      body += `
      <div class="alumnos mb-3" key="${item.id}">
        <h2 class="fs-4">${item.nombres} ${item.apellidos}</h2>
        <input type="number" class="form-control" min="0" max="20" />
      </div>
      `
    })
    document.getElementById('dataAlumnos').innerHTML = body
}

const obtenerNotasDelFormulario = () => {
  const alumnos = document.querySelectorAll('.alumnos')
  alumnos.forEach(item => {
    const id = item.getAttribute('key')
    const nota = item.querySelector('input').value
    if(nota === null || nota === '') {
      return
    }
    const alumno = {
      id:parseInt(id),
      nombres:item.querySelector('h2').innerText,
      nota:parseInt(nota)
    }
    const existe = listaAlumnos.some(item => item.id === parseInt(id))
    if(!existe) {
      listaAlumnos.push(alumno)      
    }
  })
}
const modal = document.getElementById('registrar')




modal.addEventListener("click", async (e) => {
  obtenerNotasDelFormulario()
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
    notas:listaAlumnos
  };
  await insertar(data);
  nota.value = "";
});



window.onload = async () => {
  await obtnerRegistros(periodo.value, nivel.value, docente.value);
  // curso.addEventListener("change", async () => {
  //   await generarGrafico(miChartJS);
  // });
  // await obtnerNotas("");
  // alumno.addEventListener("change", async () => {
  //   await obtnerNotas("");
  //   await generarGrafico(miChartJS);
  // });
  // await generarGrafico(miChartJS);
  await mostrarAlumnos()
};
