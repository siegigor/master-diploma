<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Services\UploadImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var UploadImageService
     */
    private $uploadService;

    /**
     * HomeController constructor.
     * @param UploadImageService $uploadService
     */
    public function __construct(UploadImageService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * @param UploadImageRequest $request
     * @return false|string
     */
    public function upload(UploadImageRequest $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $path = $this->uploadService->upload($request);
        return $path;
    }
}
