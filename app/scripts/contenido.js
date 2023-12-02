const idCurso = document.getElementById("idcurso");
/******************************************************************
 * Funcion para obtener el listado de registros
 ******************************************************************/
const obtenerTemarios = async () => {
  let body = "";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  };
  const respuesta = await fetch(
    `./app/entidades/temarios/http.php/?get=${idCurso.value}`,
    options
  );
  const respuestaData = await respuesta.json();
  if (respuestaData.data.length > 0) {
    respuestaData.data.forEach((item, index) => {
        console.log(index);
      body += `
        <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${item.id}" aria-expanded="${index <= 0?'true':'false'}" aria-controls="collapse${item.id}">
               ${item.titulo}
            </button>
        </h2>
        <div id="collapse${item.id}" class="accordion-collapse collapse ${index <= 0?'show':''}" data-bs-parent="#dataTemario">
            <div class="accordion-body">
                ${item.descripcion}
            </div>
            <div class="p-4">${item.url_apk !== null?`
            <div class="card-body">
            <strong style="display:block">Requisitos:</strong>
            ${item.descripcion_apk}
            <strong  style="display:block">
            Peso: ${item.peso_apk}MB
            </strong>
            <a href="${item.url_apk}" class="btn btn-primary btn-sm">Descargar APK</a>
            </div>
            `:''} </div>
        </div>
          `;
    });
    document.getElementById("dataTemario").innerHTML = body;
  }
};

window.onload = () => {
  obtenerTemarios();
};
