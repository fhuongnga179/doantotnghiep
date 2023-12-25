@extends('admin.main')


@section('content')
    </head>
    <div class="row" style="margin-top: 10px; margin-left: 5px">


    </div>
    <table class="table" id = "example1">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Khách Hàng</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Ngày Đặt hàng</th>
                <th>Thanh toán</th>
                <th>Duyệt đơn</th>
                <th style="width: 100px">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $key => $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at }}</td>
                    <td>{{ $customer->payment_method }}</td>
                    <td>{{ $customer->status }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/customers/view/{{ $customer->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $customer->id }}, '/admin/customers/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-footer clearfix">
        {!! $customers->links() !!}
    </div>
@endsection
