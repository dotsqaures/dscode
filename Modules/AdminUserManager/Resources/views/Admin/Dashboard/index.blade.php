@extends('layouts.admin.master')
@section('title','Dashboard')
@section('content')



   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>0</h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->


        <div class="col-lg-3 col-xs-6">
          <a href="{{ url('admin/Orders/histroy')}}" >
                    <div class="small-box bg-green">
                      <div class="inner">
                        <h3>0</h3>

                        <p>Today Orders</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>

                    </div>
              </a>
                  </div>


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">

                    <h3>0</h3>

                    <p>Total Product</p>
                  </div>
                  <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                  </div>

                </div>
              </div>







        <!-- ./col -->
        <!--<div class="col-lg-3 col-xs-6">

          <div class="small-box bg-maroon">
            <div class="inner">
              <h3>0</h3>

              <p>Total Buyer</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>-->
        <!-- ./col -->


         <!-- ./col -->


        <!-- ./col -->
      </div>
      <!-- /.row -->
    </section>


@stop
