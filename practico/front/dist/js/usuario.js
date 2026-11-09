// Funcion que chekea la sesión y muestra el nombre de usuario si estás logueao
document.addEventListener('DOMContentLoaded', async () => {
    const sesion = await API.request('/sesion');

    if (sesion.status !== 'ok') {
        window.location.href = 'login.html';
        return;
    }

    document.getElementById('nombre-usuario').textContent = sesion.data.nombre;

    // Cierra la sesión y vuelve al login
    document.getElementById('btn-logout').addEventListener('click', async () => {
        await API.request('/logout', 'POST');
        window.location.href = 'login.html';
    });
});
