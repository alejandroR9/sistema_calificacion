const modal = document.getElementById("register");
const search = document.getElementById("search");

const nombre = document.getElementById("nombre");
const usuario = document.getElementById("usuario");
const password = document.getElementById("password");
const correo = document.getElementById("correo");

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
  const respuesta = await fetch("./app/entidades/usuarios/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Nombre vacío",
      text: " El campo nombre es obligatorio",
    });
  } else if (respuestaData.message === "correo vacio") {
    Swal.fire({
      icon: "error",
      title: "Correo vacío",
      text: " El campo correo es obligatorio",
    });
  } else if (respuestaData.message === "usuario vacio") {
    Swal.fire({
      icon: "Usuario vacío",
      text: " El campo usuario es obligatorio",
    });
  } else if (respuestaData.message === "password vacio") {
    Swal.fire({
      icon: "error",
      title: "Contraseña vacío",
      text: " El campo contraseña es obligatorio",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Usuario registrado",
      text: "El usuario a sido registrado con éxito",
    });
    await obtnerUsuarios('')
  }
};

/******************************************************************
 * Funcion para insertar
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
    `./app/entidades/usuarios/http.php/?id=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Nombre vacío",
      text: " El campo nombre es obligatorio",
    });
  } else if (respuestaData.message === "correo vacio") {
    Swal.fire({
      icon: "error",
      title: "Correo vacío",
      text: " El campo correo es obligatorio",
    });
  } else if (respuestaData.message === "usuario vacio") {
    Swal.fire({
      icon: "Usuario vacío",
      text: " El campo usuario es obligatorio",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Usuario registrado",
      text: "El usuario a sido registrado con éxito",
    });
    await obtnerUsuarios();
    $("#exampleModal").modal("hide");
  }
};

/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtnerUsuarios = async (search = "") => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/usuarios/http.php/?search=${search}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length <= 0) {
    Swal.fire({
      icon: "warning",
      title: "Datos vacios",
      text: "Parece que no tiene usuarios registrados",
    });
  } else {
    respuestaData.data.forEach((item) => {
      body += `
        <tr>
          <th>${item.nombre}</th>
          <td>${item.correo}</td>
          <td>${item.usuario}</td>
          <td>${item.rol}</td>
          <td>${
            parseInt(item.estado) === 1
              ? '<span class="badge text-bg-success">Activo</span>'
              : '<span class="badge text-bg-danger">Inactivo</span>'
          }</td>
          <td class="text-end">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" onClick="obtnerUsuario(${
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
const obtnerUsuario = (id) => {
  idRegistro = id;
  action = "modificar";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  fetch(`./app/entidades/usuarios/http.php/?get=${id}`, options)
    .then((res) => res.json())
    .then((respuesta) => {
      if (respuesta.data.length <= 0) {
        Swal.fire({
          icon: "warning",
          title: "Datos vacios",
          text: "Parece que no tiene usuarios registrados",
        });
      } else {
        const registro = respuesta.data[0];
        nombre.value = registro.nombre;
        usuario.value = registro.usuario;
        correo.value = registro.correo;
      }
    });
};

/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async (id) => {
  Swal.fire({
    title: "Eliminando usuario",
    text: "Estas seguro que deseas eliminar al usuario!",
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
        `./app/entidades/usuarios/http.php/?delete=${id}`,
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
          "El usuario a sido eliminado de la base de datos",
          "success"
        );
        await obtnerUsuarios();
      }
    }
  });
};

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = {
    id_rol: 1,
    nombre: nombre.value,
    usuario: usuario.value,
    password: password.value,
    correo: correo.value,
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
    await obtnerUsuarios(search.value);
  }
});

window.onload = async () => {
  await obtnerUsuarios();
};

document.querySelector(".btn-close").addEventListener("click", () => {
  action = "guardar";
});
document
  .querySelector(".modal-footer .btn.btn-secondary")
  .addEventListener("click", () => {
    action = "guardar";
  });
