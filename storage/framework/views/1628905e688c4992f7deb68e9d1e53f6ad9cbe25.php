<?php

    use Illuminate\Support\Facades\Route;
    $login = Auth::user();

    $menu = \App\Helpers\BasicHelpers::HeaderMenuNav();
    $menuother = \App\Helpers\BasicHelpers::HeaderMenuNavothers();

?>



<!DOCTYPE html>

<html lang="<?php echo e(config('app.locale')); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

        <link rel="shortcut icon" href="<?php echo e(asset('img/Favicon Logo.png')); ?>">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo $__env->yieldContent('title', 'SellBuyDevice'); ?></title>

        <!-- Meta -->
        <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'SellBuyDevice'); ?>">
        <meta name="author" content="<?php echo $__env->yieldContent('meta_author', 'SellBuyDevice'); ?>">
        <?php echo $__env->yieldContent('meta'); ?>




        <!-- Styles -->



            <?php echo e(Html::style('css/all.css')); ?>

            <?php echo e(Html::style('css/bootstrap.min.css')); ?>


            <?php echo e(Html::style('css/owl.carousel.min.css')); ?>

            <?php echo e(Html::style('css/owl.theme.default.min.css')); ?>

            <?php echo e(Html::style('css/style.css')); ?>

<?php echo e(Html::style('css/developer.css')); ?>

            <?php echo e(Html::style('css/responsive.css')); ?>







        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

    </head>
    <body class="inside-page">

            <div class="outer">
                    <header class="header">
                      <div class="container">
                        <div class="d-flex justify-content-between align-items-center header-inner">
                          <div class="logo">
                              <a href="<?php echo e(asset('/')); ?>">
                              <img src="<?php echo e(asset('storage/settings/' . config('get.MAIN_LOGO'))); ?> " alt="">
                              </a>
                            </div>
                          <div class="top-header-right align-items-center d-flex">
                            <div class="top-search-bar ">

                                    <input name="productname" type="text" placeholder="Search for phones, tablets, laptops and more..." class="form-control">
                                    <!--<button type="submit" class="search-btn"><i class="fas fa-search"></i></button>-->
                                    <button type="" class="search-btn"><i class="fas fa-search"></i></button>

                                </div>
                            <div class="top-btn">
                                <?php if(empty($login)): ?>
                                <a href="<?php echo e(asset('/login')); ?>">Login</a>
                                <a href="<?php echo e(asset('/register')); ?>">Register</a>
                                <?php else: ?>
                                <a href="<?php echo e(asset('/logout')); ?>">logout</a>
                                <a href="<?php echo e(asset('/profile')); ?>">My Profile</a>
                                <?php endif; ?>

                            </div>
                            <?php if(empty($login)): ?>
                            <div class="add-cart-beg">
                                <a href="<?php echo e(url('/cart')); ?>">
                                    <?php
                                   $checksession = Session::has('cart');

                                   if($checksession)
                                   {
                                       $getval = Session::get('cart');

                                       if(!empty($getval)){
                                       $showcountarray = count(array_unique($getval)); ?>

                                       <span class="product-count"><?php echo e($showcountarray); ?></span>



                                <?php } } ?>
                                <i class="fas fa-shopping-cart"></i> </a>
                            </div>
                            <?php else: ?>
                            <div class="add-cart-beg">
                                    <a href="<?php echo e(url('/cart')); ?>">

                                        <?php
                                      $cartitem  =   \App\Helpers\BasicHelpers::getCartItemTotal();
                                        ?>

                                        <?php if($cartitem > 0): ?>
                                        <span class="product-count"><?php echo e($cartitem); ?></span>
                                        <?php else: ?>

                                        <?php endif; ?>

                                <i class="fas fa-shopping-cart"></i> </a>
                                </div>
                            <?php endif; ?>

                          </div>
                        </div>
                        <nav class="top-menu ">
                            <div class="body-overlay"></div>
                            <a href="javascript:void(0)" class="menuImage nav-icon"> <span></span> <span></span> <span></span> </a>
                            <div class="menu iphonNav " >
                              <ul class="d-flex justify-content-between top-menu-inner">
                                    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <li ><a href="<?php echo e(asset('/models/'.$menuitem->slug)); ?> ">
                                      <p><?php echo e($menuitem->device_name); ?></p>
                                      </a>
                                      <?php if($menuitem->slug != 'iPhones'): ?>

                                    <?php
                                    $brandlist = \App\Helpers\BasicHelpers::GetBrandMenuNav($menuitem->id);
                                    ?>
                                    <?php if(count($brandlist)>0): ?>
                                    <ul class="dropdown-menu">
                                    <?php $__currentLoopData = $brandlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(asset('/brand/'.$val->slug)); ?>"><?php echo e($val->title); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <?php endif; ?>

                                 <?php else: ?>

                                    <?php
                                    $modeldetail = \App\Helpers\BasicHelpers::SubMenuNav($menuitem->id);
                                    ?>
                                    <?php if(count($modeldetail)>0): ?>
                                    <ul class="dropdown-menu">
                                    <?php $__currentLoopData = $modeldetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(asset('/search/'.$val->model_name)); ?>"><?php echo e($val->model_name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <?php endif; ?>


                                 <?php endif; ?>


                                    </li>

                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <li><a href="<?php echo e(asset('/product-others')); ?>"><i class="fas fa-certificate"></i>
                                  <p>Others</p>
                                  </a>

                                <ul>
                                        <?php $__currentLoopData = $menuother; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(asset('/models/'.$other->device_name)); ?>"> <?php echo e($other->device_name); ?></a>
                                    <?php
                                  $modeldetail = \App\Helpers\BasicHelpers::SubMenuNav($other->id);

                                 ?>


                                 <?php if(count($modeldetail)>0): ?>
                                 <ul class="dropdown-menu">
                                 <?php $__currentLoopData = $modeldetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                  <li><a href="<?php echo e(asset('/models/'.$val->model_name)); ?>"><?php echo e($val->model_name); ?></a></li>

                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                 <?php endif; ?>


                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>

                                  </li>
                              </ul>
                            </div>
                          </nav>
                      </div>
                    </header>


            <?php echo $__env->yieldContent('content'); ?>





            <?php echo e(Html::script('js/jquery-3.3.1.min.js')); ?>

            <?php echo e(Html::script('js/mb-slider.js')); ?>

            <?php echo e(Html::script('js/popper.min.js')); ?>

            <?php echo e(Html::script('js/bootstrap.min.js')); ?>

            <?php echo e(Html::script('js/iphone-menu.js')); ?>

            <?php echo e(Html::script('js/owl.carousel.js')); ?>

            <?php echo e(Html::script('js/custom.js')); ?>

            <?php echo e(Html::script('js/bottom-top.js')); ?>

            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

            <?php echo e(Html::script('js/jquery.flexslider.js')); ?>


            <?php echo e(Html::script('js/jquery.fancybox.pack.js')); ?>

            <?php echo e(Html::style('css/jquery.fancybox.css')); ?>





    </body>
</html>
