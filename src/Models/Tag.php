<?php namespace DevForIslam\QuranApi\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    public function ayahs($surahId = null)
    {
        $rel = $this->belongsToMany(Ayah::class, 'ayah_tag', 'tag_id', 'verse_id', null, 'verse_id')
        ->whereRaw('ayah_tag.chapter_id = quran.surah_id');
        
        if ($surahId) {
            $rel = $rel->wherePivot('chapter_id', $surahId);
        };

        return $rel;
            //;
    }

}
