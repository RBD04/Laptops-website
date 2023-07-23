<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);
}

function renderCartItems($cartProducts) {
    if (gettype($cartProducts) == 'string') {
        echo '<li><span class="dropdown-item-text">' . $cartProducts . '</span></li>';
    } else {
        $totalPrice = 0;
        echo '<li><h3 class="dropdown-item-text text-primary" style="border-bottom: 1px solid #ccc;">Your Cart</h3></li>';
        foreach ($cartProducts as $cartProduct) {
            $price = $cartProduct->price;
            $quantity = $cartProduct->quantityAvailable;
            $total = $price * $quantity;
            $totalPrice += $total;
            echo '
            <form method="post">
            <input type="hidden" name="cartProductId" value='.$cartProduct->productId.' />
            <input type="hidden" name="cartQuantity" value='.$cartProduct->quantityAvailable.' />
            <li class="dropdown-item" style="border-bottom: 1px solid #ccc; position: relative;">
                <div class="d-flex">
                    <img src="' . $cartProduct->thumbnail . '" class="mr-3" alt="Item Image" style="width: 50px; height: 50px; border-radius: 50%;">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 mr-auto text-primary">' . $cartProduct->productName . '</h6>
                        </div>
                        <p class="text-muted">Price: $' . $price . '</p>
                    </div>
                    <button class="btn btn-sm btn-danger m-2" style="position: absolute; bottom: 0; right: 0;" name="removeProduct">Remove</button>
                </div>
            </li>
            </form>';
        }
        
        echo '<li class="dropdown-item text-left text-primary" style="border-bottom: 1px solid #ccc;">
                  <h4>Total Price: ' . $totalPrice . '$</h4>
              </li>
              <li class="dropdown-item m-2" style="display: flex; flex-direction: column;">
                  <a href="checkout.php" class="btn btn-primary mb-2 text-white">CHECKOUT NOW</a>
                  <a href="cart.php" class="btn btn-outline-primary">VIEW OR EDIT CART</a>
              </li>';
    }
}
?>
