// Funcion q revisa la sesión y manda a su página o espera el formulario
document.addEventListener('DOMContentLoaded', async () => {
    const sesion = await API.request('/sesion');

    if (sesion.status === 'ok') {
        irSegunRol(sesion.data.rol);
        return;
    }

    const form = document.getElementById('form-login');
    const alerta = document.getElementById('alerta-login');

    // Funcion q manda usuario y contraseña a la API y redirige por rol
    form.addEventListener('submit', async (evento) => {
        evento.preventDefault();
        alerta.classList.add('d-none');

        const respuesta = await API.request('/login', 'POST', {
            usuario: document.getElementById('usuario').value.trim(),
            password: document.getElementById('password').value
        });

        if (respuesta.status === 'ok') {
            irSegunRol(respuesta.data.rol);
            return;
        }

        alerta.textContent = respuesta.message;
        alerta.classList.remove('d-none');
    });
});

// Funcion que manda al admin a su dashboard y tmb al usuario a su seccion
function irSegunRol(rol) {
    if (rol === 'Administrador') {
        window.location.href = 'admin.html';
    } else {
        window.location.href = 'usuario.html';
    }
}
