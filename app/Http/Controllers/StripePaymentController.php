<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use App\Services\PaymentService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    use ApiResponseTrait;

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function confirm(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            if (!Auth::guard('Project_Owner')->user()) {
                return $this->error('You dont have the authority');
            }
            $session = $this->paymentService->confirm($request);
            return redirect($session->url);
        } catch (\Exception $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function refund(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $payment = Payment::where('session_id', $request->session_id)->first();
            $id = Auth::guard('Project_Owner')->user()->id;
            if ($payment->project_owner_id == $id) {
                $refund = $this->paymentService->refund($request, $id);
                return $this->success('refund successfully', $refund);
            }
            return $this->error('You dont have the authority');
        } catch (\Exception $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function successPayment(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $id = Auth::guard('Project_Owner')->user()->id;
            $this->paymentService->success($request, $id);
            return $this->success('payment successfully');

        } catch (\Exception $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function cancel(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->error("There was a problem ");
    }


}
