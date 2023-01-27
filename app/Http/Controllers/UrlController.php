<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Url;
use App\Http\Requests\UrlRequest;
use App\Repositories\UrlRepository;
use Illuminate\Support\Facades\Auth;
use App\Helpers\urlService;

class UrlController extends Controller
{

    protected $urlRepository, $urlService;

    public function __construct(UrlRepository $urlRepository, urlService $urlService)
    {
        $this->urlRepository = $urlRepository;
        $this->urlService = $urlService;
    }

    public function showDashboard()
    {
        $user_id = Auth::id();
        $data = $this->urlRepository->getAll($user_id);
        return view('dashboard', compact('data'));
    }

    public function storeUrl(UrlRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $slug = $this->urlService->createShortUrl();

            $urlCount = $this->urlRepository->findWhere(['destination' => $validatedData['destination'], 'user_id' => Auth::id()])->count();

            if ($urlCount) {
                $existingUrl = $this->urlRepository->findWhere(['destination' => $validatedData['destination'], 'user_id' => Auth::id()])->first();

                return back()->with('success', 'The provided destination URL is already in use. With shortened URL ' . $existingUrl->getShortUrlAttribute());
            }

            $data = [
                'destination' => $validatedData['destination'],
                'slug' => $slug,
                'user_id' => Auth::id()
            ];
            $this->urlRepository->create($data);
            return back()->with('success', 'URL successfully shortened!');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function apiShorten(UrlRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $slug = $this->urlService->createShortUrl();

            $urlCount = $this->urlRepository->findWhere(['destination' => $validatedData['destination']])->count();


            if ($urlCount) {
                $url = $this->urlRepository->findWhere(['destination' => $validatedData['destination']])->first();
            } else {
                $data = [
                    'destination' => $validatedData['destination'],
                    'slug' => $slug,
                ];
                $url = $this->urlRepository->create($data);
            }

            return response()->json([
                'destination' => $url->destination,
                "slug" => $url->slug,
                "updated_at" => $url->updated_at,
                "created_at" => $url->created_at,
                "id" => $url->id,
                'shortened_url' => $url->getShortUrlAttribute()
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function redirectToDest($slug)
    {
        try {
            $url = Url::where('slug', $slug)->first();

            if ($url) {
                $url->increment('views');
                return redirect($url->destination);
            } else {
                return redirect()->route('404');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
