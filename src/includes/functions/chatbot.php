<style>
    #botonChatbot .chat-ico-bounce {
        /* No animación por defecto */
        animation: none;
    }

    #botonChatbot:hover .chat-ico-bounce {
        animation: bounce 1s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }
</style>
<button id="botonChatbot" onclick="abrirChatbot()"
    class="fixed bottom-6 right-6 z-50 bg-gradient-to-br from-blue-600 via-blue-500 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full shadow-2xl p-0 flex items-center justify-center transition-all duration-300 border-4 border-white dark:border-zinc-900"
    style="width:64px; height:64px; box-shadow: 0 8px 32px rgba(37,99,235,0.25);">
    <!-- Icono de chat animado solo al hacer hover -->
    <svg class="w-8 h-8 chat-ico-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.8L3 21l1.8-4A8.96 8.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
</button>

<!-- Mini chat flotante -->
<div id="chatbotContainer"
    class="fixed z-50 bg-white dark:bg-zinc-900 rounded-t-2xl rounded-b-2xl sm:rounded-2xl shadow-2xl border border-blue-400/30 flex flex-col h-[60vh] max-h-[500px] w-full max-w-xs sm:max-w-md md:max-w-lg
    right-0 left-0 mx-auto bottom-0 sm:bottom-24 sm:right-6 sm:left-auto sm:mx-0 hidden"
    style="min-height: 350px;">
    <div class="flex justify-between items-center p-4 pb-2">
        <span class="font-bold text-blue-700 dark:text-blue-300">FlowBot</span>
        <button onclick="cerrarChatbot()" class="text-zinc-400 hover:text-red-500 text-2xl font-bold">&times;</button>
    </div>
    <div id="chatbotMensajes" class="flex-1 overflow-y-auto space-y-2 bg-zinc-50 dark:bg-zinc-800 rounded-lg px-4 py-2">
        <!-- Mensajes del chat aquí -->
    </div>
    <form id="formChatbot" class="flex gap-2 p-4 pt-2">
        <input type="text" id="inputChatbot" autocomplete="off" placeholder="Escribe tu pregunta..."
            class="flex-1 px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-400 transition" required>
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-purple-600 hover:to-blue-600 text-white px-4 py-2 rounded-lg font-bold transition">Enviar</button>
    </form>
</div>
<script>
    function abrirChatbot() {
        document.getElementById('chatbotContainer').classList.remove('hidden');
        document.getElementById('inputChatbot').focus();
    }

    function cerrarChatbot() {
        document.getElementById('chatbotContainer').classList.add('hidden');
    }

    // Chatbot simple usando fetch a tu backend que conecta con OpenAI
    document.getElementById('formChatbot').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('inputChatbot');
        const mensajes = document.getElementById('chatbotMensajes');
        const pregunta = input.value.trim();
        if (!pregunta) return;

        // Mostrar mensaje del usuario
        const userMsg = document.createElement('div');
        userMsg.className = "text-right";
        userMsg.innerHTML = `<span class="inline-block bg-blue-100 dark:bg-blue-800 text-blue-900 dark:text-blue-100 px-3 py-2 rounded-lg mb-1">${pregunta}</span>`;
        mensajes.appendChild(userMsg);
        mensajes.scrollTop = mensajes.scrollHeight;
        input.value = "";

        // Mostrar "escribiendo..."
        const botMsg = document.createElement('div');
        botMsg.className = "text-left";
        botMsg.innerHTML = `<span class="inline-block bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 px-3 py-2 rounded-lg mb-1">FlowBot está escribiendo...</span>`;
        mensajes.appendChild(botMsg);
        mensajes.scrollTop = mensajes.scrollHeight;

        // Llamada a tu backend PHP que conecta con OpenAI
        try {
            const response = await fetch('https://cdmdavidro.es/src/api/client/chatbotApi.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    prompt: pregunta
                })
            });
            const data = await response.json();
            botMsg.innerHTML = `<span class="inline-block bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 px-3 py-2 rounded-lg mb-1">${data.respuesta || 'No se pudo obtener respuesta.'}</span>`;
        } catch (err) {
            botMsg.innerHTML = `<span class="inline-block bg-red-200 text-red-800 px-3 py-2 rounded-lg mb-1">Error al conectar con el chatbot.</span>`;
        }
        mensajes.scrollTop = mensajes.scrollHeight;
    });
</script>
