<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Modules\Admin\Models\Batch;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $batches = Batch::with('parent', 'children')->get();
            return response()->json($batches);
        } catch (\Exception $e) {
            Log::error('Error retrieving batches:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve batches'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            try {
                    $validatedData = Validator::make($request->all(), [
                        'data' => 'required|array',
                        'data.*.id' => 'required|integer',
                        'data.*.name' => 'required|string|max:255',
                        'data.*.parent_id' => 'nullable|exists:batches,id',
                        'data.*.branch' => 'nullable|string|max:255',
                        'data.*.is_active' => 'required|boolean',
                        'data.*.child_batches' => 'nullable|array',
                    ])->validate();
                     $batches = [];
                     $i=0;
                    foreach ($validatedData['data'] as $batchData) {
                        $batches[] = $this->createBatch($batchData);
                    }

                    //TODO - >  batches response
                return response()->json($batches, 201);
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('Validation Error:', ['errors' => $e->errors()]);
                return response()->json(['errors' => $e->errors()], 422);
            } catch (\Exception $e) {
                Log::error('Unexpected Error:', ['message' => $e->getMessage()]);
                return response()->json(['error message' => $e->getMessage()], 500);
            }
    }


    protected function createBatch(array $batchData)
    {
        try {
         
            $childBatches = $batchData['child_batches'] ?? [];
            
            unset($batchData['child_batches']);
            
            $batch = Batch::create($batchData);
            foreach ($childBatches as $childBatchData) {
                $this->createBatch($childBatchData);
            }
        return Batch::with('parent', 'children')->get();
        } catch (\Exception $e) {
            Log::error('Error Creating Batch:', ['data' => $batchData, 'message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e->getMessage();
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // echo "testSandeep";
        // die;
        $batch = Batch::with('parent', 'children')->findOrFail($id);
        return response()->json($batch);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $batch = Batch::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:batches,id',
                'branch' => 'nullable|string|max:50',
                'is_active' => 'required|boolean',
            ]);

            $batch->update($validatedData);

            return response()->json($batch);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating batch:', ['message' => $e->getMessage()]);
            return response()->json(['Failed to update batch: error message =>' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $batch = Batch::findOrFail($id);
            $batch->delete();

            // return response()->json(null, 204);
            return response()->json("Record deleted successfully", 200);
        } catch (\Exception $e) {
            Log::error('Error deleting batch:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete batch'], 500);
        }
    }
}
