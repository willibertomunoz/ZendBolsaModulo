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
}
function cambiar() {
    setTimeout('location="cerrar"', 0);
}
jQuery(function ($) {
    $("#perfil").on('click', function (event) {
        history.pushState(null, 'Perifl', 'perfil');
        cargar();
        $("#main-content").load("perfil");
    });
    $("#vacantes").on('click', function (event) {
        history.pushState(null, 'Vacantes', 'vacantes');
        cargar();
        $("#main-content").load("vacantes");
    });
    $("#postulados").on('click', function (event) {
        history.pushState(null, 'Postulados', 'postulados');
        cargar();
        $("#main-content").load("postulados");
    });
    $("#aspirantes").on('click', function (event) {
        history.pushState(null, 'Aspirantes', 'aspirantes');
        cargar();
        $("#main-content").load("aspirantes");
    });
    function cargar()
    {
        tiempolim = setTimeout(cambiar, 900000);
        //$('#main-content').html('<div align="center"><img src="http://img.ffffound.com/static-data/assets/6/77443320c6509d6b500e288695ee953502ecbd6d_m.gif"/></div>');
    }

//   $("#paginator").on('click', function (event) {history.pushState(null, 'Empresa  Pendiente', 'empresapendiente');
////        $("#main-content").load("postulaciones");
//    });
});


