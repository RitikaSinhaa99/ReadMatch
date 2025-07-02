<script>
document.addEventListener("DOMContentLoaded", function() {
    const cartCount = document.getElementById("cart-count");

    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function() {
            const bookId = this.getAttribute("data-book-id");

            // AJAX Request to update cart
            fetch("update_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ book_id: bookId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cartCount.textContent = data.cart_count; // Update cart count in the menu
                } else {
                    alert("Failed to add to cart. Please try again.");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the book ID is provided
if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    
    // Add the book ID to the session cart array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Avoid adding duplicate books
    if (!in_array($book_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $book_id;
    }
    
    // Redirect to the cart page
    header("Location: cart.php");
    exit();
}
?>
