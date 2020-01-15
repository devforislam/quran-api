<?php namespace DevForIslam\QuranApi\Http\Controllers;

use DevForIslam\QuranApi\Models\Language;
use DevForIslam\QuranApi\Transformers\LanguageTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends ApiBaseController
{
    protected $module = 'quran';



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $AllLanguages = Language::whereNotIn('code', ['ar', 'en'])
            ->orderBy('name')
            ->get();

        return $this->transformResponse($AllLanguages, new LanguageTransformer())
            ->toArray();
    }

}
