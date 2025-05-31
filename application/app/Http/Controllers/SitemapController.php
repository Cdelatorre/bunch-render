<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url as SURL;
use App\Models\Product;
use App\Models\Frontend;

class SitemapController extends Controller
{
    public function generate(): Response
    {
        $sitemap = app()->make('sitemap');

        // Main pages
        $sitemap->add(URL::to('/'));
        $sitemap->add(URL::to('/blog'));
        $sitemap->add(URL::to('/registra-tu-gimnasio'));
        $sitemap->add(URL::to('/policy/privacy-policy/42'));
        $sitemap->add(URL::to('/faqs'));

        return $sitemap->toResponse();
    }

    public function generateSpatie(): Response
    {
        $sitemapPath = public_path('sitemap.xml');
        $sitemapPath = str_replace('application' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR, '', $sitemapPath);

        $sitemap = Sitemap::create()
            ->add(URL::to('/'))
            ->add(URL::to('/registra-tu-gimnasio'))
            ->add(URL::to('/policy/privacy-policy/42'))
            ->add(URL::to('/faqs'));

        $sitemap->add(URL::to('/gimnasios'));

        $products = Product::whereIn('status', [1, 2])->get();

        $cities = [];

       foreach ($products as $product) {
            $productUrl = getProductUrl($product);

            // 1) Decodifica y asegura que SIEMPRE exista la clave 'locality'
            $address = $product->address ?: [];        // ← si es [], sigue
            $locality = $address['locality'] ?? '';                       // ← fallback

            // 2) Normaliza y aplica slug
            $citySlug = \Illuminate\Support\Str::slug($locality);
            if ($citySlug === '') {
                $citySlug = 'sin-ubicacion';                              // valor por defecto
            }

            // 3) Agrupa URLs por ciudad
            $cities[$citySlug][] = $productUrl;
        }


        foreach($cities as $city => $links) {
            $sitemap->add(URL::to('/gimnasios/' . $city));

            foreach($links as $link) {
                $sitemap->add($link);
            }
        }

        $sitemap->add(URL::to('/blog'));

        $blogs = Frontend::where('data_keys', 'blog.element')->get();
        foreach($blogs as $item) {
            $blogUrl = route('blog.details', [slug($item->data_values->title), $item->id]);
            $sitemap->add($blogUrl);
        }

        $sitemap->writeToFile($sitemapPath);

        return response()->make(file_get_contents($sitemapPath), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
