const modal = document.getElementById("register");
const search = document.getElementById("search");

const descripcion = document.getElementById("descripcion");
const estado = document.getElementById("estado");

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
  const respuesta = await fetch("./app/entidades/periodos/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "descripcion vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de descripción",
      text: "Por favor ingresa una descripción del periodo academico",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Periodo registrado",
      text: "El periodo académico a sido registrado con éxito",
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
    `./app/entidades/periodos/http.php/?id=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "descripcion vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de descripción",
      text: "Por favor ingresa una descripción del periodo academico",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Periodo modificado",
      text: "El periodo academico a sido modificado con éxito",
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
    `./app/entidades/periodos/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length <= 0) {
    Swal.fire({
      icon: "warning",
      title: "Datos vacios",
      text: "Parece que no tienes periodos académicos registrados",
    });
  } else {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.descripcion}</th>
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
  fetch(`./app/entidades/periodos/http.php/?get=${id}`, options)
    .then((res) => res.json())
    .then((respuesta) => {
      if (respuesta.data.length <= 0) {
        Swal.fire({
          icon: "warning",
          title: "Datos vacios",
          text: "No pudimos encontrar los datos del periodo seleccionado",
        });
      } else {
        const registro = respuesta.data[0];
        descripcion.value = registro.descripcion;
        estado.value = registro.estado;
      }
    });
};

/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async (id) => {
  Swal.fire({
    title: "Eliminando periodo",
    text: "Estas seguro que deseas eliminar el periodo académico!",
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
        `./app/entidades/periodos/http.php/?delete=${id}`,
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
          "El periodo académico a sido eliminado de la base de datos",
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
    descripcion: descripcion.value,
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

//Funcion para buscar un registro
search.addEventListener("keydown", async (e) => {
  if (e.key === "Enter") {
    await obtnerRegistros(search.value);
  }
});

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
