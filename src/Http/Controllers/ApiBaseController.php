<?php namespace DevForIslam\QuranApi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

abstract class ApiBaseController extends Controller
{
    protected $module = 'quran';

    public function __construct()
    {
        config(['auth.defaults.guard' => 'api']);
    }

    public function getLanguageCodes()
    {
        $languages = (array) request()->get('language') ?? [];
        array_push($languages, 'ar',  'en');

        return $languages;
    }

    protected function transformResponse($data, $transformerOrCallback) 
    {
        $fractal = new Manager();
        $resource = null;

        if ($data instanceof Model) {
            $resource = new Item($data, $transformerOrCallback);
        } else {
            $resource = new Collection($data,$transformerOrCallback);
        }

        return $fractal->createData($resource);
    }
}
