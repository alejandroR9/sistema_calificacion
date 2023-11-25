const modal = document.getElementById("register");
const search = document.getElementById("search");

const id_curso = document.getElementById("id_curso");
const titulo = document.getElementById("titulo");
const descripcion = document.getElementById("descripcion");
const url_apk = document.getElementById("url_apk");

//Esta variabe identifica si se hara un registro o una modificacion
let action = "guardar";
let idRegistro = 0;

/******************************************************************
 * Funcion para insertar
 ******************************************************************/
const insertar = async (data) => {
  const formData = new FormData();
  formData.append('titulo', data.titulo);
  formData.append('descripcion', data.descripcion);
  formData.append('id_curso', data.id_curso);
  formData.append('url_apk', url_apk.files[0]); // Agrega la imagen
  const options = {
    method: "POST",
    body: formData,
  };
  const respuesta = await fetch("./app/entidades/temarios/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "descripcion vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de descripción",
      text: "Por favor ingresa una descripción del temario para el curso",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Temario registrado",
      text: "El temario a sido registrado con éxito",
    });
    await obtnerRegistros("");
    $("#exampleModal").modal("hide");
  }
};

/******************************************************************
 * Funcion para modificar un registro
 ******************************************************************/
const modificar = async (data, id) => {
  const options = {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  };
  const respuesta = await fetch(
    `./app/entidades/temarios/http.php/?id=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "descripcion vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de descripción",
      text: "Por favor ingresa una descripción del temario",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Temario modificado",
      text: "El temario a sido modificado con éxito",
    });
    await obtnerRegistros();
    $("#exampleModal").modal("hide");
  }
};

/**********************
 * Funcion para obtener el listado de registros
 **********************/
const obtnerRegistros = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/temarios/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.nombre}</th>
          <td>${item.numero_de_nivel}° ${item.nivel}</td>
          <td class="text-end">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-bs-whatever="@mdo" onClick="obtenerTemarios(${item.id})">
                ver temario
            </button>
          </td>
        </tr>
        `;
    });
    document.getElementById("dataBody").innerHTML = body;
  }

};

/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtenerTemarios = async (id) => {
  idRegistro = id
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/temarios/http.php/?get=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item) => {
      body += `
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">${item.titulo}</h5>
            <div>${item.url_apk !== null?`<a href="${item.url_apk}" class="btn btn-primary btn-sm">Descargar APK</a>`:''} </div>
            <p class="card-text">${item.descripcion}</p>
            <button type="button" class="btn btn-danger btn-sm" onClick="eliminar(${item.id})">
                Eliminar
            </button>
          </div>
        </div>
        `;
    });
    document.getElementById("dataTemario").innerHTML = body;
  }
};



/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtenerCursos = async (search = "") => {
  let body = "";
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
    document.getElementById("id_curso").innerHTML = body;
  }
};


/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async (id) => {
  Swal.fire({
    title: "Eliminando temario",
    text: "Estas seguro que deseas eliminar el temario del curso!",
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
        `./app/entidades/temarios/http.php/?delete=${id}`,
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
          "Periodo elminado!",
          "El temario a sido eliminado de la base de datos",
          "success"
        );
        await obtenerTemarios(idRegistro);
      }
    }
  });
};

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = {
    titulo: titulo.value,
    descripcion: descripcion.value,
    id_curso: id_curso.value,
    url_apk: url_apk.value,
  };
  if (action === "guardar") {
    await insertar(data);
  } else {
    await modificar(data, idRegistro);
  }
  action = "guardar";
  modal.reset();
});

//Funcion para buscar un registro
search.addEventListener("keydown", async (e) => {
  if (e.key === "Enter") {
    await obtnerRegistros(search.value);
  }
});

window.onload = async () => {
  await obtnerRegistros('');
  await obtenerCursos('')
};

document.querySelector(".btn-close").addEventListener("click", () => {
  action = "guardar";
  modal.reset();
});
document
  .querySelector(".modal-footer .btn.btn-secondary")
  .addEventListener("click", () => {
    action = "guardar";
    modal.reset();
  });
