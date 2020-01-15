<?php namespace DevForIslam\QuranApi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DevForIslam\QuranApi\Models\Ayah;
use DevForIslam\QuranApi\Models\Favorite;
use App\User;
use DevForIslam\QuranApi\Transformers\AyahTransformer;

class FavoriteController extends ApiBaseController
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $languages = $this->getLanguageCodes();

        $ayahs = $request->user()
            ->favoriteAyahs()
            ->whereIn('language_code', $languages)
            ->get();

        $ayahsBySurah = $ayahs->sortBy('verse_id')->groupBy('surah_id');
        $transformed['data'] = [];

        foreach ($ayahsBySurah as $ahs) {
            $ahs = $this->transformResponse($ahs->groupBy('verse_id'), new AyahTransformer())
                ->toArray();
            array_push($transformed['data'], ...$ahs['data']);
        }

        return $transformed;
    }

    public function store(Request $request)
    {
        $this->validate($request, ['item.*' => 'required']);
        
        $item = $request->item;
        $favorite = new Favorite();

        switch ($item['category']){
            case 'quran':
                $chapterId = $item['surah'];
                $verseId = $item['ayah'];
                $ayah = new Ayah();
                $favorite = Favorite::withTrashed()
                    ->firstOrCreate([
                        'chapter_id' => $chapterId,
                        'verse_id' => $verseId,
                        'created_by' => \Auth::id() ?: 0,
                        'favoritable_type' => $ayah->getMorphClass()
                    ]);
                break;

            case 'hadith': 
                //Todo
                break;  
                
            default:
                break;
        }

        $favorite->toggle();

        return $favorite;
    }
}
