<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
            <div class="card">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stores </span>
                        <span class="info-box-number">{{ @$storesCount }}</span>
                    </div>
                    </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="info-box bg-gradient-warning">
                    <span class="info-box-icon"><i class="far fa-copy"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Seller rquests pending</span>
                        <span class="info-box-number">{{ @$pendingSellerRequestsCount }}</span>
                    </div>
                    </div>
            </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
            <div class="card">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ @$paymentsCount }}</h3>
                        <p>payments count</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{route('admin.payments')}}" class="small-box-footer">
                        More info
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    </div>
            </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        </div>
</div>
