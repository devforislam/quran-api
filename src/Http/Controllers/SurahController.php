<?php namespace DevForIslam\QuranApi\Http\Controllers;

use App\Http\Controllers\Controller;
use DevForIslam\QuranApi\Models\Surah;
use DevForIslam\QuranApi\Models\Ayah;
use DevForIslam\QuranApi\Transformers\SurahTransformer;
use DevForIslam\QuranApi\Transformers\SurahListTransformer;
use Illuminate\Http\Request;
use DevForIslam\QuranApi\Models\Language;

class SurahController extends ApiBaseController
{
    protected $module = 'quran';

    public function index()
    {
        return $this->all();
    }

    public function all()
    {
        $allSurah = Surah::get();

        return $this->transformResponse($allSurah, (new SurahTransformer())->shouldExcludeVerses())->toArray();
    }

    public function show($id, Request $request)
    {        
        $languages = $this->getLanguageCodes();
        
        $surah = Surah::with([
                'ayahs' => function($query) use($languages) {
                    $query->whereIn('language_code', $languages);
                }, 
                'ayahs.tags'  => function($query) use($id) {
                    $query->wherePivot('chapter_id', $id);
                }, 
                'ayahs.favoritedBy'  => function($query) use($id) {
                    $query->wherePivot('chapter_id', $id);
                }, 
            ])
            ->find($id);

        $response = $this->transformResponse($surah, new SurahTransformer())
            ->toArray();
        
        if (isset($response['data']['verses']['data'])) {
            $response['data']['verses']['data'] = array_filter($response['data']['verses']['data'], function($item) {
                return isset($item['ar']);
            });
        }

        $response['data']['verses'] = $response['data']['verses']['data'] ?? [];

        return $response;
    }
}
