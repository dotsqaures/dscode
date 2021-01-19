<?php $__env->startSection('title','Listing  Details'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.admin.flash.alert', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<section class="content-header">

    <style>
            .listing-squence-outer{
                padding:0 15px;
                width: 100%;
            }
            .listing-squence {

                display: flex;
                list-style: none;
                padding-left: 0;
                flex-wrap: wrap;
                margin: 0 -15px;

            }
           .listing-squence li {

                padding: 5px;
                border: 1px solid #dddd;
                margin: 0 5px 10px;
            }
          .heading-label{

            font-weight: bold;
          }
    </style>

    <h1>
        Manage Product Details
        <small>Here you can view Product Details</small>
    </h1>
    <?php echo e(Breadcrumbs::render('common',['append' => [['label'=> "Listing",'route'=> 'admin.product.index'],['label' => 'Product Details']]])); ?>

</section>

<section class="content" data-table="emailHooks">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?php echo e($Product->item_title); ?></h3>
            
        </div>
        <div class="box-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th scope="row"><?php echo e(__('Item Title')); ?></th>
                    <td><?php echo e($Product->item_title); ?></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo e(__('SKU No')); ?></th>
                    <td>

                        <?php echo e($Product->custom_product_id); ?>



                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php echo e(__('Category')); ?></th>
                    <td><?php echo e($Product->category->title); ?></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo e(__('Quantity')); ?></th>
                    <td><?php echo e($Product->qty); ?></td>
                </tr>

                      <tr>
                    <th scope="row"><?php echo e(__('Final price')); ?></th>
                    <td>$<?php echo e($Product->final_price ? $Product->final_price : __(' -- ')); ?></td>
                     </tr>



                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?php echo e($Product->created_at->toFormattedDateString()); ?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?php echo e(__('Status')); ?></th>
                        <td>    <?php if($Product->status == 1): ?>
                                Active
                                <?php elseif($Product->status == 0): ?>
                                In-Active
                                <?php else: ?>
                                In-Active
                                <?php endif; ?>
                         </td>
                    </tr>

                <?php if(isset($Product->mainphoto)): ?>


                         <tr>
                                <th scope="row"><?= __('Product Photo') ?></th>
                                <td><img src="<?php echo e(asset(Storage::url($Product->mainphoto))); ?>" style="width:100px; height:100px;"/></td>
                            </tr>

                            <?php else: ?>

                            <tr>
                                <th scope="row"><?= __('Product Photo') ?></th>
                                <td><img src="<?php echo e(asset('img/PhoneMeeting.jpg')); ?>" style="width:100px; height:100px;"/></td>
                            </tr>

                         <?php endif; ?>

                         <tr>
                            <th scope="row"><?= __('Bar Code Label') ?></th>
                            <td><div id="printlabel"><?php echo e('SBR'.$Product->custom_product_id); ?></div>
                            <a href="javascript:void()" class="btn btn-default pull-left" onclick="printDivLabel()">Print Label</a>
                        </td>
                        </tr>
<br/><br/>

                         <tr>
                            <th scope="row"><?= __('Bar Code') ?></th>
                            <td><div id="demo"></div>
                            <a href="javascript:void()" class="btn btn-default pull-left" onclick="printDiv()">Print Bar Code</a>
                            </td>
                         </tr>



            </table>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="heading-label"><?php echo e(__('Description')); ?></h4>
                    <?php echo $Product->item_description; ?>

                </div>
            </div>



        </div>
        <div class="box-footer">
                <a href="<?php echo e(route('admin.product.index')); ?>" class="btn btn-default pull-left" title="Cancel"><i class="fa fa-fw fa-chevron-circle-left"></i> Back</a>
        </div>

    </div>


</section>



<?php $__env->stopSection(); ?>


<?php $__env->startSection('per_page_style'); ?>


<style type="text/css" media="print">


    @media  printlabel {
        body * {
          visibility: hidden;
        }
        #printlabel * {
          visibility: visible;
          color: white;
          font-size: 5rem;
        }

      }

      #printlabel {
        color: pink;
        background: #AAAAAA;
      }


    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('per_page_script'); ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?php echo e(asset('js/jquery-barcode.js')); ?>" ></script>

<script>

    var barcodeval =  'SBR'+'<?php echo e($Product->custom_product_id); ?>';


$("#demo").barcode(

barcodeval,// Value barcode (dependent on the type of barcode)
"code93", // type (string)

);



function printDiv(){
    var divToPrint=document.getElementById('demo');

    var newWin=window.open('','Print-Window');

    newWin.document.open();


    newWin.document.write('<html><body onload="window.print()" style="font-size:11px; font-weight:bold; color:#000000;">'+divToPrint.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},10);
}

function printDivLabel(){

    var divToPrint=document.getElementById('printlabel');

    var newWin=window.open('','Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},10);
}

</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>