<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

final class CacheDataManager
{


    public function __construct(public string $controllerPath) {}

    public function getData($modelPath, $action)
    {
        $data = Cache::rememberForever(
            $this->makeMasterKey($modelPath),
            fn () => $action
        );

        return $data;
    }

    public function clearCache($modelPath)
    {
        Cache::delete($this->makeMasterKey($modelPath));
    }

    private function makeMasterKey($modelPath)
    {
        return sha1(str_replace('\\', '', $this->controllerPath . $modelPath));
    }
}
