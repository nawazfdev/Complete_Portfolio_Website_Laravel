<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('tenants.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'domainname' => 'required|string|max:255|unique:domains,domain',
            'password' => ['required', 'confirmed',Rules\Password::default()],
        ]);
    
        // Create a new tenant using the validated data
        $tenant = Tenant::create($validatedData);
    
        // Create domain associated with the tenant
        $tenant->domains()->create([
            'domain' => $validatedData['domainname'] . '.' . config('app.domain'),
        ]);
    
        


return redirect()->route('tenants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
