// Crear el popup personalizado
const popup = document.createElement('div');
popup.id = 'customPopup';
popup.style.display = 'none';
popup.style.position = 'absolute';
popup.style.border = '1px solid #333';
popup.style.backgroundColor = '#fff';
popup.style.zIndex = '1000';
popup.innerHTML = `
    <div>
        <label for="popupTitle">Título:</label>
        <input type="text" id="popupTitle">
    </div>
    <div>
        <label for="popupStart">Inicio:</label>
        <input type="datetime-local" id="popupStart">
    </div>
    <div>
        <label for="popupEnd">Finalización:</label>
        <input type="datetime-local" id="popupEnd">
    </div>
    <button id="saveChanges">Guardar cambios</button>
`;
document.body.appendChild(popup);

// Mostrar el popup personalizado al hacer clic en un bloque
calendar.on('clickSchedule', function(event) {
    const schedule = event.schedule;

    // Llenar el popup con los datos del bloque
    document.getElementById('popupTitle').value = schedule.title;
    document.getElementById('popupStart').value = schedule.start.toISOString().slice(0, 16);
    document.getElementById('popupEnd').value = schedule.end.toISOString().slice(0, 16);

    // Mostrar el popup en la posición del cursor
    popup.style.left = event.clientX + 'px';
    popup.style.top = event.clientY + 'px';
    popup.style.display = 'block';
});

// Guardar los cambios y cerrar el popup
document.getElementById('saveChanges').addEventListener('click', function() {
    // Aquí, recoge los datos del popup y actualiza el bloque en el calendario y en la base de datos
    // ...

    // Cerrar el popup
    popup.style.display = 'none';
});

// Cerrar el popup al hacer clic fuera de él
document.addEventListener('click', function(event) {
    if (event.target.closest('#customPopup') === null && event.target.closest('.tui-full-calendar-time-event') === null) {
        popup.style.display = 'none';
    }
});
