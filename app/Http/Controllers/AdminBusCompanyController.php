<?php

namespace App\Http\Controllers;

use App\Models\BusCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminBusCompanyController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => [
                'required',
                'string',
                'max:255',
                'unique:bus_companies,company_name',
            ],
            'phone' => [
                'required',
                'regex:/^\d{11}$/',
                'unique:bus_companies,phone',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'company_name.required' => 'Company name is required.',
            'company_name.unique' => 'This company name already exists.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be exactly 11 digits.',
            'phone.unique' => 'This phone number already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.dashboard')
                ->withErrors($validator)
                ->withInput()
                ->with('active_section', 'bus_companies');
        }

        BusCompany::create([
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('active_section', 'bus_companies')
            ->with('company_success', 'Bus company added successfully!');
    }

    public function destroy(BusCompany $busCompany)
    {
        $busCompany->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('active_section', 'bus_companies')
            ->with('company_success', 'Bus company deleted successfully!');
    }
}
