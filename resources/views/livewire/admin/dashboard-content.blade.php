<div>
    <div class="container-fluid">
        <div class="row">

            <!-- 🔷 الصف العلوي: إحصائيات عامة -->
            <div class="col-md-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-store"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Stores</span>
                        <span class="info-box-number">{{ @$storesCount }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-user-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pending Seller Requests</span>
                        <span class="info-box-number">{{ @$pendingSellerRequestsCount }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Products</span>
                        <span class="info-box-number">{{ @$productcount }}</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-3">

            <!-- 🔶 الطلبات بأنواعها -->
            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ @$waitingOrdersCount }}</h3>
                        <p>Orders: Waiting</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('admin.manageOrders') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ @$deliveredOrdersCount }}</h3>
                        <p>Orders: Delivered</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('admin.manageOrders') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ @$inProcessingOrdersCount }}</h3>
                        <p>Orders: In Processing</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <a href="{{ route('admin.manageOrders') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- 🔵 Payments Card في الأسفل لوحده -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ @$paymentsCount }}</h3>
                        <p>Payments Count</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <a href="{{ route('admin.payments') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
