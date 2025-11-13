<?php $__env->startSection('title', 'Dashboard - ' . cms_name()); ?>
<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>

                <p>Warga Terdaftar</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53</h3>

                <p>Layanan Diajukan</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>

                <p>Pengguna Terdaftar</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>

                <p>Permintaan Baru</p>
            </div>
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-8">
        <!-- MAP & BOX PANE -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik <?php echo e(cms_name()); ?></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="world-map" style="height: 400px; width: 100%;"></div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="row">
            <div class="col-12">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Laporan Bulanan
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Bar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart"
                                style="position: relative; height: 300px;">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.col -->

    <div class="col-md-4">
        <!-- Info Boxes -->
        <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="fas fa-wifi"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Koneksi Online</span>
                <span class="info-box-number">90%</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="fas fa-comments"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Pesan Masuk</span>
                <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Dokumen Baru</span>
                <span class="info-box-number">41,410</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-danger">
            <span class="info-box-icon"><i class="fas fa-database"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Basis Data</span>
                <span class="info-box-number">65</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Berita Terbaru</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">Pembangunan Fasilitas Umum
                                <span class="badge badge-warning float-right">Publik</span></a>
                            <span class="product-description">
                                Pembangunan jalan lingkungan tahap II telah dimulai...
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">Posyandu Bulan Ini
                                <span class="badge badge-info float-right">Kesehatan</span></a>
                            <span class="product-description">
                                Jadwal posyandu bulan ini telah ditentukan...
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">Musrenbang Desa
                                <span class="badge badge-danger float-right">Perencanaan</span></a>
                            <span class="product-description">
                                Rapat musyawarah perencanaan pembangunan desa...
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">Gotong Royong
                                <span class="badge badge-success float-right">Sosial</span></a>
                            <span class="product-description">
                                Jadwal gotong royong mingguan untuk RT 01...
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="#" class="uppercase">Lihat Semua Berita</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
$(function () {
    //-------------
    //- PIE CHART -
    //-------------
    var pieData = {
        labels: [
            'Laki-laki',
            'Perempuan',
            'Usia Produktif',
            'Lansia'
        ],
        datasets: [
            {
                data: [65, 35, 78, 12],
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
            }
        ]
    };
    
    var pieOptions = {
        legend: {
            display: true
        }
    };
    
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#revenue-chart-canvas').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions      
    });
    
    //-------------
    //- BAR CHART -
    //-------------
    var barData = {
        labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label               : 'Warga',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke : 'rgba(60,141,188,1)',
                data                : [28, 48, 40, 19, 86, 27, 90, 45, 52, 67, 32, 84]
            }
        ]
    };
    
    var barChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
    var barChart       = new Chart(barChartCanvas, {
        type: 'bar', 
        data: barData,
        options: {
            maintainAspectRatio : false,
            responsive : true,
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('theme.admin.adminlte::layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\stelloCMS\app\Themes/admin/adminlte/dashboard/index.blade.php ENDPATH**/ ?>