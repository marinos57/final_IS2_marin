import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";

const formulario = document.querySelector('form')
const tablaCitas = document.getElementById('tablaCitas');
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('divTabla');

const buscar = async () => {
    let cita_fecha = formulario.cita_fecha.value;

    const url = `/final_IS2_marin/API/citas/buscar`; // Ruta de la API para buscar citas
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const config = {
        method: 'GET',
        headers,
    }

    try {
        // Realizamos la petición a la API para obtener las citas
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();


        tablaCitas.tBodies[0].innerHTML = '';
        const fragment = document.createDocumentFragment();

        if (data.length > 0) {
            let contador = 1;
            data.forEach(cita => {
               // Suponiendo que 'resultados' contiene los datos de la consulta a la base de datos

                // Obtener la referencia a la tabla
                const tabla = document.getElementById("tabla_citas");

                // Obtener la referencia al elemento donde se mostrará la fecha de búsqueda
                const fechaBusquedaElement = document.getElementById("fecha_busqueda");

                // Mostrar la fecha de búsqueda en la cabecera de la tabla
                fechaBusquedaElement.textContent = "CITAS PARA EL DÍA DE HOY Y LA FECHA QUE SE BUSCÓ: " + fechaBusqueda;

                // Recorrer los resultados y construir las filas de la tabla
                resultados.forEach((fila) => {
                const nuevaFila = document.createElement("tr");

                // Columna 1: CLINICA_NOMBRE
                const columna1 = document.createElement("td");
                columna1.textContent = fila.clinica_nombre;
                nuevaFila.appendChild(columna1);

                // Columna 2: MEDICO_NOMBRE
                const columna2 = document.createElement("td");
                columna2.textContent = "DOCTOR " + fila.medico_nombre;
                nuevaFila.appendChild(columna2);

                // Columnas 3 a 8: Datos del paciente y cita
                const columnasPaciente = ["NO", "PACIENTE", "DPI", "TELEFONO", "HORA DE LA CITA", "REFERIDO (SI/NO)"];
                columnasPaciente.forEach((columna) => {
                    const nuevaColumna = document.createElement("td");
                    nuevaColumna.textContent = fila[columna.toLowerCase()] || ""; // Agregar datos del paciente o dejar vacío si no hay valor
                    nuevaFila.appendChild(nuevaColumna);
                });

                // Agregar la fila a la tabla
                tabla.appendChild(nuevaFila);
                });

        } else {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.innerText = 'No existen registros';
            td.colSpan = 8;
            tr.appendChild(td);
            fragment.appendChild(tr);
        }

        tablaCitas.tBodies[0].appendChild(fragment);
    } catch (error) {
        console.log(error);
    }
};


const colocarDatos = (datos) => {
    formulario.cita_paciente.value = datos.cita_paciente
    formulario.cita_medico.value = datos.cita_medico
    formulario.cita_fecha.value = datos.cita_fecha
    formulario.cita_hora.value = datos.cita_hora
    formulario.cita_referencia.value = datos.cita_referencia
    formulario.cita_id.value = datos.cita_id

    divTabla.style.display = 'none'

    // modalEjemploBS.show();
}

buscar();
formulario.addEventListener('submit', guardar )
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)