<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Payment as PaymenModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{
    private $apiContext;
    // private $PaymentController;
    private $DemolitionController;
    protected $RentalController;

    public function __construct()
    {

        $clientId = 'ARtMgetNmHc6LzVwWQK5rbq0jgfyST3x9UKljasgm67XP0bkDBQPXp06KuCZeWFN30Y0Pd0EMla7L2EE';
        $clientSecret = 'EOfm4oqTJbz95z9AlObSoKY2Ndp7dBu0o_4bg0WsMMg_DK5IRKXW1NzTYdUUIGxd2LyajTgh-jtJq2o-';

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );

        // $this->apiContext = Paypalpayment::ApiContext($this->clientId, $this->clientSecret);

        $this->DemolitionController = app('App\Http\Controllers\DemolitionController');


    }


    public function index(Request $request)
    {
        $payments = PaymenModel::all();

        return view('payment.index', compact('payments'));

    }

    /*PAYPAL FUNCTIONS*/
    public function create_payment(Request $request)
    {

        /*Create a express-checkout url to authorize the payment*/


        $demolition = $this->DemolitionController->showDemolition($request->demolition_id);
        // dd($demolition);
        if ($demolition != null) {
            $payer = new Payer();
            $payer->setPaymentMethod("paypal");
            if ($request->payment_type == 'payment') {
                $subtotal = $demolition->payment;
                //pago de la demolicion
                $item1 = new Item();
                $item1->setName('Demolition service')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setSku("1")
                    ->setPrice($subtotal);
            } elseif ($request->payment_type == 'deposit') {
                dd($demolition);
                $subtotal = $demolition->deposit;
                //recaudo por servicio de paypal
                $item1 = new Item();
                $item1->setName('Demolition deposit')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setSku("1")
                    ->setPrice($subtotal);
            } else {
                return response()->json('invalid payment_type', 400);
            }
            // dd($demolition->subtotal * $demolition->deposit_percentage);

            $itemList = new ItemList();
            $itemList->setItems(array($item1));

            $details = new Details();
            $details->setShipping(config('demo.paypal_shipping'))
                ->setTax(config('demo.paypal_tax'))
                ->setSubtotal($subtotal);

            $ammount = new Amount();
            // dd(config('demo.paypal_shipping'));
            $ammount->setCurrency("USD")
                ->setTotal($subtotal + config('demo.paypal_shipping') + config('demo.paypal_tax'))
                ->setDetails($details);

            $transaction = new Transaction();
            $transaction->setAmount($ammount)
                ->setItemList($itemList)
                ->setDescription($demolition->description)
                ->setInvoiceNumber(uniqid());
            // dd(config('app.url'));
            /*$baseUrl = Config::get('app.url');*/
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl('http://localhost:8000/api/payment_status?demolition_id=' . $demolition->id . '&type=' . $request->payment_type)
                ->setCancelUrl(config('app.url') . '/api/payment_status?demolition_id=null&type=null');


            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));

            try {
                $payment->create($this->apiContext);//cse crea el pago
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (PayPal\Exception\PPConnectionException $pce) {
                echo '<pre>';
                print_r(json_decode($pce->getData()));
                exit;
            }

            $approvalUrl = $payment->getApprovalLink();

            if ($request->from == 1) {/*if the request provides from web*/
                return $payment;
            } else {/*if the request provides from mobile*/
                return response()->json([
                    'data' => $approvalUrl,
                    'message' => 'Redirect to URL to confirm your payment',
                    'status' => 'success'
                ], 200);
            }

        } else {

            return response()->json('demolition don found', 400);
        }
    }


    public function getPaymentStatus(Request $request)
    {

        // dd($request->demolition_id);
        /** Execute the payment if this provides from approval URL (Android, iOS) **/
        if (empty($request->PayerID) || empty($request->token)) {
            return response()->json([
                'message' => 'Payment failed',
                'status' => 'fail'
            ], 500);
        }
        // dd($request->PayerID);
        $payment = Payment::get($request->paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);
        if ($result->getState() == 'approved') {
            $demolition = $this->DemolitionController->showDemolition($request->demolition_id);

            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $total = $demolition->subtotal;

            if ($request->type == 'payment') {
                $this->store($sale->getId(), $demolition, $demolition->payment, 2, 'approved');
                $this->DemolitionController->change_status($demolition->id, 7);/*Paid Out*/

            } else {
                $this->store($sale->getId(), $demolition, $demolition->deposit, 1, 'approved');
                $this->DemolitionController->change_status($demolition->id, 5);/*Paid Out*/
            }

            return response()->json([
                'data' => $demolition,
                'message' => 'The demolition has been payed successfully',
                'status' => 'success'
            ], 200);
        }
        return response()->json([
            'message' => 'Payment failed',
            'status' => 'fail'
        ], 500);
    }


    public function refund_deposit(Request $request)
    {
        /*Refund to buyer a pending deposit of an invoice*/
        $demolition = $this->DemolitionController->showDemolition($request->demolition_id);
        $deposit = PaymenModel::where('demolition_id', $demolition->id)
            ->where('typePayment_id', 1)
            ->where('status', 'approved')
            ->first();/*if have a approved deposit for the invoice*/

        if ($deposit != null) {
            try {
                $amt = new Amount();
                $amt->setCurrency('USD')
                    ->setTotal($deposit->refund_price);

                $refund = new Refund();
                $refund->setAmount($amt);
                $sale = new Sale();
                $sale->setId($deposit->sale_id);
                /*try {  */
                $refundedSale = $sale->refund($refund, $this->apiContext);

                if ($refundedSale->state == 'completed') {
                    $deposit->status = 'refunded';
                    $deposit->save();

                    return response()->json([
                        'data' => $refundedSale,
                        'message' => 'Deposit refunded successfully'
                    ], 200);

                } else {
                    return response()->json([
                        'message' => 'An error has been occurred, please try again'
                    ], 500);
                }
                /*} catch (PayPal\Exception\PPConnectionException $ex) {
                    error_log($ex->getMessage());
                    error_log(print_r($ex->getData(), true));
                    return;
                }*/
            } catch (PayPal\Exception\PPConnectionException $ex) {
                error_log($ex->getMessage());
                error_log(print_r($ex->getData(), true));
                return;
            }
        } else {
            return response()->json([
                'message' => 'Deposit not found',
                'status' => 'fail'
            ], 404);
        }
    }


    public function store($saleId, $demolition, $total, $type, $status)
    {
        // dd();
        $date = Carbon::now();

        $payment = new PaymenModel();
        $payment->sale_id = $saleId;
        $payment->typePayment_id = $type;
        $payment->mean_payment = 'paypal';
        $payment->total = $total;
        $payment->status = $status;
        $payment->demolition_id = $demolition->id;
        $payment->started_at = $date;
        $payment->end_at = $date->addDays(config('demo.paypal_limit_days'));

        $payment->save();
        // $started_at =

    }
}
