<?php
/**
 * Created by PhpStorm.
 * User: mahbub
 * Date: 12/26/16
 * Time: 12:15 AM
 */

namespace DevForIslam\QuranApi\Transformers;


use DevForIslam\QuranApi\Models\Ayah;
use League\Fractal\TransformerAbstract;

class AyahTransformer extends TransformerAbstract
{
    public function transform($ayahs)
    {
        $result = null;
        $verseId = 0;
        foreach ($ayahs as $verse) {

            if (!isset($result[$verse->verse_id])) {
                $verseId = $verse->verse_id;
                $result[$verseId] = [
                    'audio_url' => $verse->audio_url,
                    'verse_id' => ($verseId),
                    'tags' => $verse->tags->pluck('name')->all(),
                    'surah_id' => $verse->surah_id,
                    'is_favorite' => $verse->is_favorite,
                    'meta'=> $verse->meta_data 
                ];
            }

            $lang = $verse->language_code ?: $$verse->language_id;
            $result[$verse->verse_id] = array_merge(
                $result[$verse->verse_id],
                [
                    $lang => $verse->ayah
                ]
            );
        }
        
        return $result[$verseId];
    }
    
}