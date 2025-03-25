<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include necessary files
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');// Database configuration
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/ProductController.php');  // IncludeProductController
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/controllers/CategoryController.php');  // Include CategoryController

// Check if the admin is logged in (optional)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: /StyleVerse/views/auth/login.php'); // Redirect to admin login page
    exit();
}

// Initialize variables
$productId = $name = $description = $price = $imageUrl = $categoryId = '';
$errors = [];
$updateMode = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $categoryId = intval($_POST['category_id']);
    $subcategoryId = intval($_POST['subcategory_id']);
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $tags = isset($_POST['tags']) ? $_POST['tags'] : []; // Get tags as an array

    $tagsString = implode(',', $tags);

    // Validate form data
    if (empty($name)) {
        $errors[] = "Product name is required.";
    }
    if (empty($description)) {
        $errors[] = "Product description is required.";
    }
    if ($price <= 0) {
        $errors[] = "Product price must be greater than 0.";
    }
    if (empty($subcategoryId)) {
        $errors[] = "Sub Category is required.";
    }
    if (empty($categoryId)) {
        $errors[] = "Category is required.";
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/assets/images/products/';
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' .$extension;
        // $imageName = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imageUrl = $imageName;
        } else {
            $errors[] = "Failed to upload image.";
        }
    } elseif ($productId === null) { // Image is required for new products
        $errors[] = "Product image is required.";
    }

    $additionalImages = [];

    if (!empty($_FILES['additional_images']['name'][0])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/assets/images/products/';

        foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['additional_images']['error'][$key] === UPLOAD_ERR_OK) {
                $extension = pathinfo($_FILES['additional_images']['name'][$key], PATHINFO_EXTENSION);
                $adimageName = uniqid() . '.' . $extension;
                $targetFile = $targetDir . $adimageName;

                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $additionalImages[] = $adimageName;
                }
            }
        }
    }

    // Convert additional images array to JSON for storage
    $additionalImagesJson = json_encode($additionalImages);

    // If no errors, save product
    if (empty($errors)) {
        $productController = new ProductController($pdo);

        if ($productId) { // Update existing product
            $updateMode = true;
            $result = $productController->updateProduct($productId, $name, $description, $price, $imageName, $categoryId, $subcategoryId, $additionalImagesJson, $tags);
            if ($result) {
                $_SESSION['success'] = "Product updated successfully.";
            } else {
                $errors[] = "Failed to update product.";
            }
        } else { // Add new product
            $result = $productController->addProduct($name, $description, $price, $categoryId, $subcategoryId, $imageName, $additionalImagesJson, $tags);
            if ($result) {
                $_SESSION['success'] = "Product added successfully.";
            } else {
                $errors[] = "Failed to add product.";
            }
        }

        if (empty($errors)) {
            header('Location: /StyleVerse/views/products/view_products.php'); // Redirect to product list
            exit();
        }
    }
}

// Fetch product details if updating
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $productController = new ProductController($pdo);
    $product = $productController->getProductById($productId);

    if ($product) {
        $name = $product['product_name'];
        $description = $product['description'];
        $price = $product['price'];
        $imageUrl = $product['image_url'];
        $categoryId = $product['category_id'];
        $subcategoryId = $product['subcategory_id'];
        $updateMode = true;
        $additionalImages = json_decode($product['additionalImages'], true);
        $existingTags = $product['tags'];
    } else {
        $_SESSION['error'] = "Product not found.";
        header('Location: /admin/manage_products.php');
        exit();
    }
}

// Fetch categories for the dropdown
$categoryController = new CategoryController($pdo);
$categories = $categoryController->getAllCategories();
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/header.php'; ?> <!-- Include the header -->
<link rel="stylesheet" href="/StyleVerse/assets/css/add_product.css"> <!-- Update the path to your CSS -->

    <div class="add-container">
        <h1><?= $updateMode ? 'Update Product' : 'Add Product' ?></h1>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">

            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" required><?= htmlspecialchars($description) ?></textarea>

            <label for="tags">Product Tags:</label>
            <select id="tags" name="tags[]" multiple="multiple" class="select2-tags">
                <?php if (!empty($existingTags)): // If editing, pre-fill existing tags ?>
                    <?php foreach (explode(',', $existingTags) as $tag): ?>
                        <option value="<?= htmlspecialchars(trim($tag)) ?>" selected><?= htmlspecialchars(trim($tag)) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="<?= htmlspecialchars($price) ?>" required>

            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required onchange="getCategoryId(this.value)">
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>" <?= $categoryId == $category['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="form-group">
                <label for="subcategory">Sub Category</label>
                <select name="subcategory_id" id="subcategory_id" required>
                    <option value="">Select Sub Category</option>
                </select>
                <input type="hidden" id="hidden_subcategory_id" value="<?= $product['subcategory_id']?>">
            </div>
            <label for="image">Image</label>
            <input type="file" name="image" id="image" <?= $updateMode ? '' : 'required' ?>>

            <?php if ($updateMode && $imageUrl): ?>
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="/StyleVerse/assets/images/products/<?= htmlspecialchars($imageUrl) ?>" alt="Product Image">
                </div>
            <?php endif; ?>

            <label for="additional_images">Additional Images</label>
            <input type="file" name="additional_images[]" id="additional_images" multiple accept="image/*">

            <div class="additional-images-container" id="preview-container">
                <?php
                    if (!empty($additionalImages)) {
                        foreach ($additionalImages as $image) {
                            echo "<img class='additional-image' src='/StyleVerse/assets/images/products/$image' alt='Additional Image'>";
                        }
                    }
                ?>
            </div>
            <button type="submit"><?= $updateMode ? 'Update' : 'Add' ?> Product</button>
        </form>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'].'/StyleVerse/views/partials/footer.php'; ?> <!-- Include the footer -->


    <script>
    // JavaScript to populate the edit form
    setSubCategory();
    function populateEditForm(product) {
        document.querySelector('form [name="action"]').value = 'edit';
        document.querySelector('#product_id').value = product.product_id;
        document.querySelector('#name').value = product.product_name;
        document.querySelector('#description').value = product.description;
        document.querySelector('#price').value = product.price;
        document.querySelector('#subcategory').value = product.subcategory_id;
    }

    function getCategoryId(categoryId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/StyleVerse/actions/fetch_subcategory.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let subcategories = JSON.parse(xhr.responseText); // Handle the PHP response
                //alert(xhr.responseText);
                document.getElementById('subcategory_id').innerHTML='';
                let option = document.createElement('option');
                option.value = '';
                option.innerText = 'Select Sub Category';
                document.getElementById('subcategory_id').appendChild(option);

                subcategories.forEach(subcategory => {
                    let option = document.createElement('option');
                    option.value = subcategory.subcategory_id;
                    option.innerText = subcategory.subcategory_name;
                    document.getElementById('subcategory_id').appendChild(option);
                });

            }
        };

        // Send the selected value to the server
        xhr.send("action=getSubCategoriesByCategory&categoryId=" + encodeURIComponent(categoryId));
    }

    function setSubCategory() {
        let category = document.getElementById('category_id').value;

        if(category) {
            getCategoryId(category);
            setTimeout(() => {
                            document.getElementById('subcategory_id').value = document.getElementById('hidden_subcategory_id').value
            }, 200);
        }
    }

    $(document).ready(function() {
        $(".select2-tags").select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: "Enter tags...",
            allowClear: true
        });
    });

</script>