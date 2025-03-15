<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Console;
use App\Libraries\Midtrans;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;

class paymentController extends Controller
{
    public function listRental()
    {
        $rental = Rental::all();
        $console = Console::all();
        return view('list', compact('console', 'rental'));
    }

    public function halPayment($id)
    {
        $console = Console::findOrFail($id);
        return view('booking.transaksi', compact('console'));
    }

    public function paymentStore(Request $request, $id)
    {
        // echo $id;
        $request->validate([
            'tgl_booking' => 'required',
            'waktu_booking' => 'required',
            'phone' => 'required',
            'sesi' => 'required',
        ]);

        $console = Console::findOrFail($id);

        $orderId = 'order-id-' . uniqid();
        $lib = new Midtrans($orderId);
        $tgl_booking = Carbon::parse($request->tgl_booking . ' ' . $request->waktu_booking . ':00');

        $price = $console->price * $request->sesi;
        // Tambahan biaya jika weekend
        if (in_array(date('l', strtotime($tgl_booking)), ['Saturday', 'Sunday'])) {
            $price += 50000;
        }
        // echo date('l', strtotime($tgl_booking));
        // dd($price);
        try {
            if ($tgl_booking->lt(now()->setTimezone('Asia/Jakarta'))) {
                return redirect()->back()->with('error', 'Silakan isi kembali karena tanggal dan waktu booking harus pada hari ini atau hari berikutnya.');
            } else {
                // echo Carbon::today()->setTime(now()->hour, now()->minute, now()->second) . '<br>';
                // echo $tgl_booking;
                // die;
                $getData = [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => $request->phone,
                ];
                $response = $lib->payment($getData, $price);

                $rental = Rental::create([
                    'user_id' => Auth::id(),
                    'console_id' => $id,
                    'booking_date' => $request->tgl_booking . ' ' . $request->waktu_booking,
                    'sesi' => $request->sesi,
                    'price' => $price,
                    'token' => $response,
                    'status' => 'notpaid',
                ]);
                return redirect()->route('halPayout', ['token' => $response])->with('success', 'Booking berhasil. Silakan lakukan pembayaran.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function halTransaksi($token)
    {
        return view('booking.payment', compact('token'));
    }

    public function simulasi($token)
    {
        Rental::where('token', $token)->update([
            'status' => 'paid'
        ]);
        return redirect()->route('booking')->with('success', 'Pembayaran berhasil diproses.');
    }

    public function reservasi()
    {
        $rental = Rental::where('user_id', Auth::id())->where('status', 'notpaid')->get();
        return view('reservasi.index', compact('rental'));
    }

    public function booking()
    {
        $rental = Rental::where('user_id', Auth::id())->where('status', 'paid')->where('booking_date', '>', now()->setTimezone('Asia/Jakarta'))->get();
        return view('reservasi.booking', compact('rental'));
    }

    public function history()
    {
        $rental = Rental::where('user_id', Auth::id())->where('status', 'paid')->where('booking_date', '<', now()->setTimezone('Asia/Jakarta'))->get();
        return view('reservasi.history', compact('rental'));
    }
}
