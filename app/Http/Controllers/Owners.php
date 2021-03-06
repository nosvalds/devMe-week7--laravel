<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Owner;
use App\Http\Requests\OwnerRequest;
use App\Http\Requests\AnimalRequest;

class Owners extends Controller
{
    public function index(Request $request) 
    {
        $search_string = $request->query("search_string");
        if ($search_string !== null) {
            $search_string = $search_string . "%";
            $owners = Owner::where('last_name', 'like', $search_string)->orderBy('last_name', 'desc'); // last name search
            $owners = Owner::where('first_name', 'like', $search_string)->orderBy('first_name', 'desc')->union($owners)->paginate(10); // union last name search + paginate
            $page = "Search Results";
        } else {
            $owners = Owner::paginate(10);
            $page = "Owners";
        }

        if (Auth::check()) {
            $user = Auth::user();
            $login = true;
        } else {
            $user = new User; // pass in empty user object so our ternary operators don't break
            $login = false;
        }

        return view("welcome",['page' => $page,'logged_in' => $login, 'user' => $user, 'owners' => $owners]);
    }

    public function show(Owner $owner, Request $request) // Route Model Binding automatically pulls Owner->find({id});
    {
        if (Auth::check()) {
            $user = Auth::user();
            $login = true;
        } else {
            $user = new User; // pass in empty user object so our ternary operators don't break
            $login = false;
        }
        return view("welcome",['page' => 'Owner', 'logged_in' => $login, 'user' => $user, 'owner' => $owner]);
    }

    public function create()
    {   
        $blankOwner = new Owner; // pass in empty owner object so our ternary operators don't break

        if (Auth::check()) {
            $user = Auth::user();
            $login = true;
        } else {
            $user = new User; // pass in empty user object so our ternary operators don't break
            $login = false;
        }

        return view("owners/form", ['page' => 'Create Owner', 'logged_in' => $login, 'user' => $user, 'owner' => $blankOwner]);
    }

    public function createOwner(OwnerRequest $request)
    { // save owner from form into the DB
        $data = $request->all(); 
        $owner = Owner::create($data); // save into DB
        
        return redirect("/owners/{$owner->id}"); // send them to the owner they just submitted
    }

    public function edit(Owner $owner)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $login = true;
        } else {
            $user = new User; // pass in empty user object so our ternary operators don't break
            $login = false;
        }

        return view("owners/form", ['page' => 'Modify Owner', 'logged_in' => $login, 'user' => $user,'owner' => $owner]);
    }

    public function editOwner(Owner $owner, OwnerRequest $request)
    { 
        // edit owner info from form into the DB
        $data = $request->all(); 
        $owner->update($data);
        
        return redirect("/owners/{$owner->id}"); // send them to the owner they just submitted
    }

    public function addAnimal(Owner $owner, AnimalRequest $request)
    {
        $animal_data = $request->all(); // turn request into array
        $owner->animals()->create($animal_data);

        return redirect("/owners/{$owner->id}"); // redirect to owners page
    }
}
