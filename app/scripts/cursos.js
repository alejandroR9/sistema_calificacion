const modal = document.getElementById("register");
const search = document.getElementById("search");

const idnivel_academico = document.getElementById("idnivel_academico");
const nombre = document.getElementById("nombre");
const id_usuario = document.getElementById("login");

//Esta variabe identifica si se hara un registro o una modificacion
let action = "guardar";
let idRegistro = 0;

/******************************************************************
 * Funcion para insertar
 ******************************************************************/
const insertar = async (data) => {
    
    const formData = new FormData();
    formData.append('nombre', data.nombre);
    formData.append('creditos', data.creditos);
    formData.append('id_usuario', data.id_usuario);
    formData.append('idnivel_academico', data.idnivel_academico);
    formData.append('foto', foto.files[0]); // Agrega la imagen

  const options = {
    method: "POST",
    body: formData,
  };
  const respuesta = await fetch("./app/entidades/cursos/http.php", options);
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de nombre",
      text: "Por favor ingresa un nombre del curso.",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Curso registrado",
      text: "El curso a sido registrado con éxito",
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
    `./app/entidades/cursos/http.php/?id=${id}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de nombre",
      text: "Por favor ingresa un nombre del curso",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Curso modificado",
      text: "El curso a sido modificado con éxito",
    });
    await obtnerRegistros();
    $("#exampleModal").modal("hide");
  }
};

/******************************************************************
 * Funcion para obtener el nivel academico
 ******************************************************************/
const obtnerNiveles = async (search = "") => {
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
      text: "Parece que no tienes niveles academicos registrados",
    });
  } else {
    respuestaData.data.forEach((item) => {
      body += `
        <option value="${item.id}">${item.numero_de_nivel}° ${item.nivel}</option>
        `;
    });
    document.getElementById("idnivel_academico").innerHTML = body;
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
      `./app/entidades/cursos/http.php/?search=${search}`,
      options
    );
    const respuestaData = await respuesta.json();
    console.log(respuestaData);
    if (respuestaData.data.length <= 0) {
      Swal.fire({
        icon: "warning",
        title: "Datos vacios",
        text: "Parece que no tienes  cursos registrados",
      });
    } else {
      respuestaData.data.forEach((item) => {
        body += `
          <tr>
          <th><img style="width:40px" src="${item.foto}"/></th>
            <th>${item.nombre}</th>
            <td class="text-end">
              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" onClick="obtnerRegistro(${item.id})">
                  Modificar
              </button>
              <button class="btn btn-danger btn-sm" onClick="eliminar(${item.id})">
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
  fetch(`./app/entidades/cursos/http.php/?get=${id}`, options)
    .then((res) => res.json())
    .then((respuesta) => {
      if (respuesta.data.length <= 0) {
        Swal.fire({
          icon: "warning",
          title: "Datos vacios",
          text: "No pudimos encontrar los datos del curso seleccionado",
        });
      } else {
        const registro = respuesta.data[0];
        idnivel_academico.value = registro.idnivel_academico;
        nombre.value = registro.nombre;
        creditos.value = registro.creditos;
        foto.value = registro.foto;
      }
    });
};

/******************************************************************
 * Funcion para eliminar un registro
 ******************************************************************/
const eliminar = async (id) => {
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
        `./app/entidades/cursos/http.php/?delete=${id}`,
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
          "Curso elminado!",
          "El curso a sido eliminado de la base de datos",
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
    idnivel_academico: idnivel_academico.value,
    nombre: nombre.value,
    creditos: 0,
    foto: foto.value,
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

window.onload = async () => {
  await obtnerRegistros();
  await obtnerNiveles()
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
