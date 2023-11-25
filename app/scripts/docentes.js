const modal = document.getElementById("register");
const search = document.getElementById("search");

const nombres = document.getElementById("nombre");
const apellidos = document.getElementById("apellidos");
const correo = document.getElementById("correo");
const password = document.getElementById("password");
const dni = document.getElementById("dni");
const direccion = document.getElementById("direccion");
const telefono = document.getElementById("telefono");
const seccion = document.getElementById("seccion");
const usuarioLogin = document.getElementById("login");

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
  const respuesta = await fetch("./app/entidades/persona/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "rol invalido") {
    Swal.fire({
      icon: "error",
      title: "Rol invalido",
      text: "Por favor ingresa el rol para poder registrar al docente",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Docente registrado",
      text: "El docente a sido registrado con éxito",
    });
    await obtnerRegistros('')
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
    `./app/entidades/persona/http.php/?id=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Nombre vacío",
      text: " El campo nombre es obligatorio",
    });
  }  else {
    Swal.fire({
      icon: "success",
      title: "Docente modificado",
      text: "El docente a sido modificado con éxito",
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
    `./app/entidades/persona/http.php/?search=${search}&role=2`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length <= 0) {
    Swal.fire({
      icon: "warning",
      title: "Datos vacios",
      text: "Parece que no tienes docentes registrados",
    });
  } else {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.apellidos}, ${item.nombres}</th>
          <td>${item.dni}</td>
          <td>${item.direccion}</td>
          <td>${item.telefono}</td>
          <td>${item.correo}</td>
          <td>${item.seccion}</td>
          <td>${item.fecha_de_creacion}</td>
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
            <button class="btn btn-success btn-sm" onClick="cambiarClave(${
              item.id
            })">
                Resetear clave
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
  fetch(`./app/entidades/persona/http.php/?get=${id}`, options)
    .then((res) => res.json())
    .then((respuesta) => {
      if (respuesta.data.length <= 0) {
        Swal.fire({
          icon: "warning",
          title: "Datos vacios",
          text: "No pudimos obtener los datos del docente",
        });
      } else {
        const registro = respuesta.data[0];
        dni.value = registro.dni;
        apellidos.value = registro.apellidos;
        nombres.value = registro.nombres;
        direccion.value = registro.direccion;
        telefono.value = registro.telefono;
        correo.value = registro.correo;
        seccion.value = registro.seccion;
      }
    });
};

/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async (id) => {
  Swal.fire({
    title: "Eliminando docente",
    text: "Estas seguro que deseas eliminar al docente!",
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
        `./app/entidades/persona/http.php/?delete=${id}`,
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
          "Usuario elminado!",
          "El docente a sido eliminado de la base de datos",
          "success"
        );
        await obtnerRegistros();
      }
    }
  });
};


/******************************************************************
 * Funcion para cambiar clave
 ******************************************************************/
const cambiarClave = async (id) => {
  Swal.fire({
    title: "Reseteando clave del alumno",
    text: "Estas seguro que deseas resetear la clave del alumno!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Resetear!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const options = {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
      };
      const respuesta = await fetch(
        `./app/entidades/persona/http.php/?id_persona=${id}`,
        options
      );
      const respuestaData = await respuesta.json();
      if (respuestaData.message === "error") {
        Swal.fire({
          icon: "error",
          title: "Oppss....",
          text: "No pudimos resetar la clave el registro",
        });
      } else {
        Swal.fire(
          "Clave reseteado!",
          "La clave del alumno a sido reseteado con éxito",
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
    id_usuario: usuarioLogin.value,
    id_rol: 2,
    dni: dni.value,
    password: password.value,
    apellidos: apellidos.value,
    nombres: nombres.value,
    direccion: direccion.value,
    telefono: telefono.value,
    correo: correo.value,
    seccion: seccion.value,
    nombrePadre: '',
    apellidoPadre: '',
    celularPadre: '',
    correoPadre: '',
  };
  if (action === "guardar") {
    await insertar(data);
  } else {
    await modificar(data, idRegistro);
  }
  modal.reset();
  action = "guardar";
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
