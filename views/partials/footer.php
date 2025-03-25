<footer>
    <div class="footer-container">
        <div class="footer-columns">
            <!-- Column 1: Logo and Description -->
            <!-- <div class="footer-column"> -->
                <!-- <a href="/StyleVerse/index.php" class="footer-logo">
                    <img src="/StyleVerse/assets/images/favicon.ico" alt="Logo">
                </a> -->
                <!-- <p>Explore our exclusive clothing collection for men and women. Quality and style, all in one place.</p> -->
            <!-- </div> -->

            <!-- Column 2: Quick Links -->
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="/StyleVerse/views/products/view_products.php">Products</a></li>
                    <li><a href="/StyleVerse/views/about.php">About Us</a></li>
                    <li><a href="/StyleVerse/views/contact.php">Contact Us</a></li>
                    <li><a href="/StyleVerse/views/auth/login.php">Login</a></li>
                </ul>
            </div>

            <!-- Column 3: Policies -->
            <div class="footer-column">
                <h3>Policies</h3>
                <ul class="footer-links">
                    <li><a href="/StyleVerse/views/terms.php">Terms of Service</a></li>
                    <li><a href="/StyleVerse/views/privacy_policy.php">Privacy Policy</a></li>
                    <li><a href="/StyleVerse/views/refund_policy.php">Refund Policy</a></li>
                </ul>
            </div>

            <!-- Column 4: Social Media -->
            <div class="footer-column">
                <h3>Follow Us</h3>
                <ul class="social-links">
                    <li><a href="https://www.facebook.com/YourPageName" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="https://www.instagram.com/your_instagram_username" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://twitter.com/your_twitter_username" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Your Website Name. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Chat Icon -->
<div id="chat-icon" onclick="toggleChat()">
    💬
</div>

<!-- Chatbox (Initially Hidden) -->
<div id="chatbox" class="hidden">
    <div id="chat-header">
        💬 Chat with StyleVerse
        <span id="close-chat" onclick="toggleChat()">❌</span>
    </div>
    <div id="chat-messages"></div>
    <input type="text" id="chat-input" placeholder="Type a message...">
    <button onclick="sendMessage()" style="height: 30px; margin: 0 0 0 10px; border-radius: 0 0 10px 0;">Send</button>
</div>

<script>
        // JavaScript for toggling the search box
        document.getElementById('search-btn').addEventListener('click', function () {
            const searchContainer = document.getElementById('search-container');
            if (searchContainer.style.display === 'none' || searchContainer.style.display === '') {
                searchContainer.style.display = 'block'; // Show the search box
            } else {
                searchContainer.style.display = 'none'; // Hide the search box
            }
        });

        function toggleChat() {
            let chatbox = document.getElementById("chatbox");
            chatbox.classList.toggle("hidden");

            // 🧠 If opening chat, load previous chats
            if (!chatbox.classList.contains("hidden")) {
                fetch('/StyleVerse/actions/get_chat_history.php')
                    .then(response => response.json())
                    .then(data => {
                        const chatMessages = document.getElementById("chat-messages");
                        chatMessages.innerHTML = ""; // Clear first

                        data.forEach(chat => {
                            chatMessages.innerHTML += `
                                <div><strong>You:</strong> ${chat.user_message}</div>
                                <div><strong>Bot:</strong> ${chat.bot_reply}</div>
                            `;
                        });

                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    });
            }
        }


        function sendMessage() {
            let input = document.getElementById("chat-input").value;
            let chatMessages = document.getElementById("chat-messages");

            if (input == "") return;

            let userMessage = `<div><strong>You:</strong> ${input}</div>`;
            chatMessages.innerHTML += userMessage;

            fetch('/StyleVerse/actions/chatbot.php', {
                method: 'POST',
                body: JSON.stringify({ message: input }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                chatMessages.innerHTML += `<div><strong>Bot:</strong> ${data.reply}</div>`;
            });

            document.getElementById("chat-input").value = "";
        }

        // Attach event listener to the document
        document.getElementById("chat-input").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });

        function logUserBehavior(userId, productId, actionType) {
            fetch('/StyleVerse/controllers/UserBehaviorController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ user_id: userId, product_id: productId, action_type: actionType })
            })
            .then(response => response.json())
            .then(data => console.log('Behavior logged:', data))
            .catch(error => console.error('Error:', error));
        }
</script>


<style>
    /* Chat Icon */
    #chat-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #ff7043; /* Chat Icon Color */
        color: white;
        width: 50px;
        height: 50px;
        text-align: center;
        line-height: 50px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Chatbox */
    #chatbox {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        /* display: none; */
    }

    /* Chat Header */
    #chat-header {
        background: #ff7043;
        color: white;
        padding: 10px;
        font-size: 16px;
        text-align: center;
        border-radius: 10px 10px 0 0;
        position: relative;
    }

    /* Close Button */
    #close-chat {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    /* Chat Messages */
    #chat-messages {
        height: 200px;
        padding: 10px;
        overflow-y: auto;
        font-size: 14px;
        border-bottom: 1px solid #ddd;
    }

    /* Chat Input */
    #chat-input {
        width: 75%;
        padding: 8px;
        border: none;
        border-top: 1px solid #ddd;
    }

    button {
        /* width: 25%; */
        background: #ff7043;
        color: white;
        border: none;
        cursor: pointer;
    }

    /* Hidden Class */
    .hidden {
        display: none;
    }

</style>


