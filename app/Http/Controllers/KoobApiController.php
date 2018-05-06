<?php

namespace App\Http\Controllers;

use FastSimpleHTMLDom\Document;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KoobApiController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->filled('term')) {
            return response()->json([
                'error' => 'Cannot perform a search without a term.'
            ], 400);
        }

        $client = new Client();
        $page = $request->get('page') ?? 1;
        $response = $client->get("http://www.orelhadelivro.com.br/livros/buscar/popup?term={$request->get('term')}&page={$page}");

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'error' => $response->getBody()->getContents()
            ], $response->getStatusCode());
        }

        return collect(json_decode($response->getBody()->getContents()))->map(function ($book) {
            $pictures = collect($book->pictures)->map(function ($picture) {
               return "http://media.orelhadelivro.com.br/{$picture}";
            });
            $book->pictures = $pictures;

            if (!is_null($book->author)) {
                $book->author = collect(Document::str_get_html($book->author)->find('a'))->map(function ($element) {
                    return trim($element->plaintext);
                })->implode(', ');
            }
            return $book;
        })->toArray();
    }
}
