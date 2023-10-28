@extends('layouts.appweb')

@section('content')


    <!-- Estilos de Tui Calendar y Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
    <link rel="stylesheet" href="css/tooltip.css">
    <!-- Contenedor para el calendario -->
    <div id="calendar" style="width: 100%; height: 100%;"></div>

    <!-- Modal para crear un nuevo bloque -->
    <div class="modal fade" tabindex="-1" id="scheduleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Bloque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="/bloques" method="post">
                        @csrf
                        <!-- Campo Título -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
    
                        <!-- Campo Tipo -->
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="" selected disabled hidden>Seleccione...</option>
                                <option value="Clase">Clase</option>
                                <option value="Trabajo">Trabajo</option>
                                <option value="Sueño">Sueño</option>
                                <option value="Comida">Comida</option>
                            </select>
                        </div>
    
                        <!-- Campo Materia (visible solo si Tipo es 'Clase') -->
                        <div class="mb-3" id="materiaGroup" style="display: none;">
                            <label for="materia" class="form-label">Materia</label>
                            <input type="text" class="form-control" id="materia" name="materia">
                        </div>
    
                        <!-- Campo Docente (visible solo si Tipo es 'Clase') -->
                        <div class="mb-3" id="docenteGroup" style="display: none;">
                            <label for="docente" class="form-label">Docente</label>
                            <input type="text" class="form-control" id="docente" name="docente">
                        </div>
    
                        <!-- Campos de hora de inicio y fin -->
                        <div class="mb-3">
                            <label for="inicio" class="form-label">Hora de inicio</label>
                            <input type="datetime-local" class="form-control" id="inicio" name="inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="fin" class="form-label">Hora de fin</label>
                            <input type="datetime-local" class="form-control" id="fin" name="fin" required>
                        </div>
    
                        <!-- Campo Descripción -->

    
                        <!-- Campo Notas -->
                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas</label>
                            <textarea class="form-control" id="notas" name="notas" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color del Bloque</label>
                            <input type="color" class="form-control" id="color" name="color" required>
                        </div>
    
                        <!-- Campo Repetible -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="repetible" id="repetible" value="1">
                            <label class="form-check-label" for="repetible">Repetible a lo largo de las semanas</label>
                        </div>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Bloque</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar un bloque existente -->
    <div class="modal fade" id="editBlockModal" tabindex="-1" aria-labelledby="editBlockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBlockModalLabel">Editar Bloque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/update-bloque/" method="POST" id="editForm">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="blockId" id="blockId">

    <div class="modal-body">
        <!-- Descripción -->
        <div class="mb-3">
            <label for="editTitulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="editTitulo" name="titulo" readonly>
        </div>

        <!-- Notas -->
        <div class="mb-3">
            <label for="editNotas" class="form-label">Notas</label>
            <textarea class="form-control" id="editNotas" name="notas" rows="3" readonly></textarea>
        </div>

        <!-- Hora de Inicio -->
        <div class="mb-3">
            <label for="editInicio" class="form-label">Hora de Inicio</label>
            <input type="datetime-local" class="form-control" id="editInicio" name="inicio" readonly>
        </div>

        <!-- Hora de Fin -->
        <div class="mb-3">
            <label for="editFin" class="form-label">Hora de Fin</label>
            <input type="datetime-local" class="form-control" id="editFin" name="fin" readonly>
        </div>

        <!-- Color del Bloque -->
        <div class="mb-3">
            <label for="editColor" class="form-label">Color del Bloque</label>
            <input type="color" class="form-control" id="editColor" name="color" readonly>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        
        <!-- Botón Modificar -->
        <button type="button" class="btn btn-warning" id="modifyBlockBtn">Modificar</button>

        <!-- Estos dos botones estarán ocultos inicialmente -->
        <button type="submit" class="btn btn-primary" id="saveChangesBtn" style="display:none;">Guardar Cambios</button>
        <button type="button" class="btn btn-danger" id="deleteBlockBtn" style="display:none;" data-id="">Eliminar</button>
    </div>
</form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <script>
    document.getElementById('modifyBlockBtn').addEventListener('click', function() {
        // Habilita los campos para edición
        document.querySelectorAll('#editForm .form-control').forEach(el => el.removeAttribute('readonly'));

        // Muestra los botones "Guardar Cambios" y "Eliminar"
        document.getElementById('saveChangesBtn').style.display = 'block';
        document.getElementById('deleteBlockBtn').style.display = 'block';

        // Esconde el botón "Modificar"
        this.style.display = 'none';
    });
</script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOMContentLoaded: Inicializando...");
        
            function toLocalISOString(date) {
                let tzoffset = date.getTimezoneOffset() * 60000; // offset in milliseconds
                let localISOTime = new Date(date - tzoffset).toISOString().slice(0, -1);
                return localISOTime;
            }
        
            // Inicializar TUI Calendar
            const calendar = new tui.Calendar(document.getElementById('calendar'), {
                defaultView: 'week',
                taskView: false,
                scheduleView: true,
                useCreationPopup: false,
                useDetailPopup: false,
                draggable: true,
                timezone: 'America/El_Salvador',
                hourHeight: 70, // puedes ajustar este valor

            });
            console.log("TUI Calendar inicializado.");
        
            // Función para mostrar/ocultar campos adicionales en función de la selección del usuario
            const tipoSelect = document.getElementById('tipo');
            const materiaGroup = document.getElementById('materiaGroup');
            const docenteGroup = document.getElementById('docenteGroup');
            const descripcionGroup = document.getElementById('descripcionGroup');
            const notasGroup = document.getElementById('notasGroup');
            const recordatorioGroup = document.getElementById('recordatorioGroup');
            const repetirGroup = document.getElementById('repetirGroup');
            const otrosGroup = document.getElementById('otrosGroup');
        
            tipoSelect.addEventListener('change', function() {
                console.log("Cambio detectado en el select 'tipo'. Valor seleccionado:", this.value);
        
                switch (this.value) {
                    case 'Clase':
                        materiaGroup.style.display = 'block';
                        docenteGroup.style.display = 'block';
                        descripcionGroup.style.display = 'block';
                        notasGroup.style.display = 'block';
                        recordatorioGroup.style.display = 'block';
                        repetirGroup.style.display = 'none'; // Las clases siempre se repiten
                        otrosGroup.style.display = 'none';
                        break;
                    case 'Trabajo':
                        materiaGroup.style.display = 'none';
                        docenteGroup.style.display = 'none';
                        descripcionGroup.style.display = 'block';
                        notasGroup.style.display = 'block';
                        recordatorioGroup.style.display = 'block';
                        repetirGroup.style.display = 'none'; // El trabajo siempre se repite
                        otrosGroup.style.display = 'none';
                        break;
                    case 'Sueño':
                        materiaGroup.style.display = 'none';
                        docenteGroup.style.display = 'none';
                        descripcionGroup.style.display = 'block';
                        notasGroup.style.display = 'block';
                        recordatorioGroup.style.display = 'none'; // No se necesita recordatorio para dormir
                        repetirGroup.style.display = 'none'; // El sueño siempre se repite
                        otrosGroup.style.display = 'none';
                        break;
                    case 'Otros':
                        materiaGroup.style.display = 'none';
                        docenteGroup.style.display = 'none';
                        descripcionGroup.style.display = 'block';
                        notasGroup.style.display = 'block';
                        recordatorioGroup.style.display = 'block';
                        repetirGroup.style.display = 'block';
                        otrosGroup.style.display = 'block';
                        break;
                    default:
                        materiaGroup.style.display = 'none';
                        docenteGroup.style.display = 'none';
                        descripcionGroup.style.display = 'none';
                        notasGroup.style.display = 'none';
                        recordatorioGroup.style.display = 'none';
                        repetirGroup.style.display = 'none';
                        otrosGroup.style.display = 'none';
                }
            });
        
            // Escuchar el evento beforeCreateSchedule para mostrar el modal personalizado
            calendar.on('beforeCreateSchedule', function(event) {
                console.log("Evento beforeCreateSchedule disparado.");
                const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
                modal.show();
            });
        
            // Lógica para guardar el bloque cuando se envía el formulario del modal
            document.getElementById('modalForm').addEventListener('submit', function(e) {
                // Aquí puedes agregar la lógica para verificar que los bloques no se superpongan
                // Cerrar el modal y limpiar el formulario
                const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleModal'));
                modal.hide();
            });
        
            // Cargar bloques existentes desde la base de datos y mostrarlos en el calendario
            fetch('/get-bloques')
            .then(response => response.json())
            .then(bloques => {
                console.log("Bloques cargados desde la base de datos:", bloques);
                calendar.createSchedules(bloques);
            });
        
            // Escuchar el evento clickSchedule para mostrar el modal de edición
            calendar.on('clickSchedule', function(event) {
                console.log("Evento clickSchedule disparado. Bloque seleccionado:", event.schedule);
                
                const schedule = event.schedule;
    
                console.log(event.schedule.body);
                // Llenar los campos del formulario con los datos del bloque
                document.getElementById('blockId').value = schedule.id;
                document.getElementById('editTitulo').value = schedule.title; 
                document.getElementById('editNotas').value = schedule.body;                
                document.getElementById('editInicio').value = toLocalISOString(schedule.start._date);
                document.getElementById('editFin').value = toLocalISOString(schedule.end._date);
                document.getElementById('editColor').value = schedule.bgColor;
        
                // Establecer la acción del formulario con el ID del bloque
                document.getElementById('editForm').action = "/update-bloque/" + schedule.id;
        
                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('editBlockModal'));
                modal.show();
            });
        
            // Lógica para actualizar el bloque al arrastrarlo
            calendar.on('beforeUpdateSchedule', function(event) {
                console.log("Evento beforeUpdateSchedule disparado. Cambios detectados:", event.changes);
                        
                const updatedSchedule = event.schedule;
                const changes = event.changes;
        
                // Crear y enviar un formulario en lugar de hacer una solicitud AJAX
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/update-bloque/' + updatedSchedule.id;
        
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);
        
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
        
                const inicioInput = document.createElement('input');
                inicioInput.type = 'hidden';
                inicioInput.name = 'inicio';
                inicioInput.value = changes.start ? toLocalISOString(changes.start._date) : toLocalISOString(updatedSchedule.start._date);
                form.appendChild(inicioInput);
        
                const finInput = document.createElement('input');
                finInput.type = 'hidden';
                finInput.name = 'fin';
                finInput.value = changes.end ? toLocalISOString(changes.end._date) : toLocalISOString(updatedSchedule.end._date);
                form.appendChild(finInput);
        
                document.body.appendChild(form);
                form.submit();
            });

            document.getElementById('deleteBlockBtn').addEventListener('click', function() {
                const blockId = document.getElementById('blockId').value; // <-- Obtener el ID del bloque desde el atributo data-id
            
                if (confirm('¿Estás seguro de que deseas eliminar este bloque?')) {
                    // Crear y enviar un formulario para eliminar el bloque
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/delete-bloque/' + blockId;
            
                    // Agregar el token CSRF
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfInput);
            
                    // Agregar el método de solicitud DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
            
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            
        });
        
    </script>
@endsection
