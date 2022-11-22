//===================================================================================================================================================================//
//================================================================== APP-USUARIOS CONTROLLER=========================================================================//
let tblUsuarios; //Tabla de Usuarios
document.addEventListener('DOMContentLoaded', function () {
    tblUsuarios = $('#tblUsuarios').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'num_empleado',
            },
            {
                'data': 'nombre',
            },
            {
                'data': 'departamento',
            },
            {
                'data': 'puesto',
            },
            {
                'data': 'localidad',
            },
            {
                'data': 'activo'
            },
            {
                'data': 'acciones'
            }
        ],
        dom: 'lBfrtip', "responsive": true, "lengthChange": true, "autoWidth": false,
        buttons: [
            'copy',
            'excel',
            {
                extend: 'print',
                text: 'Print',
                title: 'LISTA DE USUARIOS',
                footer: false,
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<img src="' + base_url + 'Assets/img/Telecel logo.svg' + '" style="position:absolute; top:0; right:0;" />',
                        );
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                extend: 'colvis',
                text:'Visualizar',
            }
        ],
    });
});

//-------Funcion change copiar permisos de un usuario Existente-------//
$('#copiar_datos_usuario').on('change', function () {

    $empleado_seleccionado = document.getElementById('copiar_datos_usuario').value; //Guardamos el valor que contiene el input

    if ($empleado_seleccionado == "") { //Evaluamos que la seleccion sea diferente a nulo
        document.getElementById("frmUsuario").reset(); //Resetear Formulario al cerral el modal
    } else {
        const url = base_url + "Usuarios/duplicar_usuario/" + $empleado_seleccionado; // Construimos la base URL del CONTROLADOR
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText);

                const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

                document.getElementById("num_empleado").value = res.numero_emp; //Obtener valor del usuario a Copiar
                document.getElementById("nombre_emp").value = res.nombre; //Obtener valor del usuario a Copiar
                document.getElementById("departamento_id").value = res.departamento_id; //Obtener valor del usuario a Copiar
                document.getElementById("localidad_id").value = res.localidad_id; //Obtener valor del usuario a Copiar
                document.getElementById("puesto").value = res.puesto; //Obtener valor del usuario a Copiar
                document.getElementById("region").value = res.region; //Obtener valor del usuario a Copiar
                document.getElementById("gerencia_id").value = res.gerencia_id; //Obtener valor del usuario a Copiar
                document.getElementById("mail").value = res.mail; //Obtener valor del usuario a Copiar
                document.getElementById("telefono").value = res.telefono; //Obtener valor del usuario a Copiar

            }
        }
    }
});

//----------------Abrir Modal Registrar Nuevo Usuario-----------------//
function frmUsuario() {
    document.getElementById("title").innerHTML = "Nuevo Usuario"; //Poner titulo al modal
    document.getElementById("btn_nuevo_usuario").innerHTML = "Save"; //Poner titulo al boton
    document.getElementById('num_empleado').readOnly = false;
    document.getElementById("frmUsuario").reset();
    $('#nuevo_usuario').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_usuario").modal("show");
    document.getElementById("id").value = "";
}

//----------------Funcion Registrar Usuario Nuevo--------------------//
function registrarUser(e) {
    e.preventDefault();
    //Datos generales del Usuario
    const num_empleado = document.getElementById("num_empleado"); //Tomamos el elemento de la por medio del ID
    const mail = document.getElementById("mail"); //Tomamos el elemento de la por medio del ID
    const departamento_id = document.getElementById("departamento_id"); //Tomamos el elemento de la por medio del ID
    const localidad_id = document.getElementById("localidad_id"); //Tomamos el elemento de la por medio del ID
    const puesto = document.getElementById("puesto"); //Tomamos el elemento de la por medio del ID
    const nombre_emp = document.getElementById("nombre_emp"); //Tomamos el elemento de la por medio del ID
    const clave = document.getElementById("clave"); //Tomamos el elemento de la por medio del ID
    const confirmar = document.getElementById("confirmar"); //Tomamos el elemento de la por medio del ID
    const region = document.getElementById("region"); //Tomamos el elemento de la por medio del ID
    const gerencia_id = document.getElementById("gerencia_id"); //Tomamos el elemento de la por medio del ID
    const telefono = document.getElementById("telefono"); //Tomamos el elemento de la por medio del ID
    const num_emp_jefe = document.getElementById("num_emp_jefe"); //Tomamos el elemento de la por medio del ID


    if (num_empleado.value == "" | mail.value == "" | departamento_id.value == "" | localidad_id.value == "" | puesto.value == "" | nombre_emp.value == "" |
        clave.value == "" | confirmar.value == "" | region.value == "" | gerencia_id.value == "" | telefono.value == "" | num_emp_jefe.value == "") { //Se evaluan que todos los campos esten llenos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios' //Mensaje de campos obligatorios
        })


    } else {
        numero_de_empleado = num_empleado.value; //Guardamos la variable numero de empleado para revisar su longitud y no ingresar un valor superior al int en Mysql
        if (numero_de_empleado.length > 6) { // Realizamo sla validacion de la longitud del numero de empela
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: 'No. empleado mayor a 6 caracteres' //Mensaje de campos obligatorios
            })
        } else {
            const url = base_url + "Usuarios/registrar"; // Construimos la base URL del CONTROLADOR
            const frm = document.getElementById("frmUsuario"); // Seleccionamos el contenido del formulario
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(new FormData(frm)); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                    console.log(this.responseText);

                    const res = JSON.parse(this.responseText);

                    if (res == "si") { //Si el usuario fue guardado correctamente mandamos un swal alert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Usuario Registrado' //Mensaje de usuario registrado
                        })

                        frm.reset();
                        $("#nuevo_usuario").modal("hide");
                        tblUsuarios.ajax.reload();

                    } else if (res == "modificado") { //Evaluamos el al guardar el usuario hubo algun error
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Usuario Modificado'
                        })

                        //frm.reset();
                        //$("#nuevo_usuario").modal("hide");
                        tblUsuarios.ajax.reload();


                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: res
                        })
                    }
                }
            }
        }
    }

}

//---------------------Funcion Editar usuario------------------------//
function btnEditarUser(id) {

    if (id == 1) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No se puede modificar este Usuario"
        })
    } else {

        const url = base_url + "Usuarios/editar/" + id; // Construimos la base URL del CONTROLADOR
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST

                document.getElementById("id").value = res.id; //Obtener valor del usuario a actualizar
                document.getElementById("num_empleado").value = res.num_empleado; //Obtener valor del usuario a actualizar
                document.getElementById("mail").value = res.mail; //Obtener valor del usuario a actualizar
                document.getElementById("departamento_id").value = res.departamento_id; //Obtener valor del usuario a actualizar
                document.getElementById("localidad_id").value = res.localidad_id; //Obtener valor del usuario a actualizar
                document.getElementById("puesto").value = res.puesto; //Obtener valor del usuario a actualizar

                document.getElementById("nombre_emp").value = res.nombre; //Obtener valor del usuario a actualizar
                document.getElementById("clave").value = res.password; //Obtener valor del usuario a actualizar
                document.getElementById("confirmar").value = res.password; //Obtener valor del usuario a actualizar
                document.getElementById("region").value = res.region; //Obtener valor del usuario a actualizar
                document.getElementById("gerencia_id").value = res.gerencia_id; //Obtener valor del usuario a actualizar
                document.getElementById("telefono").value = res.telefono; //Obtener valor del usuario a actualizar
                document.getElementById("num_emp_jefe").value = res.num_emp_jefe; //Obtener valor del usuario a actualizar

                document.getElementById('num_empleado').readOnly = true;
            }
        }

        document.getElementById("title").innerHTML = "Actualizar Usuario"; //Poner titulo al modal
        document.getElementById("btn_nuevo_usuario").innerHTML = "Save"; //Poner titulo al boton
        document.getElementById("copiar_datos_usuario").disabled = true;


        $('#nuevo_usuario').modal({ //Evitar cierre del modal por click outsite
            backdrop: 'static',
            keyboard: false
        });
        $("#nuevo_usuario").modal("show");

    }

}

//---------------------Funcion Eliminar usuario----------------------//
function btnEliminarUser(id) {
    if (id == 1) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No puedes eliminar este usuario"
        })
    } else {
        Swal.fire({
            title: `Eliminar Usuario`,
            text: "El usuario no se eliminara de forma permanente, solo cambiara a inactivo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {

                const url = base_url + "Usuarios/eliminar/" + id; // Construimos la base URL del CONTROLADOR
                const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
                http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
                http.send(); //Enviamos todo el formulario 
                http.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                        const res = JSON.parse(this.responseText);
                        if (res == "ok") {
                            Swal.fire(
                                'Mensaje!',
                                'Usuario Eliminado Correctamente',
                                'success'
                            )
                            tblUsuarios.ajax.reload();
                        } else {
                            Swal.fire(
                                'Mensaje!',
                                res,
                                'error'
                            )
                        }
                    }
                }
            }
        })
    }
}

//---------------------Funcion Reingresar usuario--------------------//
function btnReingresarUser(id) {
    Swal.fire({
        title: `Reingresar Usuario`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Usuarios/reingresar/" + id; // Construimos la base URL del CONTROLADOR
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Mensaje!',
                            'Usuario Reingresado Correctamente',
                            'success'
                        )
                        tblUsuarios.ajax.reload();
                    } else {
                        Swal.fire(
                            'Mensaje!',
                            res,
                            'error'
                        )
                    }
                }
            }
        }
    })
}

//----------------------Funcion Cerrar Modal------------------------//
function cerrarModalUsuario() {
    document.getElementById("frmUsuario").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id").value = ""; //Igualar id a ""
    document.getElementById("copiar_datos_usuario").disabled = false;
    document.getElementById('num_empleado').readOnly = false;
}
//================================================================== APP-USUARIOS CONTROLLER=========================================================================//
//===================================================================================================================================================================//





//===================================================================================================================================================================//
//================================================================== APP-CATALOGOS CONTROLLER=========================================================================//
//============================================================================//
//============================LOCALIDADES ====================================//
let tblLocalidades; //Tabla de Localidades
document.addEventListener('DOMContentLoaded', function () {
    tblLocalidades = $('#tblLocalidades').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Catalogos/listarLocalidades",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'localidad',
            },
            {
                'data': 'activo'
            },
            {
                'data': 'acciones'
            }
        ],
        "bLengthChange": false,
        "bInfo": false,
    });
});

function frmLocalidad() {  //Funcion abrir modal Registrar nueva Localidad
    document.getElementById("title_localidad").innerHTML = "Nueva Localidad"; //Poner titulo al modal
    document.getElementById("btnAccion_localidad").innerHTML = "Registrar"; //Poner titulo al boton
    document.getElementById("frmLocalidad").reset();
    $('#nuevo_localidad').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_localidad").modal("show");
    document.getElementById("id_localidad").value = "";
}

//----------------Funcion Cerrar Modal-----------------//
function cerrarModalLocalidad() {
    document.getElementById("frmLocalidad").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_localidad").value = ""; //Igualar id a ""
}

//--------Funcion Registrar Localidad Nuevo-----------//
function registrarLocalidad(e) {
    e.preventDefault();
    //Datos generales de la Localidad
    const localidad = document.getElementById("localidad"); //Tomamos el elemento de la por medio del ID

    if (localidad.value == "") { //Se evaluan que todos los campos esten llenos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios' //Mensaje de campos obligatorios
        })


    } else {
        const url = base_url + "Catalogos/registrarLocalidad"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmLocalidad"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                const res = JSON.parse(this.responseText);
                if (res == "si") { //Si la Localidad fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Localidad Registrada Registrada' //Mensaje de localidad registrado
                    })

                    frm.reset();
                    $("#nuevo_localidad").modal("hide");
                    tblLocalidades.ajax.reload();

                } else if (res == "modificado") { //Evaluamos el al guardar la localidad hubo algun error
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Localidad Modificada'
                    })

                    tblLocalidades.ajax.reload();

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }

}

//----------------Funcion Editar usuario-----------------//
function btnEditarLocalidad(id) {

    const url = base_url + "Catalogos/editarLocalidad/" + id; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST
            document.getElementById("id_localidad").value = res.id; //Obtener valor del localidad a actualizar
            document.getElementById("localidad").value = res.localidad; //Obtener valor del localidad a actualizar
        }
    }

    document.getElementById("title_localidad").innerHTML = "Actualizar Localidad"; //Poner titulo al modal
    document.getElementById("btnAccion_localidad").innerHTML = "Actualizar"; //Poner titulo al boton


    $('#nuevo_localidad').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_localidad").modal("show");

}
//============================ LOCALIDADES ======================================//
//===============================================================================//
//===============================================================================//
//============================ DEPARTAMENTOS ====================================//

let tblDepartamentos; //Tabla de Departamentos
document.addEventListener('DOMContentLoaded', function () {
    tblDepartamentos = $('#tblDepartamentos').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Catalogos/listarDepartamentos",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'departamento',
            },
            {
                'data': 'activo'
            },
            {
                'data': 'acciones'
            }
        ],
        "bLengthChange": false,
        "bInfo": false,
    });
});

function frmDepartamento() {  //Funcion abrir modal Registrar nueva Departamento
    document.getElementById("title_departamento").innerHTML = "Nuevo Departamento"; //Poner titulo al modal
    document.getElementById("btnAccion_departamento").innerHTML = "Registrar"; //Poner titulo al boton
    document.getElementById("frmDepartamento").reset();
    $('#nuevo_departamento').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_departamento").modal("show");
    document.getElementById("id_departamento").value = "";
}

//----------------Funcion Cerrar Modal Departamento-----------------//
function cerrarModalDepartamento() {
    document.getElementById("frmDepartamento").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_departamento").value = ""; //Igualar id a ""
}

//--------Funcion Registrar Departamento Nuevo-----------//
function registrarDepartamento(e) {
    e.preventDefault();
    //Datos generales de la Departamento
    const departamento = document.getElementById("departamento"); //Tomamos el elemento de la por medio del ID

    if (departamento.value == "") { //Se evaluan que todos los campos esten llenos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios' //Mensaje de campos obligatorios
        })


    } else {
        const url = base_url + "Catalogos/registrarDepartamento"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmDepartamento"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                const res = JSON.parse(this.responseText);
                if (res == "si") { //Si el Departamento fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Departamento Registrado' //Mensaje de departamento registrado
                    })

                    frm.reset();
                    $("#nuevo_departamnto").modal("hide");
                    tblDepartamentos.ajax.reload();

                } else if (res == "modificado") { //Evaluamos el al guardar la departamento hubo algun error
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Departamento Modificado'
                    })

                    tblDepartamentos.ajax.reload();

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }

}

//----------------Funcion Editar Departamento-----------------//
function btnEditarDepartamento(id) {

    const url = base_url + "Catalogos/editarDepartamento/" + id; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST
            document.getElementById("id_departamento").value = res.id; //Obtener valor de la departamento a actualizar
            document.getElementById("departamento").value = res.departamento; //Obtener valor del departamento a actualizar
        }
    }

    document.getElementById("title_departamento").innerHTML = "Actualizar Departamento"; //Poner titulo al modal
    document.getElementById("btnAccion_departamento").innerHTML = "Actualizar"; //Poner titulo al boton


    $('#nuevo_departamento').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_departamento").modal("show");

}
//============================ DEPARTAMENTOS ====================================//
//===============================================================================//
//===============================================================================//
//============================== GERANCIAS ======================================//

let tblGerencias; //Tabla de Gerencias
document.addEventListener('DOMContentLoaded', function () {
    tblGerencias = $('#tblGerencias').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Catalogos/listarGerencias",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'gerencia',
            },
            {
                'data': 'activo'
            },
            {
                'data': 'acciones'
            }
        ],
        "bLengthChange": false,
        "bInfo": false,

    });
});

function frmGerencia() {  //Funcion abrir modal Registrar nueva Gerencia
    document.getElementById("title_gerencia").innerHTML = "Nueva Gerencia"; //Poner titulo al modal
    document.getElementById("btnAccion_gerencia").innerHTML = "Registrar"; //Poner titulo al boton
    document.getElementById("frmGerencia").reset();
    $('#nuevo_gerencia').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_gerencia").modal("show");
    document.getElementById("id_gerencia").value = "";
}

function cerrarModalGerencia() {
    document.getElementById("frmDepartamento").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_departamento").value = ""; //Igualar id a ""
}

//--------Funcion Registrar Gerencia Nueva-----------//
function registrarGerencia(e) {
    e.preventDefault();
    //Datos generales de la gerencia
    const gerencia = document.getElementById("gerencia"); //Tomamos el elemento de la por medio del ID

    if (gerencia.value == "") { //Se evaluan que todos los campos esten llenos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios' //Mensaje de campos obligatorios
        })


    } else {
        const url = base_url + "Catalogos/registrarGerencia"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmGerencia"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            console.log(this.responseText);

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                const res = JSON.parse(this.responseText);
                if (res == "si") { //Si la Gerencia fue guardada correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Gerencia Registrada' //Mensaje de gerencia registrada
                    })

                    frm.reset();
                    $("#nuevo_gerencia").modal("hide");
                    tblGerencias.ajax.reload();

                } else if (res == "modificado") { //Evaluamos el al guardar la gerencia hubo algun error
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Gerencia Modificada'
                    })

                    tblDepartamentos.ajax.reload();

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }

}

//----------------Funcion Editar Gerencia-----------------//
function btnEditarGerencia(id) {

    const url = base_url + "Catalogos/editarGerencia/" + id; // Construimos la base URL del CONTROLADOR
    const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
    http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
    http.send(); //Enviamos todo el formulario 
    http.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

            const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST
            document.getElementById("id_gerencia").value = res.id; //Obtener valor de la gerencia a actualizar
            document.getElementById("gerencia").value = res.gerencia; //Obtener valor del gerencia a actualizar
        }
    }

    document.getElementById("title_gerencia").innerHTML = "Actualizar Departamento"; //Poner titulo al modal
    document.getElementById("btnAccion_gerencia").innerHTML = "Actualizar"; //Poner titulo al boton


    $('#nuevo_gerencia').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_gerencia").modal("show");

}
//================================ GERANCIAS ====================================//
//===============================================================================//
//================================================================== APP-CATALOGOS CONTROLLER=========================================================================//
//===================================================================================================================================================================//

//===================================================================================================================================================================//
//================================================================== APP-PERFIL CONTROLLER=========================================================================//

function registrarChangePassword() {
    password_actual = document.getElementById("password_actual"); //Tomamos el valor por el id
    password_nueva = document.getElementById("password_nueva"); //Tomamos el valor por el id
    password_confirmar = document.getElementById("password_confirmar"); //Tomamos el valor por el id

    if (password_actual.value == "") { //Evaluamos si tiene contenido
        password_nueva.classList.remove("is-invalid");
        password_confirmar.classList.remove("is-invalid");
        password_actual.classList.add("is-invalid");
        password_actual.focus();
    } else if (password_nueva.value == "") { //Evaluamos si tiene contenido
        password_actual.classList.remove("is-invalid");
        password_confirmar.classList.remove("is-invalid");
        password_nueva.classList.add("is-invalid");
        password_nueva.focus();
    } else if (password_confirmar.value == "") { //Evaluamos si tiene contenido 
        password_actual.classList.remove("is-invalid");
        password_nueva.classList.remove("is-invalid");
        password_confirmar.classList.add("is-invalid");
        password_confirmar.focus();
    } else {
        const url = base_url + "Perfil/change_password"; // Construimos la base URL
        const frm = document.getElementById("frmChangePassword"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest();  //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                const res = JSON.parse(this.responseText); //convertimos la respuesta 
                if (res == "ok") {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: 'Se a cambiado tu password'
                    })
                    document.getElementById("password").style.display = 'none'; //Ocultar el label del usuario a actualizar
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }
}

$('#database').change(function () { //Creamos la funcion OnCgange para el select y mostrar la informacion de el proyecto a editar

    switch ($(this).val()) { //Evaluamos que valor trae el select
        case "users_control_usuarios": //Proceso en caso de ser Usuarios
            document.getElementById("tab_control_usuarios").style.display = 'block'; //Ocultar el label del usuario a actualizar
            document.getElementById("tab_control_plantas_fijas").style.display = 'none'; //Ocultar el label del usuario a actualizar
            break;

        case "users_control_plantas_fijas": //Proceso en caso de ser Veiculos
            document.getElementById("tab_control_plantas_fijas").style.display = 'block'; //Ocultar el label del usuario a actualizar
            document.getElementById("tab_control_usuarios").style.display = 'none'; //Ocultar el label del usuario a actualizar
            break;

        default:
            break;
    }
});

//**********************************************************************************************//
//*****************************/ Usuario_control_usuarios **************************************//

let tblAdmin_Usuarios; //Tabla de Usuarios registrados en la aplicacion de Control de Usuarios
document.addEventListener('DOMContentLoaded', function () {
    tblAdmin_Usuarios = $('#tblAdmin_Usuarios').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Admin/listarUsuarios_Control_usuarios",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'nombre'
            },
            {
                'data': 'num_empleado'
            },
            {
                'data': 'rol'
            },
            {
                'data': 'activo'
            },
            {
                'data': 'acciones'
            }
        ]
    });
});

//----------------Abrir Modal Registrar Nuevo Usuario_control_usuarios-----------------//
function frmAdd_control_usuario() {
    document.getElementById("title_control_usuario").innerHTML = "Control de Usuarios - Nuevo"; //Poner titulo al modal
    document.getElementById("btnAccion_Add_control_usuario").innerHTML = "Registrar"; //Poner titulo al boton
    document.getElementById("frmControl_usuario").reset();
    $('#nuevo_usuario_control_usuarios').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_usuario_control_usuarios").modal("show");
    document.getElementById("id_control_usuario").value = "";
}

//----------------Funcion Registrar Usuario_control_usuarios Nuevo--------------------//
function registrarControl_Usuarios(e) {
    e.preventDefault();
    //Datos generales del Usuario
    const num_empleado = document.getElementById("empleado_c_empleado"); //Tomamos el elemento de la por medio del ID
    const rol_id = document.getElementById("rol_id"); //Tomamos el elemento de la por medio del ID
    document.getElementById("empleado_c_empleado").disabled = false;

    if (num_empleado.value == "" | rol_id.value == "") { //Se evaluan que todos los campos esten llenos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios' //Mensaje de campos obligatorios
        })


    } else {
        const url = base_url + "Admin/registrar_control_usuarios"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmControl_usuario"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente

                console.log(this.responseText); //Imprimir respuesta por consola
                const res = JSON.parse(this.responseText); //Guardar la respuesta en la variable res

                if (res == "si") { //Si el usuario fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Usuario Registrado' //Mensaje de usuario registrado
                    })

                    frm.reset();
                    $("#nuevo_usuario_control_usuarios").modal("hide");
                    tblAdmin_Usuarios.ajax.reload();

                } else if (res == "modificado") { //Evaluamos el al guardar el usuario hubo algun error
                    document.getElementById("empleado_c_empleado").disabled = true;
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Usuario Modificado'
                    })

                    tblAdmin_Usuarios.ajax.reload();

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }

}

//---------------------Funcion Editar Usuario_control_usuarios------------------------//
function btnEditarUser_Control_Usuarios(id) {

    if (id == 1) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No se puede modificar este Usuario"
        })
    } else {

        const url = base_url + "Admin/editar_control_usuarios/" + id; // Construimos la base URL del CONTROLADOR
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente


                const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST
                document.getElementById("id_control_usuario").value = res.id; //Mostramos el label del usuario a actualizar
                document.getElementById("empleado_c_empleado").value = res.num_empleado; //Mostramos el label del usuario a actualizar
                document.getElementById("rol_id").value = res.rol_id; //Mostramos el label del usuario a actualizar
            }
        }

        document.getElementById("title_control_usuario").innerHTML = "Control de Usuarios - Actualizar"; //Poner titulo al modal
        document.getElementById("btnAccion_Add_control_usuario").innerHTML = "Actualizar"; //Poner titulo al boton
        document.getElementById("empleado_c_empleado").disabled = true;
        $('#nuevo_usuario_control_usuarios').modal({ //Evitar cierre del modal por click outsite
            backdrop: 'static',
            keyboard: false
        });
        $("#nuevo_usuario_control_usuarios").modal("show");

    }
}

//---------------------Funcion Eliminar usuario_control_usuarios----------------------//
function btnEliminarUser_Control_Usuarios(id) {
    if (id == 1) { //Evaluacion de Usuario Deleloper
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No puedes eliminar este usuario"
        })
    } else {
        Swal.fire({
            title: `Eliminar Usuario`,
            text: "El usuario no se eliminara de forma permanente, solo cambiara a inactivo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {

                const url = base_url + "Admin/eliminar_control_usuarios/" + id; // Construimos la base URL del CONTROLADOR
                const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
                http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
                http.send(); //Enviamos todo el formulario 
                http.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                        const res = JSON.parse(this.responseText);
                        if (res == "ok") {
                            Swal.fire(
                                'Mensaje!',
                                'Usuario Eliminado Correctamente',
                                'success'
                            )
                            tblAdmin_Usuarios.ajax.reload();
                        } else {
                            Swal.fire(
                                'Mensaje!',
                                res,
                                'error'
                            )
                        }
                    }
                }
            }
        })
    }
}

//---------------------Funcion Reingresar usuario_control_usuarios--------------------//
function btnReingresarUser_Control_Usuarios(id) {
    Swal.fire({
        title: `Reingresar Usuario`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Admin/reingresar_control_usuarios/" + id; // Construimos la base URL del CONTROLADOR
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Mensaje!',
                            'Usuario Reingresado Correctamente',
                            'success'
                        )
                        tblAdmin_Usuarios.ajax.reload();
                    } else {
                        Swal.fire(
                            'Mensaje!',
                            res,
                            'error'
                        )
                    }
                }
            }
        }
    })
}

//----------------------Funcion Cerrar Modal Usuario_control_usuarios------------------------//
function cerrarModalAdd_Control_Usuarios() {
    document.getElementById("frmControl_usuario").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_control_usuario").value = ""; //Igualar id a ""
    document.getElementById("empleado_c_empleado").disabled = false;
}
//*****************************/ Usuario_control_usuarios **************************************//
//**********************************************************************************************//

//**********************************************************************************************//
//*****************************/ Usuario_control_plantas_fijas *********************************//

let tblAdmin_Plantas_Fijas; //Tabla de Usuarios registrados en la aplicacion de Control de Usuarios
document.addEventListener('DOMContentLoaded', function () {
    tblAdmin_Plantas_Fijas = $('#tblAdmin_Plantas_Fijas').DataTable({ //Declaramos el Id de la tabla de Usuarios
        ajax: {
            url: base_url + "Admin/listarUsuarios_Control_plantas_fijas",
            dataSrc: ''
        },
        columns: [
            {
                'data': 'nombre'
            },
            {
                'data': 'num_empleado'
            },
            {
                'data': 'rol'
            },
            {
                'data': 'activo'
            },
            {
                'data': 'acciones'
            }
        ]
    });
});
//----------------Abrir Modal Registrar Nuevo Usuario_control_plantas_fijas-----------------//
function frmAdd_control_plantas_fijas() {
    $("#nuevo_usuario_control_plantas_fijas").modal("show");
    document.getElementById("id_control_plantas_fijas").value = "";
    document.getElementById("title_control_plantas_fijas").innerHTML = "Control de Plantas Fijas - Nuevo"; //Poner titulo al modal
    document.getElementById("btnAccion_Add_control_plantas_fijas").innerHTML = "Registrar"; //Poner titulo al boton
    document.getElementById("frmControl_plantas_fijas").reset();
    $('#nuevo_usuario_control_plantas_fijas').modal({ //Evitar cierre del modal por click outsite
        backdrop: 'static',
        keyboard: false
    });
    $("#nuevo_usuario_control_plantas_fijas").modal("show");
    document.getElementById("id_control_usuario").value = "";
}

//----------------Funcion Registrar Usuario_control_plantas_fijas Nuevo--------------------//
function registrarControl_Plantas_Fijas(e) {
    e.preventDefault();
    //Datos generales del Usuario
    const num_empleado = document.getElementById("empleado_c_plantas_fijas"); //Tomamos el elemento de la por medio del ID
    const rol_id = document.getElementById("rol_id_plantas_fijas"); //Tomamos el elemento de la por medio del ID
    document.getElementById("empleado_c_plantas_fijas").disabled = false;

    if (num_empleado.value == "" | rol_id.value == "") { //Se evaluan que todos los campos esten llenos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios' //Mensaje de campos obligatorios
        })


    } else {
        const url = base_url + "Admin/registrar_control_plantas_fijas"; // Construimos la base URL del CONTROLADOR
        const frm = document.getElementById("frmControl_plantas_fijas"); // Seleccionamos el contenido del formulario
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("POST", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(new FormData(frm)); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                console.log(this.responseText);
                const res = JSON.parse(this.responseText);

                if (res == "si") { //Si el usuario fue guardado correctamente mandamos un swal alert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Usuario Registrado' //Mensaje de usuario registrado
                    })

                    frm.reset();
                    $("#nuevo_usuario_control_plantas_fijas").modal("hide");
                    tblAdmin_Plantas_Fijas.ajax.reload();

                } else if (res == "modificado") { //Evaluamos el al guardar el usuario hubo algun error
                    document.getElementById("empleado_c_plantas_fijas").disabled = true;
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Usuario Modificado'
                    })

                    tblAdmin_Plantas_Fijas.ajax.reload();

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }

}

//---------------------Funcion Editar Usuario_control_usuarios------------------------//
function btnEditarUser_Control_Plantas_Fijas(id) {

    if (id == 1) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No se puede modificar este Usuario"
        })
    } else {

        const url = base_url + "Admin/editar_control_plantas_fijas/" + id; // Construimos la base URL del CONTROLADOR
        const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
        http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
        http.send(); //Enviamos todo el formulario 
        http.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente


                const res = JSON.parse(this.responseText); //Guardamos la respuesta de la peticion POST
                document.getElementById("id_control_plantas_fijas").value = res.id; //Mostramos el label del usuario a actualizar
                document.getElementById("empleado_c_plantas_fijas").value = res.num_empleado; //Mostramos el label del usuario a actualizar
                document.getElementById("rol_id_plantas_fijas").value = res.rol_id; //Mostramos el label del usuario a actualizar
            }
        }

        document.getElementById("title_control_plantas_fijas").innerHTML = "Control de Plantas Fijas - Actualizar"; //Poner titulo al modal
        document.getElementById("btnAccion_Add_control_plantas_fijas").innerHTML = "Actualizar"; //Poner titulo al boton
        document.getElementById("empleado_c_plantas_fijas").disabled = true; //Desabilitamos el campo numero de empleado para qevitar errores de registro
        $('#nuevo_usuario_control_plantas_fijas').modal({ //Evitar cierre del modal por click outsite
            backdrop: 'static',
            keyboard: false
        });
        $("#nuevo_usuario_control_plantas_fijas").modal("show");

    }
}

//---------------------Funcion Eliminar usuario_control_usuarios----------------------//
function btnEliminarUser_Control_Plantas_Fijas(id) {
    if (id == 1) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: "No puedes eliminar este usuario"
        })
    } else {
        Swal.fire({
            title: `Eliminar Usuario`,
            text: "El usuario no se eliminara de forma permanente, solo cambiara a inactivo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {

                const url = base_url + "Admin/eliminar_control_plantas_fijas/" + id; // Construimos la base URL del CONTROLADOR
                const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
                http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
                http.send(); //Enviamos todo el formulario 
                http.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                        const res = JSON.parse(this.responseText);
                        if (res == "ok") {
                            Swal.fire(
                                'Mensaje!',
                                'Usuario Eliminado Correctamente',
                                'success'
                            )
                            tblAdmin_Plantas_Fijas.ajax.reload();
                        } else {
                            Swal.fire(
                                'Mensaje!',
                                res,
                                'error'
                            )
                        }
                    }
                }
            }
        })
    }
}

//---------------------Funcion Reingresar usuario_control_usuarios--------------------//
function btnReingresarUser_Control_Plantas_Fijas(id) {
    Swal.fire({
        title: `Reingresar Usuario`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {

            const url = base_url + "Admin/reingresar_control_plantas_fijas/" + id; // Construimos la base URL del CONTROLADOR
            const http = new XMLHttpRequest(); //Creamos una instancia de HTTPRequest
            http.open("GET", url, true); //Seleccionamos el metodo y mandamos la url
            http.send(); //Enviamos todo el formulario 
            http.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) { //si la peticion se ejecuta correctamente
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire(
                            'Mensaje!',
                            'Usuario Reingresado Correctamente',
                            'success'
                        )
                        tblAdmin_Plantas_Fijas.ajax.reload();
                    } else {
                        Swal.fire(
                            'Mensaje!',
                            res,
                            'error'
                        )
                    }
                }
            }
        }
    })
}
//----------------------Funcion Cerrar Modal Usuario_control_usuarios------------------------//
function cerrarModalAdd_Control_Plantas_fijas() {
    document.getElementById("frmControl_plantas_fijas").reset(); //Resetear Formulario al cerral el modal
    document.getElementById("id_control_plantas_fijas").value = ""; //Igualar id a ""
    document.getElementById("empleado_c_plantas_fijas").disabled = false;
}
//*************************** */ Usuario_control_plantas_fijas *********************************//
//**********************************************************************************************//
//================================================================== APP-ADMIN CONTROLLER============================================================================//
//===================================================================================================================================================================//