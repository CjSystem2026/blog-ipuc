<!-- Floating Support Counseling Chat Widget -->
<div id="support-chat-widget" class="fixed bottom-6 right-6 z-50 font-sans">
    <!-- Floating Bubble Button -->
    <button id="support-chat-toggle" class="bg-amber-900 hover:bg-amber-850 text-white rounded-full p-4 shadow-xl flex items-center justify-center gap-2 group transition-all duration-300 relative focus:outline-none">
        <span class="text-xl">💬</span>
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-500 ease-out text-xs font-semibold uppercase tracking-wider whitespace-nowrap">
            ¿Necesitas hablar?
        </span>
        <!-- Unread badge indicator -->
        <span id="support-chat-badge" class="absolute top-1 right-1 h-3 w-3 rounded-full bg-red-650 ring-2 ring-white hidden animate-pulse"></span>
    </button>

    <!-- Support Chat Window Drawer -->
    <div id="support-chat-window" class="hidden absolute bottom-20 right-0 w-80 sm:w-96 max-w-[calc(100vw-2rem)] bg-white rounded-3xl border border-stone-200/60 shadow-2xl overflow-hidden flex flex-col transition-all duration-300 transform translate-y-4 opacity-0 z-50">
        <!-- Header -->
        <div class="bg-stone-900 text-white p-5 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🕊️</span>
                <div>
                    <h4 class="text-xs font-semibold tracking-wide">Espacio de Escucha</h4>
                    <p class="text-[9px] text-stone-400">Apoyo espiritual 100% confidencial</p>
                </div>
            </div>
            <button id="support-chat-close" class="text-stone-400 hover:text-white text-lg focus:outline-none">&times;</button>
        </div>

        <!-- Content Area -->
        <div id="support-chat-body" class="h-80 overflow-y-auto p-5 bg-stone-50/50 flex flex-col justify-between">
            <!-- Screen 1: Options Selector (Default) -->
            <div id="support-screen-options" class="space-y-4 my-auto">
                <p class="text-xs text-stone-600 leading-relaxed font-light">
                    Estamos aquí para escucharte y apoyarte. Elige cómo te sientes más cómodo conversando hoy:
                </p>

                <!-- WhatsApp Option -->
                <a href="https://wa.me/573000000000?text=Hola,%20me%20gustaría%20conversar%20con%20un%20pastor%20para%20recibir%20apoyo%20o%20consejo..." target="_blank" class="w-full flex items-center justify-between p-4 bg-emerald-50 hover:bg-emerald-100/60 rounded-2xl border border-emerald-250/10 transition-colors group">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">🟢</span>
                        <div class="text-left">
                            <span class="text-xs font-semibold text-stone-900 block">Conversar por WhatsApp</span>
                            <span class="text-[10px] text-stone-400 font-light">Atención directa y personal.</span>
                        </div>
                    </div>
                    <span class="text-stone-400 group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>

                <!-- Anonymous Option -->
                <button id="btn-support-anonymous" class="w-full flex items-center justify-between p-4 bg-amber-50/30 hover:bg-amber-100/40 rounded-2xl border border-amber-900/5 transition-colors group focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">👤</span>
                        <div class="text-left">
                            <span class="text-xs font-semibold text-stone-900 block">Escribir de forma Anónima</span>
                            <span class="text-[10px] text-stone-400 font-light">Totalmente privado y confidencial.</span>
                        </div>
                    </div>
                    <span class="text-stone-400 group-hover:translate-x-1 transition-transform">&rarr;</span>
                </button>
            </div>

            <!-- Screen 2: Anonymous Message Form -->
            <div id="support-screen-form" class="hidden space-y-4 my-auto w-full">
                <button id="btn-back-to-options" class="text-[9px] font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1 hover:underline focus:outline-none">
                    &larr; Volver
                </button>
                <p class="text-xs text-stone-500 leading-relaxed font-light">
                    Cuéntanos tu situación. Tu mensaje se enviará de forma anónima. Un consejero te responderá aquí mismo en las próximas horas.
                </p>
                <textarea id="support-form-message" rows="4" placeholder="Escribe aquí tu situación o necesidad..." class="w-full px-4 py-3 rounded-2xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-white outline-none text-xs text-stone-850 resize-none"></textarea>
                <button id="btn-submit-support" class="w-full py-3 bg-amber-900 hover:bg-amber-850 text-white rounded-2xl text-xs font-semibold uppercase tracking-wider shadow-md transition-all focus:outline-none">
                    Enviar Mensaje Confidencial
                </button>
            </div>

            <!-- Screen 3: Chat History -->
            <div id="support-screen-chat" class="hidden flex-col h-full justify-between w-full">
                <div class="flex items-center justify-between pb-2 border-b border-stone-200/60 mb-3 shrink-0">
                    <span class="text-[9px] font-bold uppercase tracking-wider text-amber-900 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Consejería Anónima
                    </span>
                    <button id="btn-clear-chat" class="text-[8px] font-semibold text-stone-400 hover:text-red-750 transition-colors uppercase focus:outline-none">Nuevo chat</button>
                </div>
                
                <!-- Messages List -->
                <div id="chat-messages-container" class="flex-1 overflow-y-auto space-y-3 pr-1 py-1 max-h-[190px]">
                    <!-- Injected dynamically -->
                </div>

                <!-- Input Row -->
                <div class="pt-3 border-t border-stone-200/60 flex gap-2 shrink-0 mt-3">
                    <input type="text" id="chat-reply-input" placeholder="Escribe un mensaje..." class="flex-1 px-3 py-2 rounded-xl border border-stone-200 focus:border-amber-800/40 bg-white outline-none text-xs text-stone-850" />
                    <button id="btn-send-reply" class="px-4 py-2 bg-amber-900 hover:bg-amber-850 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center focus:outline-none">Enviar</button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div id="support-chat-footer" class="bg-stone-50 px-5 py-3 border-t border-stone-100 text-[9px] text-stone-400 text-center font-light leading-snug shrink-0">
            Esta conversación se guarda de forma segura únicamente en tu navegador.
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('support-chat-toggle');
    const closeBtn = document.getElementById('support-chat-close');
    const chatWindow = document.getElementById('support-chat-window');
    const badge = document.getElementById('support-chat-badge');

    // Screens
    const screenOptions = document.getElementById('support-screen-options');
    const screenForm = document.getElementById('support-screen-form');
    const screenChat = document.getElementById('support-screen-chat');

    // Navigation / Form Actions
    const btnAnon = document.getElementById('btn-support-anonymous');
    const btnBack = document.getElementById('btn-back-to-options');
    const txtMsg = document.getElementById('support-form-message');
    const btnSubmit = document.getElementById('btn-submit-support');

    // Active Chat Actions
    const messagesContainer = document.getElementById('chat-messages-container');
    const replyInput = document.getElementById('chat-reply-input');
    const btnSendReply = document.getElementById('btn-send-reply');
    const btnClearChat = document.getElementById('btn-clear-chat');

    let chatToken = localStorage.getItem('support_chat_token') || null;
    let localMessagesCount = 0;

    // Toggle Chat Window
    toggleBtn.addEventListener('click', () => {
        const isHidden = chatWindow.classList.contains('hidden');
        if (isHidden) {
            chatWindow.classList.remove('hidden');
            setTimeout(() => {
                chatWindow.classList.remove('translate-y-4', 'opacity-0');
            }, 10);
            badge.classList.add('hidden'); // Clear badge on open
            initWidgetState();
        } else {
            closeWidget();
        }
    });

    closeBtn.addEventListener('click', closeWidget);

    function closeWidget() {
        chatWindow.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => {
            chatWindow.classList.add('hidden');
        }, 300);
    }

    // Navigation flow
    btnAnon.addEventListener('click', () => {
        showScreen('form');
    });

    btnBack.addEventListener('click', () => {
        showScreen('options');
    });

    // Start / Send new anonymous chat
    btnSubmit.addEventListener('click', () => {
        const msgText = txtMsg.value.trim();
        if (!msgText) return;

        btnSubmit.disabled = true;
        btnSubmit.innerText = 'Enviando...';

        fetch('/api/support-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msgText, token: chatToken })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                chatToken = data.token;
                localStorage.setItem('support_chat_token', chatToken);
                txtMsg.value = '';
                renderChat(data.messages);
            }
        })
        .catch(err => console.error(err))
        .finally(() => {
            btnSubmit.disabled = false;
            btnSubmit.innerText = 'Enviar Mensaje Confidencial';
        });
    });

    // Reply to active chat
    btnSendReply.addEventListener('click', sendReplyMessage);
    replyInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendReplyMessage();
    });

    function sendReplyMessage() {
        const replyText = replyInput.value.trim();
        if (!replyText || !chatToken) return;

        replyInput.value = '';

        fetch('/api/support-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: replyText, token: chatToken })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderChat(data.messages);
            }
        })
        .catch(err => console.error(err));
    }

    // Reset Chat Session
    btnClearChat.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que deseas iniciar una nueva conversación? Se perderá el historial anterior.')) {
            localStorage.removeItem('support_chat_token');
            chatToken = null;
            localMessagesCount = 0;
            showScreen('options');
        }
    });

    function showScreen(screen) {
        screenOptions.classList.add('hidden');
        screenForm.classList.add('hidden');
        screenChat.classList.add('hidden');

        if (screen === 'options') screenOptions.classList.remove('hidden');
        if (screen === 'form') screenForm.classList.remove('hidden');
        if (screen === 'chat') screenChat.classList.remove('hidden');
    }

    function initWidgetState() {
        if (chatToken) {
            fetchChatMessages();
        } else {
            showScreen('options');
        }
    }

    function fetchChatMessages() {
        if (!chatToken) return;

        fetch(`/api/support-chat?token=${chatToken}`)
        .then(res => res.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                renderChat(data.messages);
            } else {
                showScreen('options');
            }
        })
        .catch(err => console.error(err));
    }

    function renderChat(messages) {
        showScreen('chat');
        messagesContainer.innerHTML = '';
        
        messages.forEach(msg => {
            const isAdmin = msg.sender === 'admin';
            const msgDiv = document.createElement('div');
            msgDiv.className = `flex ${isAdmin ? 'justify-start' : 'justify-end'} w-full`;
            
            msgDiv.innerHTML = `
                <div class="max-w-[85%] rounded-2xl px-3.5 py-2 text-xs shadow-xs leading-relaxed whitespace-pre-line ${
                    isAdmin 
                        ? 'bg-white text-stone-850 border border-stone-200/50 rounded-tl-none' 
                        : 'bg-amber-900 text-white rounded-tr-none'
                }">
                    <p class="font-light">${escapeHTML(msg.message)}</p>
                    <span class="text-[8px] text-right block mt-1 ${isAdmin ? 'text-stone-400' : 'text-amber-200'}">
                        ${new Date(msg.created_at).toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'})}
                    </span>
                </div>
            `;
            messagesContainer.appendChild(msgDiv);
        });

        // Scroll to bottom
        setTimeout(() => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }, 30);

        localMessagesCount = messages.length;
    }

    function escapeHTML(str) {
        return str.replace(/[&<>'"]/g, 
            tag => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            }[tag] || tag)
        );
    }

    // Background Poll loop to check for replies
    setInterval(() => {
        if (chatToken) {
            fetch(`/api/support-chat?token=${chatToken}`)
            .then(res => res.json())
            .then(data => {
                if (data.messages && data.messages.length > localMessagesCount) {
                    // We got a new message!
                    if (chatWindow.classList.contains('hidden')) {
                        badge.classList.remove('hidden'); // Show red unread dot!
                    } else {
                        renderChat(data.messages);
                    }
                }
            })
            .catch(err => console.error(err));
        }
    }, 15000); // Check every 15 seconds
});
</script>
