<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Session\Session;

class ListingController extends Controller
{
    public function index() {
        return view('listings.index', [
            'heading' => 'Latest Lists',
            'listings' => Listing::latest()->filter(request(['search', 'tag']))
            ->paginate(1)
        ]);

    }
    function itrablefun(itrable $itd){
        return ['f', 'b', 'c'];
    }

    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]); 
    }

    public function create() {
        return view('listings.create');
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings',
            'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created Successfully');
    }
}
