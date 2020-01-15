<?php namespace DevForIslam\QuranApi\Http\Controllers;

use App\Http\Controllers\Controller;

class QuranController extends ApiBaseController
{
    protected $module = 'quran';

    public function index($name)
    {
        $file  = '/quran/pdf/'.$name . '.pdf';

        if (file_exists(public_path($file))) {
            return view('quran.pdf_format', compact('file'));
        }
        
        return 'file note found';
    }
}
