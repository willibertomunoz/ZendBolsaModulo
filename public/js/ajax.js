/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var tiempolim;
function parar() {
    clearTimeout(tiempolim);
    tiempolim = setTimeout(cambiar, 900000); // 5 segundos
}
function cambiar() {
    setTimeout('location="cerrar"', 0);
}
jQuery(function ($) {
    $("#direccion").on('click', function (event) {
        cargar();
        $("#main-content").load("direccion");
    });
    $("#d_personales").on('click', function (event) {
        cargar();
        $("#main-content").load("datospersonales");
    });
    $("#d_academicos").on('click', function (event) {
        cargar();
        $("#main-content").load("datosacademicos");
    });
    $("#r_laborales").on('click', function (event) {
        cargar();
        $("#main-content").load("referenciaslaborales");
    });
    $("#d_complementario").on('click', function (event) {
        cargar();
        $("#main-content").load("datoscomplementarios");
    });

    $("#idiomas").on('click', function (event) {
        cargar();
        $("#main-content").load("idiomas");
    });
    $("#pass").on('click', function (event) {
        cargar();
        $("#main-content").load("password");
    });
    $("#curriculum").on('click', function (event) {
        cargar();
        $("#main-content").load("curriculum");
    });
    $("#vacantes").on('click', function (event) {
//        alert("hola");
        cargar();
        $("#main-content").load("vacantes");
    });
    $("#postulaciones").on('click', function (event) {
        cargar();
        $("#main-content").load("postulaciones");
    });
    $("#popup").on('click', function (event) {
        alert("s");
        cargar();
        $("#main-content").load("popup#openModal");
    });
    function cargar()
    {
        tiempolim = setTimeout(cambiar, 900000);
        $('#main-content').html('<div align="center"><img src="http://img.ffffound.com/static-data/assets/6/77443320c6509d6b500e288695ee953502ecbd6d_m.gif"/></div>');
    }
    
//   $("#paginator").on('click', function (event) {
////        $("#main-content").load("postulaciones");
//    });
});


