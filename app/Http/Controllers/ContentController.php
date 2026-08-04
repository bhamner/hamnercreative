<?php

namespace App\Http\Controllers;

use App\Actions\Content\DeleteContent;
use App\Actions\Content\StoreContent;
use App\Http\Requests\StoreContentRequest;
use App\Models\Client;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'block.pending', 'filter.date', 'filter.client']);
    }

    public function index(Request $request, Client $client): View
    {
        $this->authorize('view', $client);

        $content = Content::query()
            ->with('client')
            ->where('client_id', $client->id)
            ->get();

        return view('content.index', compact(['content', 'request', 'client']));
    }

    public function edit(Client $client, ?Content $content = null): View
    {
        $this->authorize('view', $client);

        if ($content) {
            $this->authorize('update', $content);
            $content->load('content_values');
        } else {
            $this->authorize('create', [Content::class, $client]);
        }

        return view('content.edit', compact('content', 'client'));
    }

    public function store(StoreContentRequest $request, StoreContent $storeContent): RedirectResponse
    {
        $client = Client::query()->findOrFail($request->validated('client_id'));
        $this->authorize('view', $client);

        $content = null;
        if ($request->filled('content_id')) {
            $content = Content::query()->findOrFail($request->validated('content_id'));
            $this->authorize('update', $content);
        } else {
            $this->authorize('create', [Content::class, $client]);
        }

        $storeContent($request->all(), $client, $content);

        return redirect()->route('content.index', $client)
            ->with('success', 'Content saved!');
    }

    public function delete(Content $content, DeleteContent $deleteContent): RedirectResponse
    {
        $this->authorize('delete', $content);
        $clientId = $deleteContent($content);

        return redirect()->route('content.index', ['client' => $clientId])
            ->with('success', 'Item Deleted!');
    }
}
