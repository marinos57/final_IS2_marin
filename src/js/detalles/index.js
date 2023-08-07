import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";

const formulario = document.querySelector('form')
const tabla_citas = document.getElementById('tabla_citas');
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('divTabla');

const buscar = async () => {
    let fecha_busqueda = formulario.fecha_busqueda.value;

    const url = `/final_IS2_marin/API/detalles/buscar`; // Ruta de la API para buscar citas
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
    
            // const tabla_citas = document.getElementById("tabla_citas");
            tabla_citas.tBodies[0].innerHTML = '';
    
            if (data.length > 0) {
                // Crear el encabezado de la tabla
                const encabezado = document.createElement("tr");
                encabezado.innerHTML = `<th colspan="6">CITAS PARA EL DÍA DE HOY Y LA FECHA QUE SE BUSCÓ: ${fecha_busqueda}</th>`;
                tabla_citas.appendChild(encabezado);
    
                const encabezado2 = document.createElement("tr");
                encabezado2.innerHTML = `<th>CLINICA_NOMBRE</th><th>MEDICO_NOMBRE</th><th>NO</th><th>PACIENTE</th><th>DPI</th><th>TELEFONO</th><th>HORA DE LA CITA</th><th>REFERIDO (SI/NO)</th>`;
                tabla_citas.appendChild(encabezado2);
    
                // Recorrer los datos y construir las filas de la tabla
                data.forEach((fila) => {
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
                    const columnasPaciente = ["NO", "PACIENTE", "DPI", "TELEFONO", "HORA DE LA CITA", "REFERIDO"];
                    columnasPaciente.forEach((columna) => {
                        const nuevaColumna = document.createElement("td");
                        nuevaColumna.textContent = fila[columna.toLowerCase()] || ""; // Agregar datos del paciente o dejar vacío si no hay valor
                        nuevaFila.appendChild(nuevaColumna);
                    });
    
                    // Agregar la fila a la tabla
                    tabla_citas.appendChild(nuevaFila);
                });
            } else {
                // Mostrar mensaje si no existen registros
                const nuevaFila = document.createElement('tr');
                const nuevaColumna = document.createElement('td');
                nuevaColumna.innerText = 'No existen registros';
                nuevaColumna.colSpan = 8;
                nuevaFila.appendChild(nuevaColumna);
                tabla_citas.tBodies[0].appendChild(nuevaFila);
            }
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