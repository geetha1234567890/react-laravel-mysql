<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Admin\Models\CallRequest;

class CallRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $callRequests = CallRequest::all();
            return response()->json($callRequests);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve call requests', 'error' => $e->getMessage()], 500);
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
            $request->validate([
                'sender_id' => 'required|integer',
                'receiver_id' => 'required|integer',
                'meeting_link' => 'nullable|string',
                'meeting_time' => 'nullable|date',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ]);

            $callRequest = CallRequest::create($request->all());

            return response()->json($callRequest, 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create call request', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $callRequest = CallRequest::find($id);

            if (!$callRequest) {
                return response()->json(['error' => 'Call Request not found'], 404);
            }

            return response()->json($callRequest);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve call request', 'error' => $e->getMessage()], 500);
        }
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

            $callRequest = CallRequest::find($id);

            if (!$callRequest) {
                return response()->json(['error' => 'Call Request not found'], 404);
            }

            $request->validate([
                'sender_id' => 'required|integer',
                'receiver_id' => 'required|integer',
                'meeting_link' => 'nullable|string',
                'meeting_time' => 'nullable|date',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ]);

            $callRequest->update($request->all());

            return response()->json($callRequest);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to update call request', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $callRequest = CallRequest::find($id);

            if (!$callRequest) {
                return response()->json(['error' => 'Call Request not found'], 404);
            }

            $callRequest->delete();

            return response()->json("Record deleted successfully", 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to delete call request', 'error' => $e->getMessage()], 500);
        }
    }
}
