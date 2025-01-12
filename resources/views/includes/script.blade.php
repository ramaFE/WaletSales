<script src="{{ url('sb/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('sb/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('sb/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Chatbot Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatbotButton = document.querySelector('.chatbot-toggle');
        const chatbotModal = document.querySelector('#chatbot-modal');
        const closeChatbot = document.querySelector('#close-chatbot');
        const chatInput = document.querySelector('#chat-input');
        const sendMessageButton = document.querySelector('#send-message');
        const chatMessages = document.querySelector('#chat-messages');
    
        // Show chatbot modal
        chatbotButton.addEventListener('click', () => {
            chatbotModal.style.display = 'flex';
        });
    
        // Close chatbot modal
        closeChatbot.addEventListener('click', () => {
            chatbotModal.style.display = 'none';
        });
    
        // Send message
        sendMessageButton.addEventListener('click', () => {
            const userInput = chatInput.value.trim();
            if (userInput) {
                appendMessage('User', userInput);
                chatInput.value = '';
    
                // Send message to API
                fetch('/chatbot-api', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ message: userInput }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.reply) {
                            appendMessage('Chatbot', data.reply);
                        }
                    })
                    .catch((error) => {
                        appendMessage('Chatbot', 'Maaf, terjadi kesalahan.');
                    });
            }
        });
    
        // Append messages to chat window
        function appendMessage(sender, message) {
            const messageElement = document.createElement('div');
            messageElement.textContent = `${sender}: ${message}`;
            messageElement.style.marginBottom = '10px';
            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
    
</script>

@vite(['resources/js/app.js'])
