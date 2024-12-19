//Ejecutar función en el evento click
document.getElementById("btn_open").addEventListener("click", open_close_menu);

//Declaramos variables
var side_menu = document.getElementById("menu_side");
var btn_open = document.getElementById("btn_open");
var body = document.getElementById("body");
var navLinks = document.getElementById('nav-links'); // Asegúrate de tener el ID correcto

//Evento para mostrar y ocultar menú
function open_close_menu(){
    body.classList.toggle("body_move");
    side_menu.classList.toggle("menu__side_move");
    navLinks.classList.toggle('d-block'); // Agregar esta línea para alternar el menú de navegación
}

//Si el ancho de la página es menor a 760px, ocultará el menú al recargar la página
if (window.innerWidth < 760){
    body.classList.add("body_move");
    side_menu.classList.add("menu__side_move");
}

// Haciendo el menú responsive(adaptable)
window.addEventListener("resize", function(){
    if (window.innerWidth > 760){
        body.classList.remove("body_move");
        side_menu.classList.remove("menu__side_move");
        navLinks.classList.remove('d-block'); // Asegúrate de ocultar el menú de navegación en pantallas grandes
    }

    if (window.innerWidth < 760){
        body.classList.add("body_move");
        side_menu.classList.add("menu__side_move");
    }
});

// Cerrar el menú al hacer clic fuera de él
document.addEventListener('click', (event) => {
    if (!navLinks.contains(event.target) && !btn_open.contains(event.target)) {
        navLinks.classList.remove('d-block'); // Oculta el menú
        body.classList.remove("body_move"); // Permite el desplazamiento
        side_menu.classList.remove("menu__side_move"); // Oculta el menú lateral si es necesario
    }
});
