@extends('layouts.appweb')
@section('content')
    <style>
        .message p, .message ul {
            margin: 0 0 10px 0;
        }
        .assistant-message ul {
            padding-left: 20px;
            margin: 0;
        }
        .assistant-message p {
            margin: 0 0 10px 0;
        }
        .message li {
            margin: 5px 0;
        }

        #chat-box {
            background-color: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 15px;
            box-shadow: 0 0 10px #e6e6e6;
            height: 460px;
            overflow-y: scroll;
            padding: 15px;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            width: fit-content;
        }
        .user-message {
            background-color: #e6e6e6;
            align-self: flex-start;
            order: 1;
        }
        .assistant-message {
            background-color: #d1ecf1;
            align-self: flex-end;
            order: 2;
            margin-left: auto;
        }
        .loading-spinner {
            text-align: right;
            display: none;
        }
        .input-group {
            border-radius: 15px;
            overflow: hidden;
        }
        .input-group input, .input-group button {
            border-radius: 0;
        }
        .input-group button {
            background-color: #007bff;
            color: #fff;
        }
        .quick-actions button {
            margin: 0 5px 5px 0;
        }
    </style>

<div class="container mt-5">
    <div id="chat-box">
        <div class="message assistant-message">
            Hola, estoy aquí para ayudarte a entender y aprender, no para hacer tus tareas por ti. Usa esta herramienta de manera responsable. ¡Vamos a aprender juntos!
        </div>
    </div>
    <div id="loading-spinner" class="loading-spinner mb-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
    <div id="user-input" class="mb-3">
        <div class="input-group">
            <input type="text" id="message" class="form-control" placeholder="Escribe tu mensaje aquí..." />
            <div class="input-group-append">
                <button class="btn" onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>
</div>


<script>

    document.getElementById('message').addEventListener('keydown', function(event) {
        if (event.key === 'Enter' || event.keyCode === 13) {
            event.preventDefault();  // Prevenir el comportamiento por defecto de la tecla Enter
            sendMessage();          // Llamar a la función para enviar el mensaje
        }
    });
// Función para extraer las notas del mensaje del usuario
function extractGrades(message) {
    const labPattern = /(lab[12])\s*[:=]?\s*(\d+)/gi;
    const examPattern = /(examen|parcial|actividad)\s*[:=]?\s*(\d+)/gi;

    let grades = {
        lab1: null,
        lab2: null,
        examen: null
    };

    let match;
    while (match = labPattern.exec(message)) {
        const labNumber = match[1].toLowerCase();
        const grade = parseFloat(match[2]);
        if (labNumber === 'lab1') grades.lab1 = grade;
        if (labNumber === 'lab2') grades.lab2 = grade;
    }

    match = examPattern.exec(message);
    if (match) grades.examen = parseFloat(match[2]);

    return grades;
}

function calculateFeedback(computoGrade) {
    if (computoGrade >= 9.0) {
        return "¡Excelente trabajo! Estás demostrando un alto nivel de compromiso y comprensión en tus estudios.";
    } else if (computoGrade >= 8.0) {
        return "Estás haciendo un buen trabajo. Continúa con este esfuerzo y lograrás excelentes resultados.";
    } else if (computoGrade >= 7.0) {
        return "Has logrado una buena nota, pero hay margen de mejora. Revisa los temas en los que te sientes menos cómodo.";
    } else if (computoGrade >= 6.0) {
        return "Estás en el límite. Es esencial que revises tus métodos de estudio y busques apoyo si es necesario.";
    } else {
        return "Estás en riesgo de reprobar este cómputo. Es fundamental que busques ayuda, aclares tus dudas y refuerces tus áreas de debilidad.";
    }
}

function sendMessage() {
    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('message');

    const userMessage = messageInput.value.trim();
    if (userMessage === '') return;

    // Añadir el mensaje del usuario al chat
    chatBox.innerHTML += `<div class="message user-message">Usuario: ${userMessage}</div>`;
    messageInput.value = '';

    // Extraer las notas del mensaje del usuario
    const grades = extractGrades(userMessage);

    // Verificar si las notas se extrajeron correctamente
    if (grades.lab1 !== null && grades.lab2 !== null && grades.examen !== null) {
        // Calcular la nota del cómputo
        const averageLabs = (grades.lab1 + grades.lab2) / 2;
        const computoGrade = averageLabs * 0.6 + grades.examen * 0.4;

        let response = `Tu nota del cómputo es: ${computoGrade.toFixed(2)}. `;
        response += calculateFeedback(computoGrade);
        
        chatBox.innerHTML += `<div class="message assistant-message">Asistente: ${response}</div>`;
    } else {
        // Lógica existente para procesar otros mensajes 
        const loadingMessageDiv = document.createElement('div');
        loadingMessageDiv.className = 'message assistant-message';
        loadingMessageDiv.innerHTML = '<div class="p-3 text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div></div>';
        chatBox.appendChild(loadingMessageDiv);

        // Hacer la solicitud AJAX al servidor
        fetch('/Asistente/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ user_message: userMessage }),
        })
        .then(response => {
            if (!response.ok) throw new Error('Hubo un error al comunicarse con el servidor');
            return response.json();
        })
        .then(data => {
            // Estructurar el mensaje del asistente con HTML
            let assistantMessage = '';
            const listRegex = /\d+\.\s.+/g;
            const messageParts = data.message.split('\n');
            let isList = false;
            
            messageParts.forEach(part => {
                if (listRegex.test(part)) {
                    if (!isList) {
                        isList = true;
                        assistantMessage += '<ul>';
                    }
                    assistantMessage += `<li>${part.replace(listRegex, match => match.slice(2))}</li>`;
                } else {
                    if (isList) {
                        isList = false;
                        assistantMessage += '</ul>';
                    }
                    assistantMessage += `<p>${part}</p>`;
                }
            });
            if (isList) assistantMessage += '</ul>';
            
            // Actualizar el mensaje de "Cargando..." con la respuesta del asistente
            loadingMessageDiv.innerHTML = `Asistente: ${assistantMessage}`;
        })
        .catch(error => {
            console.error(error);
            loadingMessageDiv.innerHTML = 'Asistente: Hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.';
        });
    }

    // Hacer scroll al último mensaje en el chat
    chatBox.scrollTop = chatBox.scrollHeight;
}

function sendQuickAction(message) {
    document.getElementById('message').value = message;
    sendMessage();
}
</script>

@endsection

@section('scripts')

@endsection
