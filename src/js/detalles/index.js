import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";

const formulario = document.querySelector('form')
const tablaCitas = document.getElementById('tablaCitas');
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('divTabla');

const buscar = async () => {
    // ... código de búsqueda y obtención de datos ...

    // Limpiamos la tabla antes de agregar nuevos datos
    tablaCitas.tBodies[0].innerHTML = '';

    if (data.length > 0) {
        let clinicaActual = '';
        let medicoActual = '';

        data.forEach(cita => {
            // CREAMOS ELEMENTOS
            const tr = document.createElement('tr');

            if (clinicaActual !== cita.clinica_nombre || medicoActual !== cita.medico_nombre) {
                // Fila para el nombre de la clínica y el médico
                const tdClinica = document.createElement('td');
                tdClinica.innerText = cita.clinica_nombre;
                tdClinica.colSpan = 6;
                tr.appendChild(tdClinica);

                const trMedico = document.createElement('tr');
                const tdMedico = document.createElement('td');
                tdMedico.innerText = 'Doctor ' + cita.medico_nombre;
                tdMedico.colSpan = 6;
                trMedico.appendChild(tdMedico);
                tablaCitas.tBodies[0].appendChild(trMedico);

                clinicaActual = cita.clinica_nombre;
                medicoActual = cita.medico_nombre;
            }

            const td1 = document.createElement('td');
            const td2 = document.createElement('td');
            const td3 = document.createElement('td');
            const td4 = document.createElement('td');
            const td5 = document.createElement('td');
            const td6 = document.createElement('td');

            td1.innerText = contador;
            td2.innerText = cita.paciente_nombre;
            td3.innerText = cita.paciente_dpi;
            td4.innerText = cita.paciente_telefono;
            td5.innerText = cita.cita_hora;
            td6.innerText = cita.cita_referencia;

            // ESTRUCTURANDO DOM
            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            tr.appendChild(td5);
            tr.appendChild(td6);

            tablaCitas.tBodies[0].appendChild(tr);

            contador++;
        });
    } else {
        // ... código en caso de no encontrar citas ...
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
