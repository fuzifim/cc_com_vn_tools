<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cache;

class HomeController extends Controller
{
    public function index(Request $request){
        $page = $request->has('page') ? $request->query('page') : 1;
        $newDomain=Cache::store('memcached')->remember('newDomain_'.$page, 1, function()
        {
            return DB::connection('mongodb')->collection('mongo_domain')
                ->where('craw_next','exists',true)
                ->orderBy('updated_at','desc')
                ->simplePaginate(50);
        });
        $data=[
            'newDomain'=>$newDomain
        ];
        return view('home', $data);
    }
    public function show($slug){
        if(!empty($slug)){
            $domain = Cache::store('memcached')->remember('infoDomain_'.base64_encode($slug), 1, function() use($slug)
            {
                return DB::connection('mongodb')->collection('mongo_domain')
                    ->where('base_64',base64_encode($slug))->first();
            });
            if(!empty($domain['domain'])){
                DB::connection('mongodb')->collection('mongo_domain')
                    ->where('base_64',base64_encode($slug))
                    ->increment('view', 1);
                $return=array(
                    'domain'=>$domain
                );
                return view('domain.show', $return);
            }else{
                echo 'domain not found';
            }
        }
    }
}