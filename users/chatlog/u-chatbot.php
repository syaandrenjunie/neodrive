<?php
session_start();
include '../../database/dbconn.php'; // adjust as needed

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_message"])) {
    $user_id = $_SESSION['user_id'] ?? null;
    $userMessage = trim($_POST["user_message"]);
    $botReply = "";

    // Simple rules-based responses
    $greetings = ['hello', 'hi', 'hye', 'hyee', 'hallu'];
    $matched = false;

    foreach ($greetings as $greet) {
        if (stripos($userMessage, $greet) !== false) {
            $botReply = "Hi there! 😊 How can I assist you?";
            $matched = true;
            break;
        }
    }

    if ($matched) {
        // Greeting matched, do nothing more
    } elseif (stripos($userMessage, "pomodoro") !== false || stripos($userMessage, "focus") !== false) {
        $botReply = "Use the Pomodoro timer to stay focused! 🍅 Want help finding it?";
    } elseif (preg_match('/\bthank(s| you)?\b/i', $userMessage)) {
        $botReply = "You're welcome! 💚 I'm always here to help!";

    } elseif (stripos($userMessage, "quote") !== false) {
        $botReply = "Need motivation? Go to the Quotes tab to pin your favorite ones! ✨";
    } elseif (stripos($userMessage, "photocard") !== false) {
        $botReply = "You can collect photocards by completing Pomodoro sessions. 🖼️ Keep it up!";
    } elseif (stripos($userMessage, "task") !== false || stripos($userMessage, "to-do") !== false) {
        $botReply = "Don't forget to manage your to-do list! ✅ Prioritize and mark tasks as completed.";
    } elseif (stripos($userMessage, "mood") !== false || stripos($userMessage, "feeling") !== false) {
        $botReply = "Feeling something? Log your mood and let me cheer you up! 💬";
    } elseif (stripos($userMessage, "how are you") !== false) {
        $botReply = "I'm doing great, thanks for asking! 😊 How about you?";
    } elseif (stripos($userMessage, "bye") !== false || stripos($userMessage, "goodbye") !== false) {
        $botReply = "Goodbye! 👋 Come back soon and keep up the great work!";
    } elseif (stripos($userMessage, "help") !== false || stripos($userMessage, "how to") !== false) {
        $botReply = "Need help? You can ask me about: Pomodoro, Tasks, Quotes, Photocards, or Mood Check-in. 😊";
    } elseif (preg_match('/\bmiss\b\s+(\w+)/i', $userMessage, $matches)) {
        $member = ucfirst(strtolower($matches[1])); // Capitalize first letter of name
        $botReply = "Aww 🥺 you miss {$member}? Same here! Let’s stay motivated and make them proud 💚";
    } elseif (preg_match('/\b(tired|exhausted|drained|fatigued)\b/i', $userMessage)) {
        $botReply = "Sounds like you need a break 🧘‍♀️ Don’t forget to rest. You’re doing your best!";
    } elseif (preg_match('/\b(stress|stressed|overwhelmed|burnt out|burned out)\b/i', $userMessage)) {
        $botReply = "Take a deep breath 🌿 You got this! Try a Pomodoro session to manage stress better 💪";
    } elseif (preg_match('/\b(scared|anxious|nervous|worried)\b/i', $userMessage)) {
        $botReply = "It’s okay to feel scared sometimes. You’re not alone 🤝 Breathe in, breathe out 🌸";
    } elseif (preg_match('/\b(sad|down|upset|depressed|crying|blue)\b/i', $userMessage)) {
        $botReply = "Sending you virtual hugs 💚 Remember: better days are coming. Talk to someone you trust 💌";
    } elseif (preg_match('/\b(happy|joyful|excited|delighted|content|glad)\b/i', $userMessage)) {
        $botReply = "Yay! 😄 I’m so happy you’re feeling that way! Keep shining 💫";
    } elseif (preg_match('/\b(motivated|inspired|determined|driven)\b/i', $userMessage)) {
        $botReply = "Let’s gooo! 💪 Keep up that amazing energy. You’re unstoppable! 🚀";
    } elseif (preg_match('/\b(relaxed|calm|peaceful|chill)\b/i', $userMessage)) {
        $botReply = "That’s lovely to hear 🌸 Stay in the moment and enjoy your peace 🌿";
    } elseif (preg_match('/\b(loved|grateful|blessed|thankful)\b/i', $userMessage)) {
        $botReply = "That’s beautiful 💚 Always cherish these moments and spread the love ✨";
    } elseif (preg_match('/\b(okay|ok|okii|okie|alright|aight|yes|yup|yeah|sure)\b/i', $userMessage)) {
        $ackReplies = [
            "Got it! 😊 Let me know if you need anything else!",
            "Okay dokay! 👍",
            "Alrighty! I’m here if you need help 💬",
            "Yes, boss 😎",
            "Sure thing! ✨"
        ];
        $botReply = $ackReplies[array_rand($ackReplies)];

    } else {
        $botReply = "Hmm... I'm still learning 🧠 Can you try rephrasing that?";
    }


    // Store in DB
    if ($user_id && $userMessage !== '') {
        $stmt = $conn->prepare("INSERT INTO chat_logs (user_id, message, response) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $userMessage, $botReply);
        $stmt->execute();
        $stmt->close();
    }

    echo $botReply;
}
?>