<?php
// Array to hold inventory items (stored in session for demo purposes)
session_start();
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [];
}
$inventory = &$_SESSION['inventory'];

// Function to add a new item
function addItem(&$inventory, $name, $price, $quantity) {
    foreach ($inventory as &$item) {
        if ($item['name'] === $name) {
            // If item exists, update quantity
            $item['quantity'] += $quantity;
            return;
        }
    }
    // If new item
    $inventory[] = [
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ];
}

// Function to update quantity
function updateStock(&$inventory, $name, $newQty) {
    foreach ($inventory as &$item) {
        if ($item['name'] === $name) {
            $item['quantity'] = $newQty;
            return;
        }
    }
}

// Function to calculate total stock value
function calculateTotalValue($inventory) {
    $total = 0;
    foreach ($inventory as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Function to get low stock items (<5)
function getLowStockItems($inventory) {
    $low = [];
    foreach ($inventory as $item) {
        if ($item['quantity'] < 5) {
            $low[] = $item;
        }
    }
    return $low;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);

    if ($name && $price > 0 && $quantity >= 0) {
        addItem($inventory, $name, $price, $quantity);
    }
}
?>

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>កម្មវិធីគ្រប់គ្រងសារពើភណ្ឌទំនិញ</title>
    <style>
        body {
            font-family: "Khmer OS Battambang", Arial, sans-serif;
            margin: 40px;
        }
        form {
            margin-bottom: 20px;
        }
        input, button {
            padding: 5px;
            margin-right: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
        }
        .low-stock {
            background-color: #ffdddd;
        }
        .normal-stock {
            background-color: #ddffdd;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>បញ្ចូលព័ត៌មានទំនិញថ្មី</h2>
<form method="POST">
    <label>ឈ្មោះទំនិញ:</label>
    <input type="text" name="name" required>
    <label>តម្លៃ ($):</label>
    <input type="number" step="0.01" name="price" required>
    <label>ចំនួន:</label>
    <input type="number" name="quantity" required>
    <button type="submit">បន្ថែម</button>
</form>

<h2>តារាងទំនិញ</h2>
<?php if (!empty($inventory)): ?>
<table>
    <tr>
        <th>ឈ្មោះទំនិញ</th>
        <th>តម្លៃ ($)</th>
        <th>ចំនួនក្នុងស្តុក</th>
        <th>តម្លៃសរុប</th>
    </tr>
    <?php foreach ($inventory as $item): 
        $rowClass = $item['quantity'] < 5 ? 'low-stock' : 'normal-stock';
        $itemTotal = $item['price'] * $item['quantity'];
    ?>
    <tr class="<?= $rowClass ?>">
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= number_format($item['price'], 2) ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= number_format($itemTotal, 2) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="total">
    ✅ តម្លៃសរុបនៃទំនិញទាំងអស់: <strong>$<?= number_format(calculateTotalValue($inventory), 2) ?></strong>
</div>
<?php else: ?>
<p>មិនទាន់មានទំនិញណាមួយនៅក្នុងសារពើភណ្ឌទេ។</p>
<?php endif; ?>

</body>
</html>
