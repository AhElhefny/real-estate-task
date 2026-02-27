<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['contract', 'payments']);
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'total' => $this->total,
            'due_date' => $this->due_date,
            'paid_at' => $this->paid_at ? $this->paid_at->format('Y-m-d') : null,
            'contract' => $this->whenLoaded('contract', [
                'id' => $this->contract?->id,
                'unit_name' => $this->contract?->unit_name,
                'customer_name' => $this->contract?->customer_name,
                'rent_amount' => $this->contract?->rent_amount,
            ], null),
            'remaining_balance' => $this->whenLoaded('payments',$this->calculateRemainingBalance(),null),
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->name
            ],
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }

    private function calculateRemainingBalance(): float
    {
        $total_paid = $this->payments->sum('amount');
        return max(0, $this->total - $total_paid);
    }
}
