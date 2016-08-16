<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;
use App\Models\Cart;

use Illuminate\Http\Request;
use Paypal;
use Redirect;

use Auth;
use App\Http\Requests;

use Illuminate\Support\Facades\Session;

class PaypalController extends Controller
{
    private $_apiContext;

    public function __construct()
    {
        $this->middleware('auth');

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
        $items = array();
        foreach ($request->data as $itemKey => $item) {
            if (isset($item['agree']) && $item['agree'] == 1) {
                $items[$itemKey] = $item['cart_count'];
            }
        }

        if (empty($items)) {
            Session::flash('note.error', 'Please check items');
            return back();
        }

        $payer = PayPal::Payer();
        $payer->setPaymentMethod("paypal");


        $paymentItems = array();
        $totalPrice = 0;
        foreach ($items as $itemId => $item) {
            $productData = Products::findOrFail($itemId);
            $productPrice = round($productData->price * (1 - ($productData->discount / 100)), 1, PHP_ROUND_HALF_UP);

            $var = 'item' . $itemId;
            // set item data
            $$var = PayPal::Item();
            $$var->setName($productData->name)
                ->setCurrency('USD')
                ->setQuantity((int)$item)
                ->setSku($productData->id)
                ->setPrice($productPrice);

            $totalPrice += $productPrice * $item;
            $paymentItems[] = $$var;
        }


        $itemList = PayPal::ItemList();
        $itemList->setItems($paymentItems);


        $amount = PayPal::Amount();
        $amount->setCurrency("USD")
            ->setTotal($totalPrice);

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = PayPal::RedirectUrls();
        $redirectUrls->setReturnUrl(action('PaypalController@getDone', ['items' => $items]));
        $redirectUrls->setCancelUrl(action('PaypalController@getCancel'));


        $payment = PayPal::Payment();
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


        $items = $request->get('items');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        $this->saveTransactionData($executePayment, $items);


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
    public function saveTransactionData($executePayment, $items)
    {

        foreach ($items as $productId => $productCount) {
            $save = Transactions::create(array(
                'user_id' => Auth::user()->id,
                'product_id' => $productId,
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

                'payer_billing_address' => $executePayment->payer->payer_info->billing_address->line1 . ', '
                    . $executePayment->payer->payer_info->billing_address->line1 . ', '
                    . $executePayment->payer->payer_info->billing_address->city . ', '
                    . $executePayment->payer->payer_info->billing_address->state . ', '
                    . $executePayment->payer->payer_info->billing_address->postal_code . ', '
                    . $executePayment->payer->payer_info->billing_address->country_code,
            ));


            $updateProductCount = Products::where('id', $productId)->decrement('count', $productCount);

            $deleteFromCart = Cart::where('product_id', $productId)
                ->where('user_id', Auth::user()->id)
                ->delete();
        }


    }
}
