<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PagesController extends Controller
{
    //
    public function index()
    {
        $data = array(
        'drag_images_url' => route('drag_images')
      );

        return view('pages/index')->with($data);
    }

    public function drag_images()
    {
        return view('partials/drag_images');
    }

    public function processDropzoneUpload(Request $request)
    {
        // Start running the encryption algorithm
        $rootDir = getcwd();
        $process = new Process('python '.$rootDir.'/laravel/python/test.py');
        // 3600 seconds = 1 hour
        $process->setTimeout(0.5 * 3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            return new ProcessFailedException($process);
            die();
        }

        // Notify session
        $convertedFiles = $process->getOutput();
        $request->session()->put('fileConverted', True);
        $request->session()->put('convertedFileName', $convertedFiles);
        return 1;

    }

    public function dropzone()
    {
        session()->put('fileUploaded', False);
        return view('partials/dropzone');
    }


    public function dropzoneUpload(Request $request)
    {
        // Rename and move the uploaded file
        $fileOriginalName = $request->file->getClientOriginalName();
        $fileName = time()."_".$fileOriginalName;
        $request->file->move(public_path('images'), $fileName);

        // Notify session
        $request->session()->put('fileUploaded', True);
        $request->session()->put('uploadedFileName', $fileName);
        $request->session()->put('fileConverted', False);

        return response()->json(['success'=>$fileName]);
    }


}
