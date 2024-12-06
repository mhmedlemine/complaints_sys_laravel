<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Merchant;
use App\Models\Moughataa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntrepriseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the enterprises.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entreprises = Entreprise::with(['owner', 'moughataa.wilaya'])
            ->paginate(10);
        
        return response()->json($entreprises);
    }

    /**
     * Store a newly created enterprise in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:entreprises',
            'name' => 'required|string|max:255',
            //'name_ar' => 'required|string|max:255',
            'moughataa_id' => 'required|exists:moughataas,id',
            'owner_id' => 'required|exists:merchants,id',
            //'status' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            //'registredon' => 'required|date',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            // 'rg' => 'nullable|string|max:255',
            // 'notes' => 'nullable|string',
            //'address' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // return response()->json(['debug' => $request->all()]);

        try {
            $picture = null;
            if ($request->hasFile('picture_file') && $request->file('picture_file')->isValid()) {
                $filePath = $request->picture_file->store('shop_pictures', 'public');
                $picture = [
                    'file_path' => $filePath,
                    'file_type' => 'image',
                    'uploaded_by' => auth()->id(),
                    'uploaded_at' => now(),
                ];
            }

            $request->request->remove('picture_file');
            $data = array_merge($request->all(), [
                'status' => 'open',
                'agent_id' => $request->user()->id,
                'picture' => $picture,
                'registeredon' => now()
            ]);
    
            $entreprise = Entreprise::create($data);
            
            return response()->json([
                'message' => 'Enterprise created successfully',
                'data' => $entreprise->id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating enterprise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeMerchant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'phonenumber' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $merchant = Merchant::create($request->all());
            
            return response()->json( $merchant, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating enterprise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get enterprises registered by the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myEntreprises(Request $request)
    {
        try {
            $entreprises = Entreprise::where('agent_id', $request->user()->id)
                ->with(['owner', 'moughataa.wilaya'])
                ->orderBy('created_at', 'desc')->get();

            return response()->json(
                $entreprises
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving enterprises',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMoughataas(Request $request)
    {
        try {
            $moughataas = Moughataa::with(['wilaya'])->get();

            return response()->json(
                $moughataas
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving Moughataas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEntrepriseCode(Request $request)
    {
        try {
            $latestCode = DB::table('entreprises')
                ->where('code', 'like', $request['code'].'%')
                ->orderBy('id', 'desc')
                ->value('code');

            if ($latestCode) {
                $numericPart = intval(substr($latestCode, 4)) + 1;
                $newCode = $request['code'] . $numericPart;
                return response()->json(
                    $newCode
                );
            } else {
                $newCode = $request['code'] . '01';
                return response()->json(
                    $newCode
                );
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error generating new code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified enterprise.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $entreprise = Entreprise::with(['owner', 'moughataa.wilaya'])
                ->findOrFail($id);
            
            return response()->json($entreprise);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Enterprise not found'
            ], 404);
        }
    }

    /**
     * Update the specified enterprise in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required|string|max:255|unique:entreprises,code,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'name_ar' => 'sometimes|required|string|max:255',
            'moughataa_id' => 'sometimes|required|exists:moughataas,id',
            'owner' => 'sometimes|required|exists:merchants,id',
            'status' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'registredon' => 'sometimes|required|date',
            'agent_id' => 'sometimes|required|exists:users,id',
            'lat' => 'sometimes|required|numeric',
            'lon' => 'sometimes|required|numeric',
            'rg' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'address' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $entreprise = Entreprise::findOrFail($id);
            $entreprise->update($request->all());
            
            return response()->json([
                'message' => 'Enterprise updated successfully',
                'data' => $entreprise->load(['owner', 'moughataa.wilaya'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating enterprise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified enterprise from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $entreprise = Entreprise::findOrFail($id);
            $entreprise->delete();
            
            return response()->json([
                'message' => 'Enterprise deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting enterprise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search enterprises by name or code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $entreprises = Entreprise::where('name', 'LIKE', "%{$query}%")
            ->orWhere('code', 'LIKE', "%{$query}%")
            ->orWhere('name_ar', 'LIKE', "%{$query}%")
            ->with(['owner', 'moughataa.wilaya'])
            ->paginate(10);
        
        return response()->json($entreprises);
    }

    /**
     * search Merchants by name or phonenumber.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchMerchant(Request $request)
    {
        $query = $request->get('query');
        
        $merchants = Merchant::where('phonenumber', 'LIKE', "%{$query}%")
            ->get();
        
        return response()->json($merchants);
    }

    /**
     * Get enterprises by type.
     *
     * @param  string  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByType($type)
    {
        $entreprises = Entreprise::where('type', $type)
            ->with(['owner', 'moughataa.wilaya'])
            ->paginate(10);
        
        return response()->json($entreprises);
    }
}