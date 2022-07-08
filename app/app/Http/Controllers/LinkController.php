<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

/**
 * [Description LinkController]
 */
class LinkController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $postData = collect($request->post('data'));

            $linkValues = $postData->mapWithKeys(function ($item, $key) {
                if ($item['name'] == 'lifetime') {
                    $expires = Carbon::now()->addSeconds($item['value'] * 60);
                    return ['expires' => $expires];
                }

                return [$item['name'] => $item['value']];
            });

            // ensuring we have unique hash
            $hash = Str::random(8);
            while(Link::where('hash', $hash)->count()) {
                $hash = Str::random(8);
            }

            // if URL exists we just make an update for it
            $link = Link::updateOrCreate([
                'url' => $linkValues->get('url')
            ], $linkValues->toArray() + ['hash' => $hash]);

            return new JsonResponse([
                'link' => url($link->hash)
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|NotFound
     */
    public function followLink(Request $request)
    {
        $hash = $request->route('hash');
        if ($link = Link::where('hash', $hash)->first()) {
            if ($link->hit_limit && $link->hit_limit > $link->hit_count) {
                $link->hit_count++;
                $link->save();

                return redirect($link->url);
            } else if ($link->expires && $link->expires > Carbon::now()) {
                return redirect($link->url);
            }
        }

        return response(view('404'), Response::HTTP_NOT_FOUND);
    }
}
