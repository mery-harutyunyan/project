<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Paypal;
use Redirect;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use App\Http\Requests;

use Illuminate\Support\Facades\Session;

class PaypalController extends Controller
{
    private $_apiContext;

    public function __construct()
    {
        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));

    }


    public function getCheckout(Request $request)
    {

        $productId = $request->product;

        $productData = Products::findOrFail($productId);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName($productData->name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku($productData->id)// Similar to `item_number` in Classic API
            ->setPrice($productData->price);


        $itemList = new ItemList();
        $itemList->setItems(array($item1));


        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($productData->price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());


        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(action('PaypalController@getDone'));
        $redirectUrls->setCancelUrl(action('PaypalController@getCancel'));


        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        $request = clone $payment;

        try {
            $payment->create($this->_apiContext);
        } catch (Exception $ex) {

            ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
            exit(1);
        }

        $approvalUrl = $payment->getApprovalLink();

        return Redirect::to($approvalUrl);


    }

    public function getDone(Request $request)
    {

        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        $this->saveTransactionData($executePayment);


        // Clear the shopping cart, write to database, send notifications, etc.

        // Thank the user for the purchase
        return view('paypal.done');
    }

    public function getCancel()
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        return view('paypal.cancel');

    }

    /**
     * @return mixed
     */
    public function saveTransactionData($executePayment)
    {
        $save = Transactions::create(array(
            'transaction_id' => $executePayment->id,
            'state' => $executePayment->state,
            'payment_method' => $executePayment->payer->payment_method,
            'amount' => $executePayment->transactions[0]->amount->total,
            'invoice_number' => $executePayment->transactions[0]->invoice_number,
            'payer_id' => $executePayment->payer->payer_info->payer_id,
            'payer_email' => $executePayment->payer->payer_info->email,
            'payer_first_name' => $executePayment->payer->payer_info->first_name,
            'payer_last_name' => $executePayment->payer->payer_info->last_name,
            'payer_shipping_address' => $executePayment->payer->payer_info->shipping_address->line1 . ', '
                . $executePayment->payer->payer_info->shipping_address->line1 . ', '
                . $executePayment->payer->payer_info->shipping_address->city . ', '
                . $executePayment->payer->payer_info->shipping_address->state . ', '
                . $executePayment->payer->payer_info->shipping_address->postal_code . ', '
                . $executePayment->payer->payer_info->shipping_address->country_code,

            'payer_billing_address' => $executePayment->payer->payer_info->shipping_address->line1 . ', '
                . $executePayment->payer->payer_info->shipping_address->line1 . ', '
                . $executePayment->payer->payer_info->shipping_address->city . ', '
                . $executePayment->payer->payer_info->shipping_address->state . ', '
                . $executePayment->payer->payer_info->shipping_address->postal_code . ', '
                . $executePayment->payer->payer_info->shipping_address->country_code,
        ));


    }
}