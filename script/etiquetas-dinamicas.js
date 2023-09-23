$(document).ready(function(){
    $('select.tipo').on('change', function(){
        var demovalue = $(this).val(); 
        $("label.op").hide();
        $("#tipo_"+demovalue).show();
    });

});

const DOM1 = function( ){
    this.id = str => document.getElementById(str);
    this.query = (regla_css_DIRECTOR, one = false) =>
        one === true ? 
            document.querySelector(regla_css_DIRECTOR) :
            document.querySelectorAll(regla_css_DIRECTOR);

    this.create = (str, props = {}) => Object.assign(document.createElement(str), props);

    this.append = (hijos, padre = document.body) => {
        hijos.length ?
            hijos.map(hijo => padre.appendChild(hijo)) :
            padre.appendChild(hijos);
    }

    this.remove = e => e.remove();
}

const D1 = new DOM1();

const btn_agregarD = document.getElementById('agregarD');
btn_agregarD.addEventListener("click", function( ){
           //crear el div que contiene los 2 sub-divs
           const div_principal = D1.create('div');
           //crear el div para el span e input del nombre
           const div_nombre = D1.create('div');
       
           //crear el div para el span e input del apellido
           const div_apellido = D1.create('div');
       
           //crear los span de nombre y apellido
           const span_nombre = D1.create('span', { innerHTML: 'Nombre' } );
           const span_apellido = D1.create('span', { innerHTML: 'Apellido' });
       
           //crear los inputs de nombre y apellido
           const input_nombre = D1.create('input', { type: 'text', name: 'nombres[]', autocomplete: 'off' } );
       
           const input_apellido = D1.create('input', { type: 'text', name: 'apellidos[]', autocomplete: 'off' });
       
           //crear un botoncito de eliminar este div 
           const borrar = D1.create('a', { href: 'javascript:void(0)', innerHTML: 'x', onclick: function( ){ D1.remove(div_principal); } } );
       
           //agregar cada etiqueta a su nodo padre
           D1.append(span_nombre, div_nombre);
           D1.append(input_nombre, div_nombre);
       
           D1.append([span_apellido, input_apellido], div_apellido);
       
           D1.append([div_nombre, div_apellido, borrar], div_principal);
           
           //agregar el div del primer comentario al contenedor con id #container
           D1.append(div_principal, D1.id('div-director') );
});

const DOM2 = function( ){
    this.id = str => document.getElementById(str);
    this.query = (regla_css_ACTOR, one = false) =>
        one === true ? 
            document.querySelector(regla_css_ACTOR) :
            document.querySelectorAll(regla_css_ACTOR);

    this.create = (str, props = {}) => Object.assign(document.createElement(str), props);

    this.append = (hijos, padre = document.body) => {
        hijos.length ?
            hijos.map(hijo => padre.appendChild(hijo)) :
            padre.appendChild(hijos);
    }

    this.remove = e => e.remove();
}

const D2 = new DOM2();

const btn_agregarA = document.getElementById('agregarA');
btn_agregarA.addEventListener("click", function( ){
           //crear el div que contiene los 2 sub-divs
           const div_principal = D2.create('div');
           //crear el div para el span e input del nombre
           const div_nombre = D2.create('div');
       
           //crear el div para el span e input del apellido
           const div_apellido = D2.create('div');
       
           //crear los span de nombre y apellido
           const span_nombre = D2.create('span', { innerHTML: 'Nombre' } );
           const span_apellido = D2.create('span', { innerHTML: 'Apellido' });
       
           //crear los inputs de nombre y apellido
           const input_nombre = D2.create('input', { type: 'text', name: 'nombresA[]', autocomplete: 'off' } );
       
           const input_apellido = D2.create('input', { type: 'text', name: 'apellidosA[]', autocomplete: 'off' });
       
           //crear un botoncito de eliminar este div 
           const borrar = D2.create('a', { href: 'javascript:void(0)', innerHTML: 'x', onclick: function( ){ D2.remove(div_principal); } } );
       
           //agregar cada etiqueta a su nodo padre
           D2.append(span_nombre, div_nombre);
           D2.append(input_nombre, div_nombre);
       
           D2.append([span_apellido, input_apellido], div_apellido);
       
           D2.append([div_nombre, div_apellido, borrar], div_principal);
           
           //agregar el div del primer comentario al contenedor con id #container
           D2.append(div_principal, D2.id('div-actor') );
});

const DOM3 = function( ){
    this.id = str => document.getElementById(str);
    this.query = (regla_css_GENERO, one = false) =>
        one === true ? 
            document.querySelector(regla_css_GENERO) :
            document.querySelectorAll(regla_css_GENERO);

    this.create = (str, props = {}) => Object.assign(document.createElement(str), props);

    this.append = (hijos, padre = document.body) => {
        hijos.length ?
            hijos.map(hijo => padre.appendChild(hijo)) :
            padre.appendChild(hijos);
    }

    this.remove = e => e.remove();
}

const D3 = new DOM3();

const btn_agregarG = document.getElementById('agregarG');
btn_agregarG.addEventListener("click", function( ){
           //crear el div que contiene los 2 sub-divs
           const div_principal = D3.create('div');

           //crear el div para el span e input del nombre
           const div_nombre = D3.create('div'); 

           //crear los span de nombre y apellido
           const span_nombre = D3.create('span', { innerHTML: 'Nombre del Genero' } );

           //crear los inputs de nombre y apellido
           const input_nombre = D3.create('input', { type: 'text', name: 'nombresG[]', autocomplete: 'off' } );
      
           //crear un botoncito de eliminar este div 
           const borrar = D3.create('a', { href: 'javascript:void(0)', innerHTML: 'x', onclick: function( ){ D3.remove(div_principal); } } );
       
           //agregar cada etiqueta a su nodo padre
           D3.append(span_nombre, div_nombre);
           D3.append(input_nombre, div_nombre);

           D3.append([div_nombre, borrar], div_principal);
           
           //agregar el div del primer comentario al contenedor con id #container
           D3.append(div_principal, D3.id('div-genero') );
});
