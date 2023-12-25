<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
class InvoiceController extends Controller
{
    public function previewPDF()
    {
        $data = ['content' => 'Hello, this is a preview PDF content.'];
        $view = view('admin.pdf.preview',$data);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        // Return the HTML content for preview
        return $pdf->stream('in.pdf');
    }

    public function preview($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        // Truyền dữ liệu customer đến view
        return view('admin.pdf.preview', compact('customer'));
    }
}