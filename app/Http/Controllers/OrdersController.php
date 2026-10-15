<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\order_details;
use App\Models\events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Events::all();
        return view("event.user.index", compact("events"));
    }

    public function admindashboard()
    {
       $orders = orders::with('ordersDetails.event')->latest()->get();

        return view('dashboard', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
    // Validasi agar status yang dikirim HANYA salah satu dari nilai ENUM database
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled'
        ]);
    
        $orders = orders::findOrFail($id); 
        $orders->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $orders->id . ' berhasil diperbarui!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'     => 'required|string|max:255',
            'customer_email'    => 'required|string|min:1',
            'items'             => 'required|array',
            'items.*'           => 'required|integer|min:0',
        ]);

        // Filter item yang kuantitasnya > 0
        $orderItems = array_filter($request->items, fn($qty) => $qty > 0);

        if (empty($orderItems)) {
            return back()->with('error', 'Pilih minimal satu jenis Event');
        }

        DB::beginTransaction();
        try {
            $order = orders::create([
                'customer_name'     => $request->customer_name,
                'customer_email'    => $request->customer_email,
                'total_price'       => 0,
                'status'            => 'Pending'
            ]);

            $totalPrice = 0;

            foreach ($orderItems as $EventId => $quantity) {
                $event = Events::findOrFail($EventId);
                $subtotal = $event->ticket_price * $quantity;
                $totalPrice += $subtotal;

                // Perbaikan: Gunakan orders_detail (sesuai import di atas)
                order_details::create([
                    'order_id' => $order->id,
                    'event_id'  => $event->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
            
            DB::commit();

            return redirect()->route('user.index')->with('success', 'Pesanan tiket berhasil dibuat menggunakan email: ' . $order->customer_email);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orders $orders)
    {
        //
    }
}
