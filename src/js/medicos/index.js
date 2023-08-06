import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";

const formulario = document.querySelector('form')
const tablaMedicos = document.getElementById('tablaMedicos');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('divTabla');

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

const guardar = async (evento) => {
    evento.preventDefault();
    if(!validarFormulario(formulario, ['medico_id'])){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return 
    }

    const body = new FormData(formulario)
    body.delete('medico_id')
    const url = '/final_IS2_marin/API/medicos/guardar';
    const config = {
        method : 'POST',
        // body: otroNombre
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        // return
        
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const buscar = async () => {

    let medico_nombre = formulario.medico_nombre.value;
    let medico_especialidad = formulario.medico_especialidad.value;
    let medico_clinica = formulario.medico_clinica.value;
    const url = `/final_IS2_marin/API/medicos/buscar?medico_nombre=${medico_nombre}&medico_especialidad=${medico_especialidad}&medico_clinica=${medico_clinica}`;
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        
        tablaMedicos.tBodies[0].innerHTML = ''
        const fragment = document.createDocumentFragment();
        console.log(data);
        // return;
        if(data.length > 0){
            let contador = 1;
            data.forEach( medico => {
                // CREAMOS ELEMENTOS
                const tr = document.createElement('tr');
                const td1 = document.createElement('td')
                const td2 = document.createElement('td')
                const td3 = document.createElement('td')
                const td4 = document.createElement('td')
                const td5 = document.createElement('td')
                const td6 = document.createElement('td')
                const buttonModificar = document.createElement('button')
                const buttonEliminar = document.createElement('button')

                // CARACTERISTICAS A LOS ELEMENTOS
                buttonModificar.classList.add('btn', 'btn-warning')
                buttonEliminar.classList.add('btn', 'btn-danger')
                buttonModificar.textContent = 'Modificar'
                buttonEliminar.textContent = 'Eliminar'

                buttonModificar.addEventListener('click', () => colocarDatos(medico))
                buttonEliminar.addEventListener('click', () => eliminar(medico.medico_id))

                td1.innerText = contador;
                td2.innerText = medico.medico_nombre
                td3.innerText = medico.medico_especialidad
                td4.innerText = medico.medico_clinica

                
                
                // ESTRUCTURANDO DOM
                td5.appendChild(buttonModificar)
                td6.appendChild(buttonEliminar)
                tr.appendChild(td1)
                tr.appendChild(td2)
                tr.appendChild(td3)
                tr.appendChild(td4)
                tr.appendChild(td5)
                tr.appendChild(td6)


                fragment.appendChild(tr);

                contador++;
            })
        }else{
            const tr = document.createElement('tr');
            const td = document.createElement('td')
            td.innerText = 'No existen registros'
            td.colSpan = 5
            tr.appendChild(td)
            fragment.appendChild(tr);
        }

        tablaMedicos.tBodies[0].appendChild(fragment)
    } catch (error) {
        console.log(error);
    }
}

const colocarDatos = (datos) => {
    formulario.medico_nombre.value = datos.medico_nombre
    formulario.medico_especialidad.value = datos.medico_especialidad
    formulario.medico_clinica.value = datos.medico_clinica
    formulario.medico_id.value = datos.medico_id

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none'
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none'
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = ''
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = ''
    divTabla.style.display = 'none'

    // modalEjemploBS.show();
}

const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
    divTabla.style.display = ''
}

const modificar = async () => {
    if(!validarFormulario(formulario)){
        alert('Debe llenar todos los campos');
        return 
    }

    const body = new FormData(formulario)
    const url = '/final_IS2_marin/API/medicos/modificar';
    const config = {
        method : 'POST',
        body
    }

    try {
        // fetch(url, config).then( (respuesta) => respuesta.json() ).then(d => data = d)
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                cancelarAccion();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const eliminar = async (id) => {
    if(await confirmacion('warning','¿Desea eliminar este registro?')){
        const body = new FormData()
        body.append('medico_id', id)
        const url = '/final_IS2_marin/API/medicos/eliminar';
        const config = {
            method : 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            console.log(data)
            const {codigo, mensaje,detalle} = data;
    
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(detalle)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}
buscar();
formulario.addEventListener('submit', guardar )
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)

// Obtener los elementos con los datos almacenados
const clinicaSelect = document.getElementById('clinica_select');
const especialidadSelect = document.getElementById('especialidad_select');

// Obtener los datos de clínicas y especialidades desde los atributos data-*
const clinicasData = JSON.parse(clinicaSelect.getAttribute('data-clinicas'));
const especialidadesData = JSON.parse(especialidadSelect.getAttribute('data-especialidades'));

// Función para generar los selects de clínicas y especialidades
function agregarSelects(clinicas, especialidades) {
  // Generar el select de clínicas
  let selectHTML = '<label for="medico_clinica">Asignar Clínica al Médico</label>';
  selectHTML += '<select class="form-control" id="medico_clinica" name="medico_clinica">';
  clinicas.forEach(clinica => {
    selectHTML += `<option value="${clinica.id}">${clinica.nombre}</option>`;
  });
  selectHTML += '</select>';
  clinicaSelect.innerHTML = selectHTML;

  // Generar el select de especialidades
  selectHTML = '<label for="medico_especialidad">Especialidad del Médico</label>';
  selectHTML += '<select class="form-control" id="medico_especialidad" name="medico_especialidad">';
  especialidades.forEach(especialidad => {
    selectHTML += `<option value="${especialidad.id}">${especialidad.nombre}</option>`;
  });
  selectHTML += '</select>';
  especialidadSelect.innerHTML = selectHTML;
}

// Llamar la función con los datos pasados desde los atributos data-*
agregarSelects(clinicasData, especialidadesData);