$(document).ready(function(){
    //admin eliminacion de contenido
    const quiero_elim = document.getElementById('quiero-elim');
    const pop = document.getElementById('overlay-elim-peli');
    const cancelX = document.getElementById('pop-elim-peli');
    const cancelBoton = document.getElementById('boton-cancelo-elim');

    quiero_elim.addEventListener("click", function( ){
        pop.classList.add('show');
    });

    cancelX.addEventListener("click", function( ){
        pop.classList.remove('show');
    });

    cancelBoton.addEventListener("click", function( ){
        pop.classList.remove('show');
    });   
});




$(document).ready(function(){
    //nombre de usuario ocupado
    const pop_usuario = document.getElementById('overlay-usuario-repe');
    const cancelX_usuario = document.getElementById('pop-usuario-repe');
    const cancelBoton_usuario = document.getElementById('boton-usuario-repe');

    cancelX_usuario.addEventListener("click", function( ){
        pop_usuario.classList.remove('show');
    });

    cancelBoton_usuario.addEventListener("click", function( ){
        pop_usuario.classList.remove('show');
    });

});

$(document).ready(function(){
    //mail ya registrado
    const pop_mail = document.getElementById('overlay-mail-repe');
    const cancelX_mail = document.getElementById('pop-mail-repe');
    const cancelBoton_mail = document.getElementById('boton-mail-repe');

    cancelX_mail.addEventListener("click", function( ){
        pop_mail.classList.remove('show');
    });

    cancelBoton_mail.addEventListener("click", function( ){
        pop_mail.classList.remove('show');
    });

});

$(document).ready(function(){
    //pregunta registrar mail
    const pop_mail_nuevo = document.getElementById('overlay-mail-nuevo');
    const cancelX_mail_nuevo = document.getElementById('pop-mail-nuevo');
    const cancelBoton_mail_nuevo = document.getElementById('boton-mail-nuevo');

    cancelX_mail_nuevo.addEventListener("click", function( ){
        pop_mail_nuevo.classList.remove('show');
    });

    cancelBoton_mail_nuevo.addEventListener("click", function( ){
        pop_mail_nuevo.classList.remove('show');
    });

});

$(document).ready(function(){
    //logeuo incorrecto
    const pop_incorrecto = document.getElementById('overlay-incorrecto');
    const cancelX_incorrecto = document.getElementById('pop-incorrecto');
    const cancelBoton_incorrecto = document.getElementById('boton-incorrecto');

    cancelX_incorrecto.addEventListener("click", function( ){
        pop_incorrecto.classList.remove('show');
    });

    cancelBoton_incorrecto.addEventListener("click", function( ){
        pop_incorrecto.classList.remove('show');
    });

});

$(document).ready(function(){
    //edit de perfil
    const quiero_edit = document.getElementById('click-edit');
    const repe_repe = document.getElementById('boton-mail-repe');
    const pop_edit = document.getElementById('overlay-edit-perfil');

    quiero_edit.addEventListener("click", function( ){
        pop_edit.classList.add('show');
    });

    repe_repe.addEventListener("click", function( ){
        pop_edit.classList.add('show');
    });
});


$(document).ready(function(){
    //edit de perfil
    const pop_edit = document.getElementById('overlay-edit-perfil');
    const cancelX_edit = document.getElementById('pop-cerrar-edit');
    const cancelBoton_edit = document.getElementById('boton-cancelo-edit-perfil');

    cancelX_edit.addEventListener("click", function( ){
        pop_edit.classList.remove('show');
    }); 

    cancelBoton_edit.addEventListener("click", function( ){
        pop_edit.classList.remove('show');
    });   
});

