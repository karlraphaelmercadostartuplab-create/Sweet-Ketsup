<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';
include 'components/add_cart.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Welcome to SweetKetSoup</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>


<div class="home-bg">

<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>Crocheted Handicrafts</span>
               <h3>Bouquets</h3>
               <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="image">
               <img src="images/s1.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>Crocheted Handicrafts</span>
               <h3>Keychains</h3>
               <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="image">
               <img src="images/s2.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>Crocheted Handicrafts</span>
               <h3>Funko Pops</h3>
               <a href="shop.php" class="btn">Shop Now</a>
            </div>
            <div class="image">
               <img src="images/s3.png" alt="">
            </div>
         </div>
</div>

   
<div class="swiper-pagination"></div>

</div>

</section>

</div>
<br><br>
<section class="category">

   <h1 class="title">Crocheted Handicrafts Category</h1>
   <p style="text-align:center;font-size: 20px; color:#98667b;">You're guaranteed a handcrafted item made with 
    love and attention to detail.</p>
    <br><br><br>
   <div class="box-container">

      <a href="category.php?category=Bouquets" class="box">
         <img src="images/bouquets.svg" alt="">
         <h3>Bouquets</h3>
      </a>

      <a href="category.php?category=Keychains" class="box">
         <img src="images/key.png" alt="">
         <h3>Keychains</h3>
      </a>

      <a href="category.php?category=Funko Pops" class="box">
         <img src="images/funko.png" alt="">
         <h3>Funko Pops</h3>
      </a>

   </div>

</section>



<section class="products">

   <h1 class="title">Featured Crocheted Handicrafts</h1>
      <p style="text-align:center;font-size: 20px; color:#98667b;">These limited-edition crochet 
         creations are expertly crafted to stand out</h3><br><br>
   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>&#8369</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="btn">View All</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>