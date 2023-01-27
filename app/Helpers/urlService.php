<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Repositories\UrlRepository;

class urlService
{
 protected $urlRepository;

 public function __construct(UrlRepository $urlRepository)
 {
  $this->urlRepository = $urlRepository;
 }

 public function createShortUrl()
 {
  do {
   $slug = Str::random(5);
   $existingSlug = $this->urlRepository->findWhere(['slug' => $slug])->first();
  } while ($existingSlug);

  return $slug;
 }
}
