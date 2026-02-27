<?php

namespace App\Http\Controllers\Api;

use App\DTOS\CreateInvoiceDTO;
use App\DTOS\RecordPaymentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecordPaymentRequest;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\ContractSummaryResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Repositories\Invoices\InvoiceRepositoryInterface;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService,
        private InvoiceRepositoryInterface $invoiceRepo,
        ) {}

    public function index(Request $request, Contract $contract)
    {
        $this->authorize('create', [Invoice::class, $contract]);
        $invoices = $this->invoiceRepo->getByContractId($contract->id);
        return InvoiceResource::collection($invoices);
    }
    public function store(StoreInvoiceRequest $request, Contract $contract)
    {
        $this->authorize('create', [Invoice::class, $contract]);
        $dto = CreateInvoiceDTO::fromRequest($request, $contract);
        $invoice = $this->invoiceService->createInvoice($dto);
        $invoice->load('payments');
        return InvoiceResource::make($invoice)->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        $invoice->load('payments');
        return InvoiceResource::make($invoice)->response()->setStatusCode(Response::HTTP_OK);
    }

    public function recordPayment(RecordPaymentRequest $request, Invoice $invoice)
    {
        $this->authorize('recordPayment', $invoice);
        $dto = RecordPaymentDTO::fromRequest($request);
        $payment = $this->invoiceService->recordPayment($dto);
        $invoice->load('payments');
        return InvoiceResource::make($invoice)->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function summary(Contract $contract)
    {
        $this->authorize('create', [Invoice::class, $contract]);
        $summary = $this->invoiceService->getContractSummary($contract->id);
        return ContractSummaryResource::make($summary)->response()->setStatusCode(Response::HTTP_OK);
    }
}
