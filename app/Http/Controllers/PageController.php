<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class PageController extends Controller
{
public function index(){
$response =
Http::get('https://data.covid19.go.id/public/api/prov.json');
$jsonData = $response->json();
// dd($jsonData);
return view('page_one',compact('jsonData'));
}
}
