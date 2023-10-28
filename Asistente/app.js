const express = require('express');
const OpenAI = require('openai');

const app = express();
const port = 3001;

const openai = new OpenAI({
    apiKey: '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'
});

app.use(express.json());

const studyKeywords = [
    'estudio', 'tarea', 'examen', 'consejo', 'técnica', 'gestión del tiempo', 'apuntes', 
    'concentración', 'memoria', 'distracción', 'pomodoro', 'repaso', 'método de estudio', 
    'planificación', 'organización', 'descanso', 'motivación', 'estrés', 'ansiedad', 
    'rendimiento', 'eficiencia', 'lectura rápida', 'notas', 'materia', 'pregunta', 
    'respuesta', 'duda', 'clarificación', 'concepto', 'idea', 'ejemplo', 'práctica',
];



// Inicializar la cola de mensajes con el mensaje del sistema
const messageQueue = [{
    role: "system",
    content: `
    Eres Max, un asistente virtual especializado en métodos de estudio y técnicas de aprendizaje. Tu propósito principal es guiar a los estudiantes en su camino académico en la Universidad Gerardo Barrios. Tienes la misión de no solo ayudar a aclarar conceptos y proporcionar técnicas de estudio, sino también de asistir en el cálculo y análisis de notas. 

    Estás familiarizado con el sistema de evaluación de la universidad: cada ciclo consta de tres cómputos y cada cómputo incluye dos laboratorios y un examen parcial, siendo el examen parcial equivalente al 40% de la nota total del cómputo. 

    Para ayudar mejor a los estudiantes, necesitas que te proporcionen sus notas siguiendo un formato específico. Esperas recibir los datos en el formato: "lab1: [nota], lab2: [nota], examen: [nota]". Basándote en esta estructura, calcularás la nota final del cómputo y ofrecerás consejos o análisis sobre su situación académica actual.

    No hagas las tareas por los estudiantes, pero guíales y ayuda aclarando dudas. Debes ser extremadamente amable, empático y considerado. Siempre enfatiza la importancia de esforzarse y aprender por uno mismo. Alienta a los estudiantes a reflexionar sobre sus hábitos de estudio y ofrece recomendaciones basadas en las notas que te proporcionen.
    `
}];


app.post('/chat', async (req, res) => {
    try {
        const userMessage = {
            role: "user",
            content: req.body.user_message
        };
        
        // Añadir mensaje del usuario a la cola
        messageQueue.push(userMessage);

        // Comunicación con la API de OpenAI para obtener una respuesta del modelo
        const openaiResponse = await openai.chat.completions.create({
            model: 'gpt-4', // Asumiendo que estás usando GPT-4 aquí
            messages: messageQueue,
            temperature: 0.3,
            max_tokens: 1000,
        });

        const assistantMessage = {
            role: "assistant",
            content: openaiResponse.choices[0].message.content
        };

        // Añadir respuesta del asistente a la cola
        messageQueue.push(assistantMessage);

        // Asegurarse de que solo se mantengan los últimos 10 mensajes
        while (messageQueue.length > 10) {
            messageQueue.shift();
        }

        // Verificar que el mensaje del sistema sigue siendo el primero; si no, añadirlo de nuevo
        if (messageQueue[0].role !== "system") {
            messageQueue.unshift({
                role: "system",
                content: "Eres Max, un asistente virtual especializado en métodos de estudio y técnicas de aprendizaje. Tu propósito principal es guiar a los estudiantes en su camino académico. No hagas las tareas por ellos, pero ayuda aclarando conceptos o dando ideas y técnicas de estudio. Debes ser extremadamente amable, empático y considerado. Siempre enfatiza la importancia de esforzarse y aprender por uno mismo."
            });
        }

        res.status(200).json({ message: assistantMessage.content });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Hubo un error al procesar tu solicitud' });
    }
});

app.listen(port, () => {
    console.log(`Norris Assistant Server is running at http://localhost:${port}`);
});