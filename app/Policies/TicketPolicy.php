<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Ticket $ticket)
    {
        return $user->is($ticket->user);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->is($ticket->user);
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->is($ticket->user);
    }
}
