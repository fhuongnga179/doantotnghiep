@extends('admin.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $product_count }}</h3>
                    <p>Sản phẩm</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $order_count }}</h3>
                    <p>Số đơn hàng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($order_sum) }} <sup style="font-size: 20px">VND</sup></h3>
                    <p>Tổng doanh thu</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>

        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $menu_count }}</h3>
                    <p>Danh mục</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>

        <!-- Add this section to display date range selection -->
        <form action="{{ route('admin.home') }}" method="get">
            <label for="start_date">Từ:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate->toDateString() }}">

            <label for="end_date">Đến:</label>
            <input type="date" id="end_date" name="end_date" value="{{ $endDate->toDateString() }}">

            <button type="submit">Xem Doanh Thu</button>

        </form>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($sales) }} <sup style="font-size: 20px">VND</sup></h3>
                    <p>Doanh số từ {{ $startDate->toDateString() }} đến {{ $endDate->toDateString() }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>

        <div>
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
        
    </div>
@endsection
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var salesData = @json($salesData);

    var dates = salesData.map(function(item) {
        return item.date;
    });

    var totals = salesData.map(function(item) {
        return item.total;
    });

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: 'Doanh thu',
                data: totals,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
