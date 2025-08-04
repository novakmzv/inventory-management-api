<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        $clients = Client::all();

        return response()->json([
            'data' => $clients,
            'code' => 200,
            'message' => 'Clients retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request): JsonResponse
    {
        $client = Client::create($request->validated());

        return response()->json([
            'data' => $client,
            'code' => 201,
            'message' => 'Client created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client):JsonResponse
    {
        $client->load('sales');

        return response()->json([
            'data' => $client,
            'code' => 200,
            'message' => 'Client retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client): JsonResponse
    {
        $client->update($request->validated());

        return response()->json([
            'data' => $client->fresh(),
            'code' => 200,
            'message' => 'Client updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'data' => null,
            'code' => 200,
            'message' => 'Client deleted successfully'
        ]);
    }
}
