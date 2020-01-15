<?php namespace DevForIslam\QuranApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Favorite extends Model
{
    use SoftDeletes;

    protected $table = 'favorites';

    protected $primaryKey = 'id';

    protected $fillable = ['favoritable_type', 'chapter_id', 'verse_id', 'created_by'];

    public function toggle()
    {
        if ($this->trashed()) {
            $this->restore();
        } else if (!$this->wasRecentlyCreated) {
            $this->delete();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }    

    public function ayahs()
    {
        $relation = $this->hasMany(Ayah::class, 'surah_id', 'chapter_id')->where('language_code', 'ar');
        $relation->getQuery()->join($this->table, function($join) {
                    $join->on('quran.verse_id', '=', $this->table. '.verse_id');
        });
        return $relation;
    }
}
