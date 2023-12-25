<!-- resources/views/pdf/preview.blade.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Trước PDF</title>
</head>

<body>
    <h1>Hoá đơn</h1>
    {{-- <p>Mã giỏ hàng: {{ $customer->id }}</p> --}}

    <div id="pdf-container"></div>
    <script src="{{ asset('js/pdf.worker.js') }}"></script>
    <script src="{{ asset('pdf.js/build/pdf.js') }}"></script>

</body>

</html>
