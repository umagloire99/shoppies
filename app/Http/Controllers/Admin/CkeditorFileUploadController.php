<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;

class CkeditorFileUploadController extends Controller
{
    use ImageUploadTrait;

    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {

            $fileName = $this->uploadImage(
                $request->file('upload')->getClientOriginalName(),
                $request->file('upload'),
                'products',
                500,
                null
            );

            $url = asset('storage/images/products/' . $fileName);

            if ($request->has('CKEditorFuncNum')) {
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');

                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
                echo $response;
            } else {
                $data = [
                    'uploaded' => 1,
                    'fileName' => $fileName,
                    'url' => $url
                ];

                return response()->json($data);
            }
        }
    }
}
