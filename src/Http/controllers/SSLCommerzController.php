<?php

namespace SamAsif\Sslcommerz\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SAM\SSLCommerz\Library\SslCommerz\SamSSL;

class SSLCommerzController extends Controller
{
    private $returnUrl;

    public function __construct()
    {
        $this->config = config('sslcommerz');
        $this->returnUrl=$this->config['return_url'];
    }

    public function index($request,$type)
    {
        if($type=='hosted'){
         return   $this->hosted($request);
        }
        else if($type=='ajax'){
          return  $this->payViaAjax($request);
        }else{
            return redirect()->to('/');
        }
        
    }


    public function hosted($request)
    {


        $post_data = array();
        $post_data['total_amount'] = $request['total_amount']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $request['tran_id']; // tran_id must be unique
        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request['cus_name'];
        $post_data['cus_email'] = $request['cus_email'];
        $post_data['cus_add1'] = $request['cus_add1'];
        $post_data['cus_add2'] = $request['cus_add2'];
        $post_data['cus_city'] = $request['cus_city'];
        $post_data['cus_state'] = $request['cus_state'];
        $post_data['cus_postcode'] = $request['cus_postcode'];
        $post_data['cus_country'] = $request['cus_country'];
        $post_data['cus_phone'] = $request['cus_phone'];
        $post_data['cus_fax'] = $request['cus_fax'];

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $request['ship_name'];
        $post_data['ship_add1'] = $request['ship_add1'];
        $post_data['ship_add2'] = $request['ship_add2'];
        $post_data['ship_city'] = $request['ship_city'];
        $post_data['ship_state'] = $request['ship_state'];
        $post_data['ship_postcode'] = $request['ship_postcode'];
        $post_data['ship_phone'] = $request['ship_phone'];
        $post_data['ship_country'] = $request['ship_country'];

        $post_data['shipping_method'] = $request['shipping_method'];
        $post_data['product_name'] = $request['product_name'];
        $post_data['product_category'] = $request['product_category'];
        $post_data['product_profile'] = $request['product_profile'];

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $request['value_a'];
        $post_data['value_b'] = $request['value_b'];
        $post_data['value_c'] = $request['value_c'];
        $post_data['value_d'] = $request['value_d'];

       

        $sslc = new SamSSL();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax($request)
    {


      $post_data = array();
        $post_data['total_amount'] = $request->total_amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $request->tran_id; // tran_id must be unique
        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->cus_name;
        $post_data['cus_email'] = $request->cus_email;
        $post_data['cus_add1'] = $request->cus_add1;
        $post_data['cus_add2'] = $request->cus_add2;
        $post_data['cus_city'] = $request->cus_city;
        $post_data['cus_state'] = $request->cus_state;
        $post_data['cus_postcode'] = $request->cus_postcode;
        $post_data['cus_country'] = $request->cus_country;
        $post_data['cus_phone'] = $request->cus_phone;
        $post_data['cus_fax'] = $request->cus_fax;

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $request->ship_name;
        $post_data['ship_add1'] = $request->ship_add1;
        $post_data['ship_add2'] = $request->ship_add2;
        $post_data['ship_city'] = $request->ship_city;
        $post_data['ship_state'] = $request->ship_state;
        $post_data['ship_postcode'] = $request->ship_postcode;
        $post_data['ship_phone'] = $request->ship_phone;
        $post_data['ship_country'] = $request->ship_country;

        $post_data['shipping_method'] = $request->shipping_method;
        $post_data['product_name'] = $request->product_name;
        $post_data['product_category'] = $request->product_category;
        $post_data['product_profile'] = $request->product_profile;

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $request->value_a;
        $post_data['value_b'] = $request->value_b;
        $post_data['value_c'] = $request->value_c;
        $post_data['value_d'] = $request->value_d;

        $sslc = new SamSSL();

        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SamSSL();

            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {

                
                $result=$request->all();
                $message='Transaction is Successful';
                $status=1;
                $route=$this->returnUrl;
                return view('sslcommerz::index',compact('result','message','status','route'));

            } else {
                 
                $result=$request->all();
                $message='Validation Fail';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));

               

            }

                $result=$request->all();
                $message='Something Wrong';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));

       


    }

    public function fail(Request $request)
    {
        

                $result=$request->all();
                $message='Transaction is Fail';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));


    }

    public function cancel(Request $request)
    {
        
                $result=$request->all();
                $message='Transaction is Fail';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));



    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

          echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SamSSL();

            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {

                
                $result=$request->all();
                $message='Transaction is Successful';
                $status=1;
                $route=$this->returnUrl;
                return view('sslcommerz::index',compact('result','message','status','route'));

            } else {
                 
                $result=$request->all();
                $message='Validation Fail';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));
               

            }

             
                $result=$request->all();
                $message='Something Wrong';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));

        } else {
              
                $result=$request->all();
                $message='Something Wrong';
                $status=0;
                $route=$this->returnUrl;

                return view('sslcommerz::index',compact('result','message','status','route'));

        }
    }
   
}
