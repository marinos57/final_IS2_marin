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
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method : 'GET',
        headers,
            body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        
        tablaMedicos.tBodies[0].innerHTML = ''
        const fragment = document.createDocumentFragment();
        console.log(data);
        // return;
        if (data.length > 0) {
            let contador = 1;
            data.forEach(medico => {
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
                td2.innerText = medico.medico_nombre;
                td3.innerText = medico.especialidad_nombre; // Modificamos aquí
                td4.innerText = medico.clinica_nombre; // Modificamos aquí
        
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
        } else {
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
// Función para obtener los nombres de especialidades y clínicas
// const cargarSelects = async () => {
//     try {
//         // Obtener los nombres de especialidades
//         const respuestaEspecialidades = await fetch('/final_IS2_marin/API/especialidades');
//         const especialidades = await respuestaEspecialidades.json();
//         const selectEspecialidad = document.getElementById('medico_especialidad');
//         selectEspecialidad.innerHTML = '';
//         especialidades.forEach((especialidad) => {
//             const option = document.createElement('option');
//             option.value = especialidad.especialidad_id;
//             option.textContent = especialidad.especialidad_nombre;
//             selectEspecialidad.appendChild(option);
//         });

//         // Obtener los nombres de clínicas
//         const respuestaClinicas = await fetch('/final_IS2_marin/API/clinicas');
//         const clinicas = await respuestaClinicas.json();
//         const selectClinica = document.getElementById('medico_clinica');
//         selectClinica.innerHTML = '';
//         clinicas.forEach((clinica) => {
//             const option = document.createElement('option');
//             option.value = clinica.clinica_id;
//             option.textContent = clinica.clinica_nombre;
//             selectClinica.appendChild(option);
//         });
//     } catch (error) {
//         console.log(error);
//     }
// };

// Llamar a la función de buscar al cargar la página
//Función para obtener los nombres de especialidades y clínicas
// const cargarSelects = async () => {
//     try {
//         // Obtener los nombres de especialidades
//         const respuestaEspecialidades = await fetch('/final_IS2_marin/API/especialidades');
//         const especialidades = await respuestaEspecialidades.json();
//         const selectEspecialidad = document.getElementById('medico_especialidad');
//         selectEspecialidad.innerHTML = '';
//         especialidades.forEach((especialidad) => {
//             const option = document.createElement('option');
//             option.value = especialidad.especialidad_id;
//             option.textContent = especialidad.especialidad_nombre;
//             selectEspecialidad.appendChild(option);
//         });

//         // Obtener los nombres de clínicas
//         const respuestaClinicas = await fetch('/final_IS2_marin/API/clinicas');
//         const clinicas = await respuestaClinicas.json();
//         const selectClinica = document.getElementById('medico_clinica');
//         selectClinica.innerHTML = '';
//         clinicas.forEach((clinica) => {
//             const option = document.createElement('option');
//             option.value = clinica.clinica_id;
//             option.textContent = clinica.clinica_nombre;
//             selectClinica.appendChild(option);
//         });
//     } catch (error) {
//         console.log(error);
//     }
// };
// const buscarEspecialidades = async () => {
//     let especialidad_nombre = formulario.medico_especialidad.value;
//     const url = `/final_IS2_marin/API/especialidades/buscar?especialidad_nombre=${especialidad_nombre}`;
//     const config = {
//         method: 'GET',
//         headers: {
//             'Accept': 'application/json'
//         }
//     }

//     try {
//         const respuesta = await fetch(url, config);
//         const especialidades = await respuesta.json();

//         // Aquí se construye el select de especialidades
//         const selectEspecialidades = document.getElementById('especialidad_select');
//         selectEspecialidades.innerHTML = '';
//         especialidades.forEach(especialidad => {
//             const option = document.createElement('option');
//             option.value = especialidad.especialidad_id;
//             option.textContent = especialidad.especialidad_nombre;
//             selectEspecialidades.appendChild(option);
//         });

//      } catch (error) {
//         console.log('Error en la búsqueda de especialidades:', error);
//     }
// }

// const buscarClinicas = async () => {
//     let clinica_nombre = formulario.medico_clinica.value;
//     const url = `/final_IS2_marin/API/clinicas/buscar?clinica_nombre=${clinica_nombre}`;
//     const config = {
//         method: 'GET', 
//         headers: {
//             'Accept': 'application/json'
//         }
//     }

//     try {
//         const respuesta = await fetch(url, config);
//         const clinicas = await respuesta.json();

//         // Aquí se construye el select de clínicas
//         const selectClinicas = document.getElementById('clinica_select');
//         selectClinicas.innerHTML = '';
//         clinicas.forEach(clinica => {
//             const option = document.createElement('option');
//             option.value = clinica.clinica_id;
//             option.textContent = clinica.clinica_nombre;
//             selectClinicas.appendChild(option);
//         });

//     }   catch (error) {
//         console.log('Error en la búsqueda de medicos:', error);
//     }
// }

// buscar();


// // Llamar a la función buscarEspecialidades cuando se ingrese un valor en el campo de especialidad
// formulario.medico_especialidad.addEventListener('input', buscarEspecialidades);

// // Llamar a la función buscarClinicas cuando se ingrese un valor en el campo de clínica
// formulario.medico_clinica.addEventListener('input', buscarClinicas);



// index.js

// // Función para obtener los datos de especialidades y clínicas desde el servidor
// const obtenerDatos = async () => {
//     try {
//         // Realizar la solicitud al servidor para obtener los datos de especialidades y clínicas
//         const responseEspecialidades = await fetch('/final_IS2_marin/API/especialidades/');
//         const responseClinicas = await fetch('/final_IS2_marin/API//clinicas');

//         // Convertir las respuestas a formato JSON
//         const dataEspecialidades = await responseEspecialidades.json();
//         const dataClinicas = await responseClinicas.json();

//         // Construir los selects con los datos obtenidos
//         construirSelectEspecialidades(dataEspecialidades);
//         construirSelectClinicas(dataClinicas);
//     } catch (error) {
//         console.error(error);
//     }
// };

// // Función para construir el select de especialidades
// const construirSelectEspecialidades = (especialidades) => {
//     const especialidadSelect = document.getElementById('especialidad_select');
//     especialidades.forEach((especialidad) => {
//         const option = document.createElement('option');
//         option.value = especialidad.especialidad_id;
//         option.textContent = especialidad.especialidad_nombre;
//         especialidadSelect.appendChild(option);
//     });
// };

// // Función para construir el select de clínicas
// const construirSelectClinicas = (clinicas) => {
//     const clinicaSelect = document.getElementById('clinica_select');
//     clinicas.forEach((clinica) => {
//         const option = document.createElement('option');
//         option.value = clinica.clinica_id;
//         option.textContent = clinica.clinica_nombre;
//         clinicaSelect.appendChild(option);
//     });
// };

// // Llamar a la función para obtener los datos al cargar la página
// obtenerDatos();


// // Obtiene el elemento <select> de especialidades
// const especialidadSelect = document.getElementById('especialidad_select');

// // Obtén los datos de las especialidades desde el atributo data-especialidades del div
// const especialidadesData = especialidadSelect.dataset.especialidades;

// // Convierte los datos de especialidades a un array de JavaScript
// const especialidadesArray = JSON.parse(especialidadesData);

// // Limpia cualquier opción existente en el select
// especialidadSelect.innerHTML = '';

// // Agrega una opción vacía al inicio (opcional)
// const optionVacia = document.createElement('option');
// optionVacia.value = '';
// optionVacia.textContent = '-- Seleccione una especialidad --';
// especialidadSelect.appendChild(optionVacia);

// // Agrega las opciones de especialidades al select
// especialidadesArray.forEach((especialidad) => {
//     const option = document.createElement('option');
//     option.value = especialidad.id; // Asigna el valor de la especialidad (id)
//     option.textContent = especialidad.nombre; // Asigna el texto de la especialidad (nombre)
//     especialidadSelect.appendChild(option);
// });


// // Función para cargar los datos de los selects al inicio
// const cargarSelects = () => {
//     // Obtener los datos de las especialidades y clínicas desde el atributo "data" de los divs
//     const especialidadesData = document.getElementById('especialidad_select').dataset.especialidades;
//     const clinicasData = document.getElementById('clinica_select').dataset.clinicas;
  
//     // Convertir los datos a objetos JavaScript
//     const especialidades = JSON.parse(especialidadesData);
//     const clinicas = JSON.parse(clinicasData);
  
//     // Obtener los elementos select del formulario
//     const especialidadSelect = document.getElementById('medico_especialidad');
//     const clinicaSelect = document.getElementById('medico_clinica');
  
//     // Llenar los selects con las opciones de especialidades y clínicas
//     especialidades.forEach((especialidad) => {
//       const option = document.createElement('option');
//       option.value = especialidad.id; // Asumiendo que el ID de la especialidad es un valor único en la base de datos
//       option.textContent = especialidad.nombre;
//       especialidadSelect.appendChild(option);
//     });
  
//     clinicas.forEach((clinica) => {
//       const option = document.createElement('option');
//       option.value = clinica.id; // Asumiendo que el ID de la clínica es un valor único en la base de datos
//       option.textContent = clinica.nombre;
//       clinicaSelect.appendChild(option);
//     });
//   };
  
//   // Ejecutar la función al cargar la página
//   cargarSelects();

// // Obtener los elementos con los datos almacenados
// const clinicaSelect = document.getElementById('clinica_select');
// const especialidadSelect = document.getElementById('especialidad_select');

// // Obtener los datos de clínicas y especialidades desde los atributos data-*
// const clinicasData = JSON.parse(clinicaSelect.getAttribute('data-clinicas'));
// const especialidadesData = JSON.parse(especialidadSelect.getAttribute('data-especialidades'));

// // Función para generar los selects de clínicas y especialidades
// function agregarSelects(clinicas, especialidades) {
//   // Generar el select de clínicas
//   let selectHTML = '<label for="medico_clinica">Asignar Clínica al Médico</label>';
//   selectHTML += '<select class="form-control" id="medico_clinica" name="medico_clinica">';
//   clinicas.forEach(clinica => {
//     selectHTML += `<option value="${clinica.id}">${clinica.nombre}</option>`;
//   });
//   selectHTML += '</select>';
//   clinicaSelect.innerHTML = selectHTML;

//   // Generar el select de especialidades
//   selectHTML = '<label for="medico_especialidad">Especialidad del Médico</label>';
//   selectHTML += '<select class="form-control" id="medico_especialidad" name="medico_especialidad">';
//   especialidades.forEach(especialidad => {
//     selectHTML += `<option value="${especialidad.id}">${especialidad.nombre}</option>`;
//   });
//   selectHTML += '</select>';
//   especialidadSelect.innerHTML = selectHTML;
// }

// // Llamar la función con los datos pasados desde los atributos data-*
// agregarSelects(clinicasData, especialidadesData);