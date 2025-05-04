<?php

namespace App\Events\Admin;

use App\Models\Expense;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssociationExpenseRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Expense $expense;

    /**
     * Create a new event instance.
     *
     * @param Expense $expense
     * @return void
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('association-expense-request-admin');
    }
}
