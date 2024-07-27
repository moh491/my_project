<?php

namespace App\Http\Controllers;


use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\RefundRequest;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class StripePaymentController extends Controller
{
    use ApiResponseTrait;

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function confirm(ConfirmRequest $confirmRequest): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $data = $confirmRequest->validated();
            if (!Auth::guard('Project_Owner')->user()) {
                return $this->error('You dont have the authority');
            }
            $session = $this->paymentService->confirm($confirmRequest);
            return $this->success('success',$session->url);
        } catch (\Exception $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function refund(RefundRequest $refundRequest): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $refundRequest->validated();
            $payment = Payment::where('session_id', $data['session_id'])->first();
            $id = Auth::guard('Project_Owner')->user()->id;
            if ($payment->project_owner_id == $id) {
                $refund = $this->paymentService->refund($data, $id);
                return $this->success('refund successfully', $refund);
            }
            return $this->error('You dont have the authority');
        } catch (\Exception $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function successPayment(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $token = $request->query('token');
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 403);
        }
        $user = PersonalAccessToken::findToken($token)->tokenable;
        try {
            $this->paymentService->success($request, $user->id);
            return redirect('http://localhost:5173/projectOwner');

        } catch (\Exception $th) {
            return $this->serverError($th->getMessage());
        }
    }

    public function cancel(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->error("There was a problem ");
    }


}
