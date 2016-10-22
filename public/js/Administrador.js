/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var tiempolim;
function parar() {
    tiempolim=0;
    clearTimeout(tiempolim);
    tiempolim = setTimeout(cambiar, 900000); // 5 segundos
    alert(tiempolim);
}
function cambiar() {
    setTimeout('location="cerrar"', 0);
}
jQuery(function ($) {
    $("#e_pendientes").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'empresapendiente');
        cargar();
        $("#main-content").load("empresapendiente");
    });
    $("#e_rechazadas").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'empresarechazada');
        cargar();
        $("#main-content").load("empresarechazada");
    });
    $("#e_activas").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'empresaactivas');
        cargar();
        $("#main-content").load("empresaactivas");
    });
    $("#v_pendientes").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'vacantependiente');
        cargar();
        $("#main-content").load("vacantependiente");
    });
    $("#v_rechazadas").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'vacanterechazada');
        cargar();
        $("#main-content").load("vacanterechazada");
    });
    $("#v_activas").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'vacanteactiva');
        cargar();
        $("#main-content").load("vacanteactiva");
    });
    $("#alumnos").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'alumnos');
        cargar();
        $("#main-content").load("alumnos");
    });

    $("#imagenes").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'imagenes');
        cargar();
        $("#main-content").load("imagenes");
    });
    $("#carrera").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'carrera');
        cargar();
        $("#main-content").load("carrera");
    });
    $("#idiomas").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'idiomas');
        cargar();
        $("#main-content").load("idiomas");
    });
    $("#horario").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'horario');
//        alert("hola");
        cargar();
        $("#main-content").load("horario");
    });
    $("#registrar").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'mostrar');
        cargar();
        $("#main-content").load("mostrar");
    });
    $("#mostrar").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'mostrar');
        cargar();
        $("#main-content").load("mostrar");
    });
    $("#modificar").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'empresapendiente');
        cargar();
        $("#main-content").load("mostrar");
    });
    $("#eliminar").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'empresapendiente');
        cargar();
        $("#main-content").load("mostrar");
    });
    $("#reportes").on('click', function (event) {
        history.pushState(null, 'Empresa  Pendiente', 'reportes');
        cargar();
        $("#main-content").load("reportes");
    });
    function cargar()
    {
        tiempolim = setTimeout(cambiar, 900000);
        $('#main-content').html('<div align="center"><img src="http://img.ffffound.com/static-data/assets/6/77443320c6509d6b500e288695ee953502ecbd6d_m.gif"/></div>');
    }

//   $("#paginator").on('click', function (event) {history.pushState(null, 'Empresa  Pendiente', 'empresapendiente');
////        $("#main-content").load("postulaciones");
//    });
});


