<?php
// Array to store products
$inventory = [];

// Function to add a new product
function addProduct(&$inventory, $name, $price, $quantity, $image) {
    $inventory[] = [
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $image
    ];
}

// Function to calculate total inventory value
function calculateTotalValue($inventory) {
    $total = 0;
    foreach ($inventory as $product) {
        $total += $product['price'] * $product['quantity'];
    }
    return $total;
}

// Function to get low stock items
function getLowStockItems($inventory) {
    $lowStock = [];
    foreach ($inventory as $product) {
        if ($product['quantity'] < 5) {
            $lowStock[] = $product;
        }
    }
    return $lowStock;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $image = $_POST['image'];

    addProduct($inventory, $name, $price, $quantity, $image);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>កម្មវិធីគ្រប់គ្រងសារពើភណ្ឌ</title>
    <style>
        body {
            background-color: #1e1e2f;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1, h2, h3 {
            color: #ffcc00;
        }

        form {
            background-color: #2e2e3e;
            padding: 15px;
            border-radius: 8px;
            width: 300px;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 10px 0;
            border: none;
            border-radius: 4px;
            background-color: #444;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .product-card {
            background-color: #3a3a4f;
            border-radius: 8px;
            padding: 10px;
            width: 200px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .low-stock {
            color: #ff6666;
            font-weight: bold;
        }

        .in-stock {
            color: #66ff99;
        }
    </style>
</head>
<body>
    <h1>បញ្ចូលព័ត៌មានទំនិញ</h1>
    <form method="POST">
        ឈ្មោះទំនិញ: <input type="text" name="name" required><br>
        តម្លៃ ($): <input type="number" step="0.01" name="price" required><br>
        ចំនួនក្នុងស្តុក: <input type="number" name="quantity" required><br>
        រូបភាព (URL): <input type="text" name="image" required><br>
        <input type="submit" value="បន្ថែម">
    </form>

    <h2>បញ្ជីទំនិញ</h2>
    <div class="card-container">
        <?php
        foreach ($inventory as $product) {
            $class = ($product['quantity'] < 5) ? "low-stock" : "in-stock";
            echo "
            <div class='product-card'>
                <img src='{$product['image']}' alt='Product Image'>
                <h3 class='{$class}'>{$product['name']}</h3>
                <p>{$product['quantity']} unit(s)</p>
                <p>\${$product['price']}</p>
            </div>";
        }
        ?>
    </div>

    <h3>តម្លៃសរុបនៃសារពើភណ្ឌ: $<?php echo calculateTotalValue($inventory); ?></h3>

    <h3>ទំនិញជិតអស់ស្តុក</h3>
    <ul>
        <?php
        $lowStock = getLowStockItems($inventory);
        foreach ($lowStock as $product) {
            echo "<li>{$product['name']} - {$product['quantity']} unit(s)</li>";
        }
        ?>
    </ul>
</body>
</html>