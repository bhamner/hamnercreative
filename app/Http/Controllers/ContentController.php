<?php

namespace App\Http\Controllers;

use DB;
use File;
use Config;
use Image;
use ImageOptimizer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class ContentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware(['auth','block.pending','filter.date','filter.client']);
    }



    /**
     * List site's editable content 
     *
     */
    public function index( Request $request ): View 
    {       
 
        $gate = Gate::authorize('user_has_client',$request);
        $content = \App\Models\Content::whereBetween('updated_at',$request->dates['params'])
                                ->when($request->client, function($query) use ($request) {
                                    return $query->where('client_id', $request->client->id);
                                })->with('client')->get();
        
        return view('content.index',compact(['content','request']));
    }


    /**
     * Show a form to create or update content
     *
     */
    public function edit(Request $request,\App\Models\Client $client, \App\Models\Content $content = null): view
    {
        $gate = Gate::authorize('user_has_client',$request);
        return view('content.edit',compact('content','client'));
    }

    /**
     * Store content and relations in database 
     *
     */
    public function store(Request $request): RedirectResponse
    {

        $gate = Gate::authorize('user_has_client',$request);
        $validated = $request->validate([
            'content_name' => 'required|max:255',
            'client_id' => 'required|numeric|exists:App\Models\Client,id',
            'content_id' => 'nullable|numeric|exists:App\Models\Content,id',
            'content_image' => 'nullable|image'
        ]);

        $client = \App\Models\Client::find($request->get('client_id'));
        $description = json_decode( $request->get('quill_contents') ) ? json_decode( $request->get('quill_contents') )[0]->insert : null;
        if($request->file('content_image')){
            //stream to storage/public then optimize
            $path = Storage::putFile('public', $request->file('content_image'));
            ImageOptimizer::optimize( storage_path('app/'.$path) );  
            //transform to full public url http://localhost:8888/storage/image.png
            $path =  Config::get('app.url').'/'.str_replace('public','storage',$path);
        }

        $new_content = $request->has('content_id') ? \App\Models\Content::find( $request->get('content_id') ) : new \App\Models\Content();
        $new_content->client_id = $client->id;
        $new_content->name = $request->get('content_name');
        if( $request->file('content_image') && isset($path) ){  $new_content->image = $path; }
        $new_content->description = strlen($description) > 1 ? $description  : null ;
        $new_content->quantity_available = $request->get('content_quantity');
        $new_content->price =  $request->get('content_price');
        $new_content->in_stock = intval($request->has('content_in_stock'));
        $new_content->save();

        foreach( $client->content_fields as $option ){
            \App\Models\ContentValue::updateOrCreate(
                ['client_content_field_id' =>  $option->id , 'content_id' => $new_content->id  ],
                ['value' => $request->has( 'content_'.$option->name ) ?  $request->get( 'content_'.$option->name ) : null ]
            );
        }

        return redirect('/content/'.$client->id)->with('success', 'Content saved!');
    }

    /**
     * Delete content and relations
     *
     */
    public function delete( Request $request, \App\Models\Content $content ): RedirectResponse
    {
        $gate = Gate::authorize('user_has_client',$request);
        $content->content_values()->delete();
        $content->delete();
 
        return redirect('/content/'.$client->id)->with('success', 'Item Deleted!');
    }

}
