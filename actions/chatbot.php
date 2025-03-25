<?php
header('Content-Type: application/json');
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$userMessage = strtolower(trim($data['message'] ?? ''));
$userId = $_SESSION['id'] ?? null;
$reply = "🤖 I'm not sure how to help with that. Please try asking about a product name or keyword.";

// 🔁 Static responses
$staticResponses = [
    "hello" => "👋 Hi there! What are you looking for today?",
    "hi" => "Hey! Need help finding something?",
    "bye" => "Goodbye! Come back soon!",
    "thank you" => "You're welcome! 😊",
    "payment" => "💳 We accept Card payments and Cash on Delivery!",
    "delivery" => "🚚 We deliver within 3–5 days across Sri Lanka.",
    "shipping" => "📦 Shipping is free for orders over LKR 5000!",
    "cod" => "Yes, Cash on Delivery is available for most areas.",
];

// ✅ Keyword match (static)
foreach ($staticResponses as $keyword => $responseText) {
    if (strpos($userMessage, $keyword) !== false) {
        $reply = $responseText;
        saveChat($userMessage, $reply, $userId, $pdo);
        echo json_encode(["reply" => nl2br($reply)]);
        exit;
    }
}

// 🔎 Product search (dynamic)
$productStmt = $pdo->prepare("
    SELECT * , p.name as product_name, p.image_url as p_image_url
    FROM products p
    LEFT JOIN subcategories sc
        ON p.subcategory_id = sc.subcategory_id
    LEFT JOIN categories c
        ON p.category_id = c.category_id
    WHERE 
        LOWER(p.name) LIKE ? 
        OR LOWER(p.tags) LIKE ?
        OR LOWER(c.name) LIKE ?
        OR LOWER(sc.subcategory_name) LIKE ?
        LIMIT 1 ");
$productStmt->execute(["%$userMessage%", "%$userMessage%", "%$userMessage%", "%$userMessage%"]);
$product = $productStmt->fetch();

if ($product) {
    $productId = $product['product_id'];
    $name = $product['product_name'];
    $image = $product['p_image_url'];
    $link = "/StyleVerse/views/products/product_details.php?product_id=$productId";

    // Check inventory
    $invStmt = $pdo->prepare("SELECT size, color, price, quantity FROM inventory WHERE product_id = ?");
    $invStmt->execute([$productId]);
    $inventory = $invStmt->fetchAll();

    if ($inventory) {
        $sizes = array_unique(array_column($inventory, 'size'));
        $colors = array_unique(array_column($inventory, 'color'));
        $price = $inventory[0]['price'];

        $reply = "
            🛍️ *{$name}* is available!

            💸 Price: LKR " . number_format($price, 2) . "
            🎨 Colors: " . implode(', ', $colors) . "
            📏 Sizes: " . implode(', ', $sizes) . "

            <a href='$link' target='_blank'>
                <img src='/StyleVerse/assets/images/products/$image' width='180'><br>
                👉 Click here to view product
            </a>";
    } else {
        $reply = "❌ $name is currently out of stock.";
    }
}

// 💾 Save chat
saveChat($userMessage, $reply, $userId, $pdo);

// ✨ Return JSON
echo json_encode(["reply" => $reply]);

// ✅ Save to chat_logs
function saveChat($userMsg, $botReply, $uid, $pdo) {
    $stmt = $pdo->prepare("INSERT INTO chat_logs (user_message, bot_reply, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$userMsg, $botReply, $uid]);
}