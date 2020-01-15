<?php namespace DevForIslam\QuranApi\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Ayah extends Model
{
    protected $table = 'ayah';

    protected $primaryKey = 'id';

    protected $fillable = ['language_id', 'language_code', 'surah_id', 'verse_id', 'ayah'];

    public $timestamps = false;

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'ref_id');
    }

    public function surah(Type $var = null)
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function getIdLabelAttribute(Type $var = null)
    {
        return $this->surah->id_label . str_pad($this->verse_id, '3', '0', STR_PAD_LEFT);
    }

    public function getAudioUrlAttribute()
    {
        return config('quran.audio.verse_url') . '/' . $this->id_label . '.mp3';
    }

    public function tags($surahId = null)
    {
        $rel = $this->belongsToMany(Tag::class, 'ayah_tag', 'verse_id', 'tag_id', 'verse_id');
            
        if ($surahId) {
            $rel = $rel->wherePivot('chapter_id', $surahId);
        };

        return $rel;
    }

    public function getMetaDataAttribute() 
    {
        $this->loadMissing('surah');

        return ($this->surah->name ?? '') . " [$this->surah_id:$this->verse_id]";
    }

    public function getIsFavoriteAttribute()
    {
        $this->loadMissing('favoritedBy');

        return $this->favoritedBy->contains('id', \Auth::id());
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'verse_id', 'created_by', 'verse_id')
            ->whereNull('favorites.deleted_at');
    }
}
