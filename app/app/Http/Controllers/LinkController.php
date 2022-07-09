<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LinkRequest;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Facade\FlareClient\Http\Exceptions\NotFound;

/**
 * [Description LinkController]
 */
class LinkController extends Controller
{

    /**
     * @param Collection $data
     *
     * @return Collection
     */
    protected function formatData(Collection $data): Collection {
        return $data->mapWithKeys(function ($value, $key) {
            if ($key == 'lifetime') {
                $expires = Carbon::now()->addSeconds($value * 60);
                return ['expires' => $expires];
            }

            return [$key => $value];
        });
    }

    /**
     * @return string
     */
    protected function generateUniqueHash(): string {
        $hash = Str::random(8);

        while(Link::where('hash', $hash)->count()) {
            $hash = Str::random(8);
        }

        return $hash;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(LinkRequest $request): JsonResponse
    {
        try {
            $data = collect($request->post());
            $linkValues = $this->formatData($data);
            $hash = $this->generateUniqueHash();

            // if hash for URL exists we just make an update for it
            $link = Link::updateOrCreate([
                'url' => $linkValues->get('url')
            ], $linkValues->toArray() + ['hash' => $hash]);

            return new JsonResponse([
                'link' => url($link->hash)
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
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
