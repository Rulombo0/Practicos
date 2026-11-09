// Funcion que maneja el registro de nuevos usuarios
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-registro');
    const alerta = document.getElementById('alerta-registro');

    // Funcion q manda los datos a la API y muestra si se creó la cuenta
    form.addEventListener('submit', async (evento) => {
        evento.preventDefault();
        alerta.classList.add('d-none');
        alerta.classList.remove('alert-danger', 'alert-success');

        const respuesta = await API.request('/registro', 'POST', {
            nombre: document.getElementById('nombre').value.trim(),
            usuario: document.getElementById('usuario').value.trim(),
            password: document.getElementById('password').value
        });

        if (respuesta.status === 'ok') {
            alerta.classList.add('alert-success');
            form.reset();
        } else {
            alerta.classList.add('alert-danger');
        }

        alerta.textContent = respuesta.message;
        alerta.classList.remove('d-none');
    });
});
