<?php

include_once('header.php');
?>

<style>
    @media screen and (max-width: 600px) {
        .navbar-top {
    background: #fdfdfd;
    width: 100%;
    height: 44px;
    padding: 0px 18px;
    border-bottom: 2px solid #eee;
    top: 0;
    right: 0;
    left: 0;
    position: fixed;
    z-index: 99;
    }
    html,body{
        overflow-y: hidden;
    }
    .site-brand a h1 {
    font-size: 20px;
    color: #313131;
}
.section-padding {
    padding: 0px!important;
}

</style>

<div class="slider">
    <ul class="slides h-75">
        <li>
            <img src="assets/img/slide1.jpg" alt="">
            <div class="caption slider-content center-align">
                <h2>JACKETS ELEGANT</h2>
                <h4>Lorem ipsum dolor sit amet.</h4>
                <a href="#" class="btn button-default">SHOP NOW</a>
            </div>
        </li>
        <li>
            <img src="assets/img/slide2.jpg" alt="">
            <div class="caption slider-content center-align">
                <h2>NEWS & MODERN</h2>
                <h4>Lorem ipsum dolor sit amet.</h4>
                <a href="#" class="btn button-default">SHOP NOW</a>
            </div>
        </li>
        <li>
            <img src="assets/img/slide3.jpg" alt="">
            <div class="caption slider-content center-align">
                <h2>T-SHIRT CENTER</h2>
                <h4>Lorem ipsum dolor sit amet.</h4>
                <a href="#" class="btn button-default">SHOP NOW</a>
            </div>
        </li>
    </ul>
</div>



<div class="new-best-product-shop section-padding">
    <div class="container">
        <div class="row nomar-bottom">
            <div class="col-lg-4 col-12 mb-3">
                <a href="quizpanel/index.php" style="color:#007bff;">
                    <div class="new-best-product-content">
                        <i class="fa fa-book-open"></i>
                        <div class="product-details">
                            <h5><i class="fa fa-question-circle" style="font-size: 35px;"></i></h5>
                            <h4><b>Quiz Panel</b></h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-12 mb-3">
                <a href="educationpanel/index.php" style="color:#007bff;">
                    <div class="new-best-product-content">
                        <i class="fa fa-book-open"></i>
                        <div class="product-details">
                            <h5><i class="fa fa-book" style="font-size: 35px;"></i></h5>
                            <h4><b>Education Panel</b></h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-12 mb-3">
                <a href="testpanel/index.php" style="color:#007bff;">
                    <div class="new-best-product-content">
                        <i class="fa fa-book-open"></i>
                        <div class="product-details">
                            <h5><i class="fa fa-list-alt" style="font-size: 35px;"></i></h5>
                            <h4><b>Model Test</b></h4>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>


<!--<div class="promo-discount section-padding">
    <div class="container">
        <h3>See product discount up to 80%</h3>
        <p>Lorem ipsum dolor sit amet.</p>
        <a href="#" class="btn button-default">SEE NOW</a>
    </div>
</div>-->
<!--<div class="product-shop section-padding">
    <div class="container">
        <div class="row nomar-bottom">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s4">
                        <a class="active" href="#jackets">
                            <h3>Jackets</h3>
                        </a>
                    </li>
                    <li class="tab col s4">
                        <a href="#t-shirt">
                            <h3>T-shirt</h3>
                        </a>
                    </li>
                    <li class="tab col s4">
                        <a href="#jeans">
                            <h3>Jeans</h3>
                        </a>
                    </li>
                </ul>
                <div class="tabs-content">
                    <div id="jackets">
                        <div class="row">
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jackets_shop_1.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jackets</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jackets_shop_2.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jackets</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jackets_shop_3.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jackets</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jackets_shop_4.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jackets</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn button-default">VIEW MORE</a>
                    </div>
                    <div id="t-shirt">
                        <div class="row">
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/tshirt_shop_1.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">T-shirt</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/tshirt_shop_2.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">T-shirt</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/tshirt_shop_3.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">T-shirt</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/tshirt_shop_4.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">T-shirt</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn button-default">VIEW MORE</a>
                    </div>
                    <div id="jeans">
                        <div class="row">
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jeans_shop_1.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jeans</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jeans_shop_2.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jeans</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jeans_shop_3.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jeans</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="product-content">
                                    <img src="assets/img/jeans_shop_4.png" alt="">
                                    <div class="product-cart">
                                        <ul class="i-pro-top">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-exchange"></i></a></li>
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li>
                                        </ul>
                                        <ul class="i-pro-bottom">
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i><span>ADD TO CART</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-details">
                                        <h5><a href="#">Jeans</a></h5>
                                        <h4><a href="#">$15</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn button-default">VIEW MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<?php

include_once('footer.php');
?>