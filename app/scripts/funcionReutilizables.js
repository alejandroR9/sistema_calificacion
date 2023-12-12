/******************************************************************
 *! Funcion para obtener el listado de curso
 ******************************************************************/
export const obtenerCursos = async (search = "") => {
  let body = `<option value="0" selected>Seleccionar curso</option>`;
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/cursos/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
          <option value="${item.id}">${item.nombre}</option>
          `;
    });
    return body;
  }
};
/******************************************************************
 *! Funcion para obtener el listado de periodos
 ******************************************************************/
export const obtenerPeriodos = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/periodos/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    const periodosActivos = respuestaData.data.filter(
      (item) => parseInt(item.estado) === 1
    );
    periodosActivos.forEach((item) => {
      body += `
          <option value="${item.id}">${item.descripcion}</option>
          `;
    });
    return body;
  }
};
/******************************************************************
 *! Funcion para obtener el listado de docentes
 ******************************************************************/
export const obtenerDocentes = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/persona/http.php/?search=${search}&role=2`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
          <option value="${item.id}">${item.apellidos} ${item.nombres}</option>
          `;
    });
    return body;
  }
};
/******************************************************************
 *! Funcion para obtener el listado de niveles académicos
 ******************************************************************/
export const obtenerNiveles = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/niveles/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    const nivelActivo = respuestaData.data.filter(
      (item) => parseInt(item.estado) === 1
    );
    nivelActivo.forEach((item) => {
      body += `
          <option value="${item.id}">${item.numero_de_nivel}° ${item.nivel}</option>
          `;
    });
    return body;
  }
};

/******************************************************************
 *! Funcion para obtener el listado de niveles académicos
 ******************************************************************/
export const obtenerAlumnosMatricula = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/persona/http.php/?search=${search}&role=3`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    const nivelActivo = respuestaData.data.filter(
      (item) => parseInt(item.estado) === 1
    );
    nivelActivo.forEach((item) => {
      body += `
          <option value="${item.id}">${item.nombres}, ${item.apellidos}</option>
          `;
    });
    return body;
  }
};

/******************************************************************
 *! Funcion para obtener el listado curso de un docente en espefico
 ******************************************************************/
export const cursosDelDocente = async (idDocente, idPeriodo) => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/cursos-docente/http.php/?id_docente=${idDocente}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
          <option value="${item.id}">${item.nombre} |  ${item.descripcion} | ${item.nivel}</option>
          `;
    });
    return body;
  }
};

/******************************************************************
 *! Funcion para obtener examenes pendientes del alumno
 ******************************************************************/
export const examenesAlumnos = async (idAlumno) => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/examenes/http.php/?id_alumno=${idAlumno}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
      <tr>
      <th>${item.nombre}</th>
      <td>${item.titulo}</td>
      <td>${item.tiempo}</td>
      <td>${item.expiracion}</td>
      <td class="text-end">              
      <a href="./dar-examen.php?examen=${item.id}" class="btn btn-success btn-sm badge">
      Empezar examen
  </a>
        
      </td>
    </tr>
          `;
    });
    return body;
  } else {
    return [];
  }
};


/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
export const obtnerRegistros = async (periodo,nivel,idAlumno = 1) => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/cursos/http.php/?periodo_id=${periodo}&nivel_id=${nivel}&docente_id=${idAlumno}`,
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
    respuestaData.data.forEach((item) => {
      body += `
        <option value="${item.id}">${item.nombre}</option>
          `;
    });
    document.getElementById("id_curso").innerHTML = body;
  }
};

/******************************************************************
 * Funcion para obtener el listado de alumnos segun cursos
 ******************************************************************/
export const obtnerAlumnosCursos = async (periodo,nivel,idCurso, idDocente) => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/persona/http.php/?id_periodo=${periodo}&id_nivel=${nivel}&id_curso=${idCurso}&id_docente=${idDocente}`,
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
    respuestaData.data.forEach((item) => {
      body += `
        <option value="${item.id}">${item.nombres}</option>
          `;
    });
    document.getElementById("id_curso_alumno").innerHTML = body;
  }
};



/******************************************************************
 * Funcion para ingresar notas
 ******************************************************************/
export const obtnerAlumnosParaNotasCursos = async (periodo,nivel,idCurso, idDocente,search='') => {
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/persona/http.php/?search=${search}&id_periodo=${periodo}&id_nivel=${nivel}&id_curso=${idCurso}&id_docente=${idDocente}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length <= 0) return []
  return respuestaData.data
};