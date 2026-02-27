<?php

namespace App\Services;

use App\DTOS\CreateInvoiceDTO;
use App\DTOS\RecordPaymentDTO;
use App\Enums\ContractStatusEnum;
use App\Enums\InvoiceStatusEnum;
use App\Models\Invoice;
use App\Models\Payment;
use App\Repositories\Contracts\ContractRepositoryInterface;
use App\Repositories\Invoices\InvoiceRepositoryInterface;
use App\Repositories\Payments\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private PaymentRepositoryInterface $paymentRepo,
        private TaxService $taxService
    ) {}
    public function createInvoice(CreateInvoiceDTO $dto): Invoice
    {
        try {
            return DB::transaction(function () use ($dto) {
                $contract = $this->contractRepo->findById($dto->contract_id);
                if (!$contract) {
                    throw new \Exception("Contract not found");
                }

                if ($contract->status !== ContractStatusEnum::ACTIVE) {
                    throw new \Exception("Contract must be active");
                }

                $amount = $contract->rent_amount;
                $taxAmount = $this->taxService->calculateTax($amount);
                $totalAmount = $amount + $taxAmount;

                return $this->invoiceRepo->create([
                    'contract_id' => $dto->contract_id,
                    'tenant_id' => $dto->tenant_id,
                    'subtotal' => $amount,
                    'tax_amount' => $taxAmount,
                    'total' => $totalAmount,
                    'due_date' => $dto->due_date,
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception("Failed to create invoice: " . $e->getMessage());
        }
    }
    public function recordPayment(RecordPaymentDTO $dto): Payment
    {
        try {
            return DB::transaction(function () use ($dto) {
                $invoice = $this->invoiceRepo->findById($dto->invoice_id);
                if (!$invoice) {
                    throw new \Exception("Invoice not found");
                }
                $total_paid = $this->paymentRepo->getByInvoiceId($dto->invoice_id)->sum('amount');
                $remaining = $invoice->total - $total_paid;

                if ($dto->amount > $remaining) {
                    throw new \Exception("Payment amount exceeds remaining balance");
                }

                $payment = $this->paymentRepo->create([
                    'invoice_id' => $dto->invoice_id,
                    'amount' => $dto->amount,
                    'payment_method' => $dto->payment_method,
                    'reference_number' => $dto->reference_number,
                    'paid_at' => now(),
                ]);

                $total_paid = $this->paymentRepo->getByInvoiceId($dto->invoice_id)->sum('amount');
                $remaining = $invoice->total - $total_paid;
                $invoiceStatus = $remaining == 0 ? InvoiceStatusEnum::PAID : InvoiceStatusEnum::PARTIALLY_PAID;
                $this->invoiceRepo->update($invoice, ['status' => $invoiceStatus]);
                return $payment;
            });
        } catch (\Exception $e) {
            throw new \Exception("Failed to record payment: " . $e->getMessage());
        }
    }

    public function getContractSummary(int $contractId): array
    {
        $invoices = $this->invoiceRepo->getByContractId($contractId);

        $totalInvoiced = $invoices->sum('total');

        $totalPaid = 0;
        foreach ($invoices as $invoice) {
            $totalPaid += $this->paymentRepo->getByInvoiceId($invoice->id)->sum('amount');
        }

        return [
            'contract_id' => $contractId,
            'total_invoiced' => $totalInvoiced,
            'total_paid' => $totalPaid,
            'outstanding_balance' => $totalInvoiced - $totalPaid,
            'invoices_count' => $invoices->count(),
            'latest_invoice_date' => $invoices->max('created_at'), // أو due_date حسب اللي انت ماشي عليه
        ];
    }
}
