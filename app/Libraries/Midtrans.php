<?php

namespace App\Libraries;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\CoreApi;

class Midtrans
{
    protected $orderId;
    public function __construct($orderId)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        $this->orderId = $orderId;
    }

    public function payment($dataUser, $mount)
    {

        // Data transaksi
        $transactionDetails = [
            'order_id' => $this->orderId,
            'gross_amount' => $mount, // Sesuaikan dengan harga produk
        ];

        // $customerDetails = [
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'email' => 'johndoe@example.com',
        //     'phone' => '08123456789',
        // ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $dataUser,
        ];

        $snapToken = Snap::getSnapToken($transaction);
        return $snapToken;
    }

    public function createVApayment($bank, $dataUser, $amount)
    {
        // $customerDetails = [
        //     'first_name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        // ];
        $params = [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'order_id' => $this->orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => $dataUser,
            'bank_transfer' => [
                'bank' => $bank, // "bca", "bni", atau "bri"
            ],
        ];

        try {
            $response = CoreApi::charge($params);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createEWalletPayment($type, $dataUser, $amount)
    {
        // $customerDetails = [
        //     'first_name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        // ];
        $params = [
            'payment_type' => $type, // Bisa diganti "shopeepay" atau "qris"
            'transaction_details' => [
                'order_id' =>  $this->orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => $dataUser,
        ];

        try {
            $response = CoreApi::charge($params);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
