<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use App\Http\Requests\OwnerRequest;

class Owners extends Controller
{
    public function index(Request $request) 
    {
        $search_string = $request->query("search_string");
        if ($search_string !== null) {
            $search_string = $search_string . "%";
            $owners = Owner::where('first_name', 'like', $search_string); // first name search
            $owners = Owner::where('last_name', 'like', $search_string)->union($owners)->paginate(10); // union last name search + paginate
            return view("welcome",['page' => 'Owners','owners' => $owners]);
        }
        $owners = Owner::paginate(10);
        return view("welcome",['page' => 'Owners','owners' => $owners]);
    }

    public function show(Owner $owner) // Route Model Binding automatically pulls Owner->find({id});
    {
        return view("welcome",['page' => 'Owner','owner' => $owner]);
    }

    public function create()
    {   
        $blankOwner = new Owner; // pass in empty owner object so our ternary operators don't break
        return view("owners/form", ['page' => 'Create Owner', 'owner' => $blankOwner]);
    }

    public function createOwner(OwnerRequest $request)
    { // save owner from form into the DB
        $data = $request->all(); 

        $owner = Owner::create($data); // save into DB

        return redirect("/owners/{$owner->id}"); // send them to the owner they just submitted
    }

    public function edit(Owner $owner)
    {
        return view("owners/form", ['page' => 'Modify Owner','owner' => $owner]);
    }

    public function search()
    {       
        dd("hello");
    }
}
