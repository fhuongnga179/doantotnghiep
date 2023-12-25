<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UploadService;

class UploadController extends Controller
{
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('file');

        $fileName = time() . '_' . $file->getClientOriginalName();

        $directory = 'uploads/image';

        $filePath = $file->storeAs($directory, $fileName, 'public');

        if ($filePath) {
            $publicUrl = asset('storage/' . $filePath);
            return $publicUrl;
        }

        return false;
    }
}
