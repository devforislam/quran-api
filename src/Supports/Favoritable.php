<?php

namespace  DevForIslam\QuranApi\Supports;

use DevForIslam\QuranApi\Models\Ayah;

trait Favoritable 
{
    public function scopeWithFavoriteAyahs($query) 
    {
        $query->with([
            'favoriteAyahs'
            ]);
    }    

    public function favoriteAyahs()
    {
        $relation =  $this->belongsToMany(Ayah::class, 'favorites', 'created_by', 'verse_id', null, 'verse_id')
            ->whereNull('favorites.deleted_at')
            ->whereRaw('`ayah`.`surah_id`=`favorites`.`chapter_id`');
        // $relation
        // ->getQuery() // Eloquent\Builder
        // ->getQuery() // Query\Builder
        // ->joins = [];
        // $relation->getQuery()->join('favorites', function($join) {
        //     $join->on('quran.verse_id', '=', 'favorites.verse_id')
        //         ->whereRaw('`quran`.`surah_id`=`favorites`.`chapter_id`');
        // });

        return $relation;
    }
}
