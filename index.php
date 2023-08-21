<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ChatBox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="section">
        <div class="chat-container">
            <div class="chat-box" id="chat-box">
                <?php
                $messages = file_get_contents('http://localhost/server.php');
                $messageArray = json_decode($messages, true);

                foreach ($messageArray as $message) {
                    echo '<div class="message">';
                    echo '<div class="timestamp">';
                    echo '<span class="date">' . htmlspecialchars($message['timestamp']) . '</span>';
                    echo '<span class="time">' . htmlspecialchars($message['time']) . '</span>';
                    echo '</div>';
                    echo '<div class="username"><strong>' . htmlspecialchars($message['username']) . '</strong></div>';
                    echo '<div class="text">' . htmlspecialchars($message['text']) . '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <form method="post" action="server.php">
                <input type="text" name="username" placeholder="Username">
                <input type="text" name="message" placeholder="Type your message...">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
    <script>
        var chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
        var messageInput = document.getElementById("message-input");
        messageInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.querySelector("form").submit();
            }
        });
    </script>
</body>

</html>