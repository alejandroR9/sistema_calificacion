const modal = document.getElementById("register");
const search = document.getElementById("search");

const nivel = document.getElementById("nivel");
const numero_de_nivel = document.getElementById("numero_de_nivel");
const estado = document.getElementById("estado");
const id_usuario = document.getElementById("login");

//Esta variabe identifica si se hara un registro o una modificacion
let action = "guardar";
let idRegistro = 0;

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
  const respuesta = await fetch("./app/entidades/niveles/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "descripcion vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de descripción",
      text: "Por favor ingresa una descripción del nivel academico",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Nivel registrado",
      text: "El nivel académico a sido registrado con éxito",
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
    `./app/entidades/niveles/http.php/?id=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "descripcion vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de descripción",
      text: "Por favor ingresa una descripción del nivel academico",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Nivel academico modificado",
      text: "El nivel academico a sido modificado con éxito",
    });
    await obtnerRegistros();
    $("#exampleModal").modal("hide");
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
    `./app/entidades/niveles/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  console.log(respuestaData);
  if (respuestaData.data.length <= 0) {
    Swal.fire({
      icon: "warning",
      title: "Datos vacios",
      text: "Parece que no tienes niveles académicos registrados",
    });
  } else {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.nombre}</th>
          <th>${item.numero_de_nivel}° ${item.nivel} </th>
          <th>${item.fecha_de_creacion}</th>
          <td>${
            parseInt(item.estado) === 1
              ? '<span class="badge text-bg-success">Activo</span>'
              : '<span class="badge text-bg-danger">Inactivo</span>'
          }</td>
          <td class="text-end">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" onClick="obtnerRegistro(${
              item.id
            })">
                Modificar
            </button>
            <button class="btn btn-danger btn-sm" onClick="eliminar(${
              item.id
            })">
                Eliminar
            </button>
          </td>
        </tr>
        `;
    });
    document.getElementById("dataBody").innerHTML = body;
  }
};

/******************************************************************
 * Funcion para obtener los datos de un registro en especifico
 ******************************************************************/
const obtnerRegistro = (id) => {
  idRegistro = id;
  action = "modificar";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  fetch(`./app/entidades/niveles/http.php/?get=${id}`, options)
    .then((res) => res.json())
    .then((respuesta) => {
      if (respuesta.data.length <= 0) {
        Swal.fire({
          icon: "warning",
          title: "Datos vacios",
          text: "No pudimos encontrar los datos del nivel seleccionado",
        });
      } else {
        const registro = respuesta.data[0];
        nivel.value = registro.nivel;
        numero_de_nivel.value = registro.numero_de_nivel;
        estado.value = registro.estado;
      }
    });
};

/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async (id) => {
  Swal.fire({
    title: "Eliminando nivel",
    text: "Estas seguro que deseas eliminar el nivel académico!",
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
        `./app/entidades/niveles/http.php/?delete=${id}`,
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
          "Nivel elminado!",
          "El nivel académico a sido eliminado de la base de datos",
          "success"
        );
        await obtnerRegistros();
      }
    }
  });
};

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = {
    id_usuario: id_usuario.value,
    nivel: nivel.value,
    numero_de_nivel: numero_de_nivel.value,
    estado: estado.value,
  };
  if (action === "guardar") {
    await insertar(data);
  } else {
    await modificar(data, idRegistro);
  }
  action = "guardar";
  modal.reset();
});

// Funcion para buscar registros
search.addEventListener("keydown", async (e) => {
  if (e.key === "Enter") {
    await obtnerRegistros(search.value);
  }
});

// search.addEventListener("keyup", async (e) => {
//   await obtnerRegistros(search.value);
//   });

window.onload = async () => {
  await obtnerRegistros();
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
