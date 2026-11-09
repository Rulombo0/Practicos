// Fuchi kk (saca al usuario del panel de admin)
document.addEventListener('DOMContentLoaded', async () => {
    const sesion = await API.request('/sesion');

    if (sesion.status !== 'ok') {
        window.location.href = 'login.html';
        return;
    }

    if (sesion.data.rol !== 'Administrador') {
        window.location.href = 'usuario.html';
        return;
    }

    document.getElementById('nombre-usuario').textContent = sesion.data.nombre + ' (' + sesion.data.rol + ')';

    // TUTO QUEMA (te devuelve al login)
    document.getElementById('btn-logout').addEventListener('click', async () => {
        await API.request('/logout', 'POST');
        window.location.href = 'login.html';
    });
});
