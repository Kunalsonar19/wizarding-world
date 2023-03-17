<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
};

if (isset($_POST['add_to_wishlist'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'already added to wishlist!';
   } elseif ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }
}

if (isset($_POST['add_to_cart'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wizarding World: The Official Home of Harry Potter</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="https://aux.iconspalace.com/uploads/2142641057408204296.png" type="image/x-icon">
   <style>
      /* Center the preloader */
      #preloader {
         position: fixed;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: #ffffff;
         /* change the color as needed */
         z-index: 9999;
      }

      /* Add animation to the spinner */
      #spinner {
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         width: 300px;
         /* set the width as needed */
         height: auto;
         /* maintain aspect ratio */

      }
   </style>

</head>

<body>

   <div id="preloader">
      <div id="spinner"></div>
   </div>
   <?php include 'header.php'; ?>
   <div class="home-bg">

      <section class="home">

         <div class="content">
            <span><img src="https://www.wizardingworld.com/_next/image?url=%2Fimages%2Fpages%2Fhome%2Flogo.png&w=576&q=75" alt=""></span>
            <!-- <h3>Get More Information About : Wizarding World</h3> -->
            <h3>Explore the wizarding world Experience the magic</h3>
            <p>Exciting new projects from the great minds of Pottermore and Warner Bros.</p>
            <a href="about.php" class="btn-new">About us</a>
         </div>

      </section>

   </div>
   <div class="fan-club">
      <p class="head">HARRY POTTER FAN CLUB</p>
      <h1>Exclusive Harry Potter shop voucher on your <br> birthday</h1>
      <p class="info" style="text-align: center;">
         Sign up to our emails to get a special birthday discount to spend on the Harry Potter shop. Exclusions apply
      </p>
      <a href="shop.php" class="btn-new">Shop Now</a>
      <br><br>
   </div>
   <section class="home-category">

      <h1 class="title">Trending Products</h1>

      <div class="box-container">

         <div class="box">
            <img src="https://cdn.shopify.com/s/files/1/0514/6332/3817/files/Wand_static_card_large.jpg?v=1649173708" alt="">
            <h3>Wand Shop</h3>
            <!-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p> -->
            <a href="category.php?category=Wand" class="btn">Buy Now</a>
         </div>

         <div class="box">
            <img src="https://cdn.shopify.com/s/files/1/0514/6332/3817/files/Trunk_card_large.gif?v=1646994755" alt="">
            <h3>Trunk Station</h3>
            <!-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p> -->
            <a href="category.php?category=Trunk Station" class="btn">Buy Now</a>
         </div>

         <div class="box">
            <img src="https://cdn.shopify.com/s/files/1/0514/6332/3817/files/Robe_card_large.gif?v=1646928736" alt="">
            <h3>Clothing</h3>
            <!-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p> -->
            <a href="category.php?category=Clothing" class="btn">Buy Now</a>
         </div>

         <div class="box">
            <img src="https://cdn.shopify.com/s/files/1/0514/6332/3817/files/Sweets_static_card_large.jpg?v=1649173724" alt="">
            <h3>Sweet Trolly</h3>
            <!-- <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p> -->
            <a href="category.php?category=Sweet Trolly" class="btn">Buy Now</a>
         </div>

      </div>

   </section>
   <div class="fan-club middle">
      <p class="head">HARRY POTTER FAN CLUB</p>
      <h1>Harry Potter Collection</h1>
      <p class="info" style="text-align: center;">
         Explore a selection of best-selling Harry Potter merchandise, including exclusive collectibles, bespoke wands, souvenirs, delicious confectionery, fan-favourites and more, perfect for gifting any witch or wizard to add to their collection.
      </p>
      <a href="shop.php" class="btn-new">Shop Now</a>
      <br><br>
   </div>
   <section class="products">

      <h1 class="title">latest products</h1>

      <div class="box-container">

         <?php
         $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY `id` ASC LIMIT 3");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <form action="" class="box" method="POST">
                  <div class="price">₹<span><?= $fetch_products['price']; ?></span>/-</div>
                  <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                  <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                  <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                  <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                  <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                  <input type="number" min="1" value="1" name="p_qty" class="qty">
                  <input type="submit" value="Add to Wishlist" class="option-btn" name="add_to_wishlist">
                  <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">No products added yet!</p>';
         }
         ?>


      </div>

   </section>


   <div class="blogs">
      <h1 class="title">Magical Blogs</h1>
      <div class="fan-club first-blog">
         <p class="head">HARRY POTTER FAN CLUB</p>
         <h1>Hogwarts Legacy shares its final trailer before launch </h1>
         <p class="info">
            By The Wizarding World Teams
         </p>
         <a href="#" class="btn-new">Read More</a>
         <br><br>
      </div>
      <div class="fan-club first-blog second-blog">
         <p class="head">HARRY POTTER FAN CLUB</p>
         <h1>Exclusive Take a closer look at the Hogwarts Legacy</h1>
         <p class="info">
            By The Wizarding World Team
         </p>
         <a href="#" class="btn-new">Read More</a>
         <br><br>
      </div>
   </div>
   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>
   <script src="lottie.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.9/lottie.min.js"></script>
   <script>
      window.addEventListener("load", function() {
         var preloader = document.getElementById("preloader");
         var animation = bodymovin.loadAnimation({
            container: document.getElementById('spinner'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets1.lottiefiles.com/packages/lf20_b1eyyihe.json',
            /* change the filename as needed */
            rendererSettings: {
               preserveAspectRatio: 'xMidYMid slice'
            },
            // Set the width of the animation container
            // (use the same value as the CSS style above)
            // The height will be calculated automatically
            containerParams: {
               width: 100
            }
         });
         setTimeout(function() {
            preloader.style.display = 'none';
         }, 3000); /* set the delay in milliseconds */
      });
   </script>
</body>

</html>