<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // Xử lý dữ liệu liên hệ và gửi email hoặc lưu vào cơ sở dữ liệu

        // Ví dụ: In ra dữ liệu từ form
        dd($request->all());
    }
    public function Dangky()
    {
    }
}
