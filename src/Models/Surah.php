<?php namespace DevForIslam\QuranApi\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $table = 'surah';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public function ayahs()
    {
        return $this->hasMany(Ayah::class,'surah_id', 'id');
    }

    public function getIdLabelAttribute(Type $var = null)
    {
        # code...
        return str_pad($this->id, '3', '0', STR_PAD_LEFT);
    }

    public function getAudioUrlAttribute()
    {
        return config('quran.audio.surah_url') . '/Page' . $this->id_label . '.mp3';
    }
}
