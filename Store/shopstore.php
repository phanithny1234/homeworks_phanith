<?php
// Initialize inventory array
$inventory = [];

// Function to add a new item
function addItem(&$inventory, $name, $price, $quantity) {
    $inventory[] = [
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity
    ];
}

// Function to update stock quantity
function updateStock(&$inventory, $name, $newQuantity) {
    foreach ($inventory as &$item) {
        if ($item['name'] === $name) {
            $item['quantity'] = $newQuantity;
            return;
        }
    }
}

// Function to calculate total value
function calculateTotalValue($inventory) {
    $total = 0;
    foreach ($inventory as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Function to get low stock items
function getLowStockItems($inventory) {
    $lowStock = [];
    foreach ($inventory as $item) {
        if ($item['quantity'] < 5) {
            $lowStock[] = $item;
        }
    }
    return $lowStock;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 0);

    addItem($inventory, $name, $price, $quantity);
}
?>

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>កម្មវិធីគ្រប់គ្រងសារពើភណ្ឌ</title>
    <style>
        body {
            font-family: 'Khmer OS Battambang', sans-serif;
            margin: 40px;
        }
        .low-stock {
            background-color: #ffcccc;
        }
        .normal-stock {
            background-color: #ccffcc;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
        }
        form {
            margin-bottom: 20px;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>បញ្ចូលព័ត៌មានទំនិញ</h2>
<form method="POST">
    ឈ្មោះទំនិញ: <input type="text" name="name" required>
    តម្លៃ: <input type="number" name="price" step="0.01" required>
    ចំនួន: <input type="number" name="quantity" required>
    <button type="submit">បញ្ចូល</button>
</form>

<?php if (!empty($inventory)): ?>
    <h3>បញ្ជីទំនិញ</h3>
    <table>
        <tr>
            <th>ឈ្មោះ</th>
            <th>តម្លៃ</th>
            <th>ចំនួនក្នុងស្តុក</th>
        </tr>
        <?php foreach ($inventory as $item): 
            $class = $item['quantity'] < 5 ? 'low-stock' : 'normal-stock';
        ?>
        <tr class="<?= $class ?>">
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td><?= $item['quantity'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        តម្លៃសរុបនៃទំនិញ: $<?= number_format(calculateTotalValue($inventory), 2) ?>
    </div>
<?php endif; ?>

</body>
</html>
