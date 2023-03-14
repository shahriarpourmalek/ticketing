<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Http\Requests\UpdateTicketsRequest;
use App\Http\Resources\ShowTicketsResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): TicketResource
    {
        $tickets = Auth::user()->tickets();

        return new TicketResource($tickets);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request): TicketResource
    {
        $ticket = new Ticket;
        $ticket->setTitleAttribute($request->title);
        $ticket->setDescriptionAttribute($request->description);
        $ticket->setPriorityAttribute($request->priority);
        $ticket->setCategoryAttribute($request->category);
        $ticket->user_id = Auth::user()->id;
        $ticket->save();

        return new TicketResource($ticket);

    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(Ticket $ticket): ShowTicketsResource
    {

        $this->authorize('view', $ticket);

        return new ShowTicketsResource($ticket);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketsRequest $request,  $id): ShowTicketsResource
    {
        $ticket = Ticket::findOrFail($id);


        if ($request->filled('title')) {
            $ticket->title = $request->title;
        }
        if ($request->filled('description')) {
            $ticket->description = $request->description;
        }
        if ($request->filled('priority')) {
            $ticket->priority = Ticket::PRIORITIES[$request->priority];
        }
        if ($request->filled('category')) {
            $ticket->category = Ticket::CATEGORIES[$request->category];
        }
        if ($request->filled('status')) {
            $ticket->status = Ticket::STATUSES[$request->status];
        }

        $ticket->save();

        return new ShowTicketsResource($ticket);

    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return response()->json([
            'success' => true,
            'data' => 'the  ticket deleted  successfully'
        ]);
    }

}
