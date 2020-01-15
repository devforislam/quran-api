<?php namespace DevForIslam\QuranApi\Http\Controllers;

use Illuminate\Http\Request;
use DevForIslam\QuranApi\Models\Tag;
use App\Http\Controllers\Controller;

class TagController extends ApiBaseController
{
    public function index()
    {
        $tags = Tag::paginate(100);

        return $tags;
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'item.category' => 'required'
        ]);

        $tag = Tag::firstOrCreate($request->only('name'));
        $this->tagItem($tag, $request->item);

        return $tag;
    }

    public function remove(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'item.category' => 'required'
        ]);
        
        $tag = Tag::firstOrCreate($request->only('name'));
        
        $this->untagItem($tag, $request->item);

        
        return $tag;
    }

    private function tagItem(Tag $tag, array $item)
    {
        switch ($item['category']) {
            case 'quran':
                $surahId = $item['surah'];
                $verseId = $item['ayah'];
                $tag->ayahs($surahId)->syncWithoutDetaching([
                    $verseId => [
                        'chapter_id' => $surahId
                    ]
                ]);
                break;

            case 'hadith':
                //Tag hadith
                break;

            default:
                break;
        }
    }

    private function untagItem(Tag $tag, array $item)
    {
        switch ($item['category']) {
            case 'quran':
                $surahId = $item['surah'];
                $verseId = $item['ayah'];  
                $tag->ayahs($surahId)->detach([
                    $verseId
                ]);

                break;
            case 'hadith':
                //untag hadith
                break;
            default:
                break;
        }
    }
}
