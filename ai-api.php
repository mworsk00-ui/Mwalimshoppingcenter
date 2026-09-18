<?php
header('Content-Type: application/json');
require_once __DIR__ . '/config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$question = strtolower(trim($input['question'] ?? ''));

if ($question === '') {
    echo json_encode(['reply' => 'Tafadhali andika swali lako.']);
    exit;
}

// ===== JIBU KWA KUTUMIA DATABASE =====

// 1. Sales leo
if (preg_match('/today.*sales|sales.*today|mauzo.*leo|leo.*mauzo/', $question)) {
    $v = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales WHERE DATE(created_at)=CURDATE()")->fetchColumn();
    echo json_encode(['reply' => "**Mauzo ya leo:**\nTSH " . number_format($v, 0)]);
    exit;
}

// 2. Sales jumla
if (preg_match('/total sales|all sales|sales all time|mauzo yote/', $question)) {
    $v = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn();
    echo json_encode(['reply' => "**Mauzo yote (jumla):**\nTSH " . number_format($v, 0)]);
    exit;
}

// 3. Expenses
if (preg_match('/expense|matumizi/', $question)) {
    $v = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses")->fetchColumn();
    echo json_encode(['reply' => "**Matumizi yote:**\nTSH " . number_format($v, 0)]);
    exit;
}

// 4. Profit/Loss
if (preg_match('/profit|faida|loss|hasara/', $question)) {
    $s = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn();
    $e = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses")->fetchColumn();
    $p = $s - $e;
    $label = $p >= 0 ? 'Faida' : 'Hasara';
    echo json_encode(['reply' => "**$label:**\nTSH " . number_format(abs($p), 0) . "\n\nMauzo: TSH " . number_format($s, 0) . "\nMatumizi: TSH " . number_format($e, 0)]);
    exit;
}

// 5. Products
if (preg_match('/product|bidhaa/', $question)) {
    $count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $rows = $pdo->query("SELECT product_name, stock_qty, price FROM products LIMIT 10")->fetchAll();
    $reply = "**Bidhaa zote:** $count\n\n";
    foreach ($rows as $r) {
        $reply .= "• " . $r['product_name'] . " — " . $r['stock_qty'] . " units @ TSH " . number_format($r['price'], 0) . "\n";
    }
    echo json_encode(['reply' => $reply]);
    exit;
}

// 6. Low stock
if (preg_match('/low stock|stock ndogo|bidhaa zinaisha/', $question)) {
    $rows = $pdo->query("SELECT product_name, stock_qty FROM products WHERE stock_qty <= 5 ORDER BY stock_qty ASC")->fetchAll();
    if (empty($rows)) {
        echo json_encode(['reply' => "Hakuna bidhaa yenye stock ndogo. 👍"]);
    } else {
        $reply = "**Bidhaa zenye stock ndogo:**\n\n";
        foreach ($rows as $r) {
            $reply .= "• " . $r['product_name'] . " — " . $r['stock_qty'] . " units\n";
        }
        echo json_encode(['reply' => $reply]);
    }
    exit;
}

// 7. Customers
if (preg_match('/customer|wateja|mteja/', $question)) {
    $count = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
    $due = $pdo->query("SELECT COALESCE(SUM(due_amount),0) FROM customers")->fetchColumn();
    echo json_encode(['reply' => "**Wateja:** $count\n**Madeni yao:** TSH " . number_format($due, 0)]);
    exit;
}

// 8. Dues / madeni
if (preg_match('/due|deni|madeni/', $question)) {
    $rows = $pdo->query("SELECT customer_name, due_amount FROM customers WHERE due_amount > 0 ORDER BY due_amount DESC LIMIT 10")->fetchAll();
    if (empty($rows)) {
        echo json_encode(['reply' => "Hakuna madeni kwa sasa. 👍"]);
    } else {
        $total = $pdo->query("SELECT COALESCE(SUM(due_amount),0) FROM customers WHERE due_amount > 0")->fetchColumn();
        $reply = "**Madeni yote:** TSH " . number_format($total, 0) . "\n\n";
        foreach ($rows as $r) {
            $reply .= "• " . $r['customer_name'] . " — TSH " . number_format($r['due_amount'], 0) . "\n";
        }
        echo json_encode(['reply' => $reply]);
    }
    exit;
}

// 9. Transactions today
if (preg_match('/transaction|muamala|miamala|how many.*today/', $question)) {
    $c = $pdo->query("SELECT COUNT(*) FROM sales WHERE DATE(created_at)=CURDATE()")->fetchColumn();
    echo json_encode(['reply' => "**Miamala ya leo:** $c"]);
    exit;
}

// 10. Available balance
if (preg_match('/balance|salio|available/', $question)) {
    $s = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM sales")->fetchColumn();
    $e = $pdo->query("SELECT COALESCE(SUM(amount),0) FROM expenses")->fetchColumn();
    $b = $s - $e;
    echo json_encode(['reply' => "**Salio linalopatikana:**\nTSH " . number_format($b, 0)]);
    exit;
}

// 11. What is Mwalimushoppingcenter
if (preg_match('/what is mwalimushoppingcenter|ni nini mwalim/', $question)) {
    echo json_encode(['reply' => "**Mwalimushoppingcenter** ni mfumo wa kusimamia biashara yako kwa urahisi:\n\n• Kusimamia bidhaa na stock\n• Kufuatilia mauzo na manunuzi\n• Kusimamia wateja na madeni\n• Kufuatilia matumizi na faida\n• Kutoa ripoti mbalimbali"]);
    exit;
}

// 12. Help / what can I do
if (preg_match('/help|nisaidie|what can i do|nifanye nini/', $question)) {
    echo json_encode(['reply' => "**Naweza kukusaidia kwa:**\n\n• \"Mauzo ya leo ni ngapi?\"\n• \"Nina bidhaa ngapi?\"\n• \"Bidhaa zenye stock ndogo?\"\n• \"Madeni yote?\"\n• \"Faida yangu?\"\n• \"Wateja wangapi?\"\n\nUliza swali lolote!"]);
    exit;
}

// Default
echo json_encode(['reply' => "Samahani, sijaelewa swali lako. Jaribu kuuliza:\n\n• \"Mauzo ya leo?\"\n• \"Bidhaa zote?\"\n• \"Madeni yote?\"\n• \"Faida yangu?\""]);
