import {
    examenesAlumnos
  } from "./funcionReutilizables.js";
  const idAlumno = document.getElementById("login");
  window.onload = async () => {
    document.getElementById('dataBody').innerHTML = await examenesAlumnos(idAlumno.value);  
  };
  