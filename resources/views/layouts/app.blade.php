<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Walets')</title>
    
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @include('includes.style')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('includes.navbar')
                @yield('content')

            </div>
            <!-- End of Main Content -->

            @include('includes.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>                
            </div>
        </div>
    </div>
    
    <!-- Floating Chatbot Button -->
    <div id="chatbot-button">
        <button class="chatbot-toggle">
            <i class="fa-solid fa-robot"></i>
        </button>
    </div>

    <!-- Chatbot Modal -->
    <div id="chatbot-modal" class="chatbot-modal">
        <div class="chatbot-header">
            <h5>Chatbot</h5>
            <button id="close-chatbot" class="close-btn">&times;</button>
        </div>
        <div class="chatbot-body">
            <div id="chat-messages" class="chat-messages"></div>
            <input type="text" id="chat-input" placeholder="Ketik perintah..." />
            <button id="send-message" class="btn-send">Kirim</button>
        </div>
    </div>
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
                const userInput = chatInput.value.trim(); // Ambil input pengguna
                if (userInput) {
                    appendMessage('User', userInput); // Tambahkan pesan ke UI
                    chatInput.value = ''; // Kosongkan input setelah dikirim
        
                    // Kirim pesan ke API
                    fetch('/chatbot-api', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ message: userInput }), // Sesuaikan key di sini
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.reply) {
                            appendMessage('Chatbot', data.reply); // Tambahkan balasan ke UI
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        appendMessage('Chatbot', 'Maaf, terjadi kesalahan pada server.');
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
    @include('includes.script')
</body>

</html>