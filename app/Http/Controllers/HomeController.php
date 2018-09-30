<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Services\Analysis\ImageAnalysisService;
use App\Services\UploadImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\File;

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
     * @var ImageAnalysisService
     */
    private $analysisService;

    /**
     * HomeController constructor.
     * @param UploadImageService $uploadService
     * @param ImageAnalysisService $analysisService
     */
    public function __construct(UploadImageService $uploadService, ImageAnalysisService $analysisService)
    {
        $this->uploadService = $uploadService;
        $this->analysisService = $analysisService;
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
        dd($this->analysisService->analyzeImage($path));
    }
}
