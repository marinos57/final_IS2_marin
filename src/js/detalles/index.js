import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";

const formulario = document.querySelector('form')
const tablaCitas = document.getElementById('tablaCitas');
const btnBuscar = document.getElementById('btnBuscar');
const divTabla = document.getElementById('divTabla');

const buscar = async () => {
    let cita_paciente = formulario.cita_paciente.value;
    let cita_medico = formulario.cita_medico.value;
    let cita_fecha = formulario.cita_fecha.value;
    let cita_hora = formulario.cita_hora.value;
    let cita_referencia = formulario.cita_referencia.value;

    const url = `/final_IS2_marin/API/citas/buscar`;
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method : 'GET',
        headers,
            
    }

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        tablaCitas.tBodies[0].innerHTML = '';
        const fragment = document.createDocumentFragment();

        if (data.length > 0) {
            let contador = 1;
            data.forEach(cita => {
                // CREAMOS ELEMENTOS
                const tr = document.createElement('tr');
                const td1 = document.createElement('td');
                const td2 = document.createElement('td');
                const td3 = document.createElement('td');
                const td4 = document.createElement('td');
                const td5 = document.createElement('td');
                const td6 = document.createElement('td');
             
                td1.innerText = contador;
                td2.innerText = cita.paciente_nombre;
                td3.innerText = cita.medico_nombre; // Nombre del médico
                td4.innerText = cita.cita_fecha;
                td5.innerText = cita.cita_hora;
                td6.innerText = cita.cita_referencia;

                // ESTRUCTURANDO DOM
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                tr.appendChild(td6);
                tr.appendChild(td7);
                tr.appendChild(td8);

                fragment.appendChild(tr);

                contador++;
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