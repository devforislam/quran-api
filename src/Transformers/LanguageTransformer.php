<?php
/**
 * Created by PhpStorm.
 * User: mahbub
 * Date: 12/26/16
 * Time: 12:07 AM
 */

namespace DevForIslam\QuranApi\Transformers;


use DevForIslam\QuranApi\Models\Language;
use League\Fractal\TransformerAbstract;

class LanguageTransformer extends TransformerAbstract
{

    public function transform(Language $language)
    {
        return [
            'id' => $language->ref_id,
            'name' => $language->name,
            'code' => $language->code
        ];

    }

}