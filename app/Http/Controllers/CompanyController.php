<?php

namespace App\Http\Controllers;

use App\Models\Companies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    // GET /companies
    public function index()
    {
        return response()->json(Companies::all(), Response::HTTP_OK);
    }

    // POST /companies
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'CompanyName' => 'required|string|max:255',
            'CompanyCode' => 'required|string|max:255',
        ]);

        $companyData = Companies::create([
            'CompanyName' => $validatedData['CompanyName'],
            'CompanyCode' => $validatedData['CompanyCode'],
            'Status' => 'Y',
            'CreateWho' => 'TEST_ADMIN',
            'ChangeWho' => 'TEST_ADMIN'
        ]);

        return response()->json($companyData, Response::HTTP_CREATED);
    }

    // GET /companies/{id}
    public function show($id)
    {
        $companyRecord = Companies::find($id);

        if(!$companyRecord) {
            return response()->json(['message' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($companyRecord, Response::HTTP_OK);
    }

    // PUT /companies/{id}
    public function update(Request $request, $id)
    {
        $companyRecord = Companies::find($id);

        if(!$companyRecord) {
            return response()->json(['message' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'CompanyName' => 'required|string|max:255',
            'CompanyCode' => 'required|string|max:255',
        ]);

        $companyRecord->update([
            'CompanyName' => $validatedData['CompanyName'],
            'CompanyCode' => $validatedData['CompanyCode'],
            'ChangeWho' => "TEST_ADMIN"
        ]);

        return response()->json($companyRecord, Response::HTTP_OK);
    }

    // DELETE /companies/{id}
    public function destroy($id)
    {
        $companyRecord = Companies::find($id);

        if(!$companyRecord){
            return response()->json(['message' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }
        
        $companyRecord->delete();

        return response()->json(['message' => 'Company deleted successfully'], Response::HTTP_OK);
    }
}
