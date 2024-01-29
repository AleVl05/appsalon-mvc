let paso = 1;
const pasoInicial = 1
const pasoFinal = 3

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){
    mostrarSeccion();
    tabs(); // cambia la seccion cuendo se presionen los tabs
    botonesPaginador(); 
    paginaAnterior();
    paginaSiguiente();

    consultarAPI();

    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

    mostarResumen();
}

function mostrarSeccion(){
    const seleccionAnterior = document.querySelector('.mostrar') // selecciona el que tenga la clase
    if (seleccionAnterior) {
        seleccionAnterior.classList.remove('mostrar');
    }

    //Seleccionar la seccion con el paso...
    const seccion = document.querySelector(`#paso-${paso}`) //selecciona el elemento con el id igual al paso seleccionado actualmente, que cambia en tabs();
    if (seccion) {
        seccion.classList.add('mostrar'); // al que hagas click le pondra esa clase de mostrar
    }
    


    const tabanterior = document.querySelector('.actual') // selecciona el que tenga la clase
    if (tabanterior) {
        tabanterior.classList.remove('actual');
    }


    // agregar y cambiar la varible de paso segun el tab seleccionado
    const tab = document.querySelector(`[data-paso="${paso}"]`) //selecciona el data set con el paso actual
    tab.classList.add('actual'); //añade la clase actual que le da colores de seleccionado
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button') // la clase tabs y los tipo button
    
    botones.forEach(boton => { // no puedes ponerle a todos los del SelectorAll al mismo tiempo, por eso se usa un foreach 
        boton.addEventListener('click', function(e){ 
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
            
        });
    });
}

function botonesPaginador() {
    const botonAnterior = document.querySelector('#anterior');
    const botonSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.add('ocultar');
        mostarResumen();
    } else {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior= document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        
        if(paso <= pasoInicial){
            return;
        }
        paso--;
        
        botonesPaginador();
    })
}

function paginaSiguiente() {
    
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        
        if(paso >= pasoFinal){
            return;
        }
        paso++;

        botonesPaginador();
    })
}

async function consultarAPI(){

    try {
        const url = "http://localhost:3000/api/servicios"
        const resultado = await fetch(url);
        const servicios = await resultado.json(); // ese .json trae el .json de la url, 
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio // esto es lo mismo que poner id = servicio.id y nombre = servicio.nombre y precio = servicio.precio

        const nombreServicio = document.createElement('P'); //crea un parafo
        nombreServicio.classList.add('nombre-servicio') // a ese parrafo le pone esta clase
        nombreServicio.textContent = nombre; // el contenido sera igual al nombre de la DB

        
        const precioServicio = document.createElement('P'); 
        precioServicio.classList.add('precio-servicio') 
        precioServicio.textContent = `$${precio}`; 

        const ServicioDiv = document.createElement('DIV'); 
        ServicioDiv.classList.add('servicio') 
        ServicioDiv.dataset.idServicio = id; // crea un atributo personalisado con el nombre data-id-servicio y su valor es el id
        
        ServicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }
        
        
        //ServicioDiv.onclick = seleccionarServicio; // onclick almacena la funcion que quieras y la ejecuta cuando hagas click, sin embargo no puedes usar () porque ejecuta la funcion

        ServicioDiv.appendChild(nombreServicio); // pone a clase padre el DIV y el nombre de hijo
        ServicioDiv.appendChild(precioServicio); // pone a clase padre el DIV y el precio de hijo

        document.querySelector('#servicios').appendChild(ServicioDiv);
    })
}

function seleccionarServicio(servicio){
    const {id} = servicio
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)
    if(cita.servicios.some(agregado => agregado.id === id)){
       
        cita.servicios = cita.servicios.filter( agregado => agregado.id !== id) 
        divServicio.classList.remove('seleccionado')
    }
    else{
        cita.servicios = [...cita.servicios, servicio] //NO ENTIENDO ESOS 3 PUNTOS, SUPUESTAMENTE CREAN UNA COPIA pero no ENTIENDO
        //CREO QUE YA ENTENDI, como el elemento servicios de cita es un [] vacio, al sumarle un nuevo objeto sigue el array vacio, pero si a esa copia le añader servicio al parecer no pasa eso
        divServicio.classList.add('seleccionado')
    } 
    
}

function idCliente(){
    cita.id = document.querySelector('#id').value;
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value; //cita[nombre] sera igual al valor de el atributo HTML con el id nombre
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha')
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay(); //COMPLEJO, AQUI PARA USAR UTCday tienes que crear un nuevo objeto tipo date, y el getutc day es para que vea de la fecha en el calendario que el usuario selecciono es domingo o qualquier dia, siendo domingo 0 y sabado 6

        if([6,0].includes(dia)) { //ese es un array hecho al vuelo, solo para validar esos 2 jaja
            e.target.value = ''; // borra lo que el usuario puso de fecha
            mostrarAlerta('error','fines de semana no permitidos' , '.formulario');
        }
        else{
            cita.fecha = e.target.value //la fecha de la cita se asigna desde la fecha escogida

        }
    })
}

function seleccionarHora() {
    const inputHora  = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        
        const horaCita = e.target.value;
        const hora = horaCita.split(":"); //separa las horas y los minutos y retorna array
        if(hora[0] < 10 || hora[0] > 18){ // si el local esta fuera de sus horar validas
            e.target.value = ''
            mostrarAlerta('error', 'hora no valida', '.formulario')
        }
        else{
            cita.hora = e.target.value;
        }

    })
}

function mostrarAlerta(tipo, mensaje, elemento, desaparece = true) {

    const alertaPrevia = document.querySelector('.alerta') // si ya hay una alerta ...
    if (alertaPrevia){
        alertaPrevia.remove() //... elimina la que ya existe
    }


    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);


    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
   
    
}

function mostarResumen(){
    const resumen = document.querySelector('.contenido-resumen')

    while(resumen.firstChild) { // ELIMINA TODOS LOS HIJOS DE .contenido-resumen dice, mientras exista un primer hijo en resument entonces elimina ese primer hijo, osea que elimina todos
        resumen.removeChild(resumen.firstChild)
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0 ){ //comprueba si alguno de los valores de cita estan vacios
        mostrarAlerta('error', 'Faltan seleccionar servicio, fecha u hora', '.contenido-resumen', false)

        return;
    }
    
    const {nombre, fecha , hora , servicios} = cita;

    

    //heading para servicios

    const headingServicios = document.createElement('h3');
    headingServicios.textContent = 'Servicios que seleccionaste:'
    resumen.appendChild(headingServicios);

    servicios.forEach(servicio => {
        const {id, precio, nombre} = servicio;
        const contenedorServicio = document.createElement('DIV')
        contenedorServicio.classList.add('contenedor-servicio');

        const nombreServicio = document.createElement('p');
        nombreServicio.textContent = nombre;
        
        const precioServicio = document.createElement('p');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
        
    })

    //heading para citas
    const headingCitas = document.createElement('h3');
    headingCitas.textContent = 'citas que seleccionaste:'
    resumen.appendChild(headingCitas);
    
    const nombreCliente = document.createElement('P')
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`
    

    //convertir la fecha a español porque el profe es gay y no le gusta que queda 2021-10-04 jaja

    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year, mes, dia));

    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones)

    /*UNA JODA HACER ESO DE ARRIBA PERO LO QUE HACE ES TRANSFORMAR LA FECHA A ESPAÑOL jaja*/


    const fechaCliente = document.createElement('P')
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`
    
    const horaCliente = document.createElement('P')
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} Horas`


    //BOTON PARA ENVIAR A LA BASE DE DATOS Y ENVIAR TU CITA
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita; //no se le pone () porque si no llama la funcion

    resumen.appendChild(nombreCliente)
    resumen.appendChild(fechaCliente)
    resumen.appendChild(horaCliente )

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const {nombre, fecha, hora , servicios, id} = cita
    const idServicios = servicios.map( servicio => servicio.id)

    const datos = new FormData(); // es como crear un form sin ser un form en el HTML


    datos.append('usuarioId', id) //añade estos datos al objeto datos
    datos.append('fecha', fecha) // los nombres debes ser iguales a los de la db al parecer
    datos.append('hora', hora) // como lo mandas con post mas abajo, en php se vuelve $_POST['hora']
    datos.append('servicios', idServicios) //todo lo vuelve string!! por mas de que es un array
    //peticion hacia la api

    try {
        
        const url = `${location.origin}/api/citas` //la url de la API a la que le queremos pedir info
    const respuesta = await fetch(url, { //fetch pide informacion y debe decir que metodo busca
        method: 'POST', //MEDIANTE ESTO SE CONECTAN, si vez localhost:3000/api/citas tiene un post
        body: datos // ok ok, estos datos se mandaran en post a la url de arriba, esta url esta devolviendo los mismos datos que mandas. muy interesante
    });

    const resultado = await respuesta.json();
    console.log(resultado.resultado);

    if(resultado.resultado){
        Swal.fire({
            icon: "success",
            title: "Cita Agendada",
            text: "Tu cita fue agendada correctame!",
            button: 'OK'
          }).then( () => {
            window.location.reload();
          })
    }

    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error inesperado",
            text: "Ocurrio un error al agendar la cita, contacte con el soporte",
            button: 'OK'
        })
    }

    







    //console.log(respuesta) //retornara un codigo 200 en la consola si se conecto correctamente
    
    
    
    //console.log([...datos]); //ESTA ES LA UNICA FORMA DE VER QUE CONTINE UN FORMDATA, es un truco, donde estas imprimiendo una copia de datos, y si no seria una copia no podris ver que hay.
}


