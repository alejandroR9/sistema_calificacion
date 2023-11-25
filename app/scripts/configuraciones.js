const modal = document.getElementById("register");
const search = document.getElementById("search");

const nombre = document.getElementById("nombre");
const direccion = document.getElementById("direccion");
const celular = document.getElementById("celular");
const foto = document.getElementById("foto");
const logo = document.getElementById("logo");

//Esta variabe identifica si se hara un registro o una modificacion
let action = "guardar";
let idRegistro = 0;

/******************************************************************
 * Funcion para insertar
 ******************************************************************/
const insertar = async (data) => {
  const formData = new FormData();
  formData.append("nombre", data.nombre);
  formData.append("direccion", data.direccion);
  formData.append("celular", data.celular);
  formData.append("foto", foto.files[0]); // Agrega la imagen
  formData.append("logo", logo.files[0]); // Agrega la imagen

  const options = {
    method: "POST",
    body: formData,
  };
  const respuesta = await fetch(
    "./app/entidades/configuraciones/http.php",
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de razon social",
      text: "Por favor ingresa el nombe de la institución.",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Curso registrado",
      text: "Los datos de la entidad han sido registrados",
    });
    await obtnerRegistros();
  }
};

/******************************************************************
 * Funcion para modificar un registro
 ******************************************************************/
const modificar = async (data) => {
  const formData = new FormData();
  formData.append("nombre", data.nombre);
  formData.append("direccion", data.direccion);
  formData.append("celular", data.celular);
  formData.append("foto", foto.files[0]); // Agrega la imagen
  formData.append("logo", logo.files[0]); // Agrega la imagen
  formData.append("id", idRegistro); // Agrega la imagen
  const options = {
    method: "POST",
    body: formData,
  };
  const respuesta = await fetch(
    `./app/entidades/configuraciones/http.php`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.message === "nombre vacio") {
    Swal.fire({
      icon: "error",
      title: "Error de razón social",
      text: "Por favor ingresa la razón social de la institución",
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Datos de la intitución modificado",
      text: "Los datos de las intitución a sido modificado con éxito",
    });
    await obtnerRegistros();
  }
};

/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtnerRegistros = async () => {
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/configuraciones/http.php`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length <= 0) {
    action = "guardar";
  } else {
    const data = respuestaData.data[0]
    idRegistro = data.id;
    nombre.value = data.nombre;
    direccion.value = data.direccion;
    celular.value = data.celular;
    document.getElementById('img-foto').src = data.foto;
    document.getElementById('img-logo').src = data.logo;
    celular.value = data.celular;
    action = "modificar";
  }
};

modal.addEventListener("submit", async (e) => {
  e.preventDefault();
  const data = {
    nombre: nombre.value,
    direccion: direccion.value,
    celular: celular.value,
    logo: logo.value,
    foto: foto.value,
    id:idRegistro
  };
  if (action === "guardar") {
    await insertar(data);
  } else {
    await modificar(data);
  }
  action = "guardar";
  await obtnerRegistros()
});

window.onload = async () => {
  await obtnerRegistros();
};
