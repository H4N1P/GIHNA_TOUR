<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pesanans = Pesanan::with('paket')
            ->when($request->search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_pemesan', 'like', "%{$search}%")
                      ->orWhere('invoice', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->tanggal, function ($query, $tanggal) {
                $query->whereDate('tanggal_acara', $tanggal);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pakets = Paket::with(['fasilitas', 'destinasis'])->get();
        return view('admin.pesanan.create', compact('pakets'));
    }

    /**
     * Show the form for creating a custom order.
     */
    public function createCustom()
    {
        $pakets = Paket::with(['fasilitas', 'destinasis'])->get();
        return view('admin.pesanan.create-custom', compact('pakets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_paket'      => 'required|exists:pakets,id',
            'nama_pemesan'  => 'required|string|max:255',
            'no_hp'         => 'required|string|max:20',
            'diskon'        => 'nullable|numeric|min:0|max:100',
            'total_harga'   => 'required|numeric|min:0',
            'tanggal_acara' => 'required|date',
            'jumlah_orang'  => 'required|integer|min:1',
        ]);

        Pesanan::create([
            'id_paket'      => $request->id_paket,
            'nama_pemesan'  => $request->nama_pemesan,
            'no_hp'         => $request->no_hp,
            'diskon'        => $request->diskon ?? 0,
            'total_harga'   => $request->total_harga,
            'jumlah_orang'  => $request->jumlah_orang,
            'tanggal_acara' => $request->tanggal_acara,
            'invoice'       => 'INV-' . strtoupper(uniqid()),
            'status'        => 'pending',
        ]);

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Store a custom order.
     */
    public function storeCustom(Request $request)
    {
        $request->validate([
            'nama_pemesan'     => 'required|string|max:255',
            'no_hp'            => 'required|string|max:20',
            'diskon'           => 'nullable|numeric|min:0|max:100',
            'total_harga'      => 'required|numeric|min:0',
            'tanggal_acara'    => 'required|date',
            'jumlah_orang'     => 'required|integer|min:1',
            'custom_places'    => 'required|array|min:1',
            'custom_places.*'  => 'required|string|max:255',
            'custom_fasilitas' => 'nullable|array',
        ]);

        // Process custom_fasilitas to ensure proper format
        $customFasilitas = null;
        if ($request->has('custom_fasilitas') && is_array($request->custom_fasilitas)) {
            $customFasilitas = array_values($request->custom_fasilitas);
        }

        Pesanan::create([
            'nama_pemesan'     => $request->nama_pemesan,
            'no_hp'            => $request->no_hp,
            'diskon'           => $request->diskon ?? 0,
            'total_harga'      => $request->total_harga,
            'jumlah_orang'     => $request->jumlah_orang,
            'tanggal_acara'    => $request->tanggal_acara,
            'invoice'          => 'INV-' . strtoupper(uniqid()),
            'status'           => 'pending',
            'is_custom'        => true,
            'custom_places'    => $request->custom_places,
            'custom_fasilitas' => $customFasilitas,
        ]);

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan custom berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        $pesanan->load('paket');
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        $id = $pesanan; // Keep $id for view compatibility
        $pakets = Paket::with(['fasilitas', 'destinasis'])->get();
        
        if ($pesanan->is_custom) {
            return view('admin.pesanan.edit-custom', compact('id', 'pakets'));
        }
        
        return view('admin.pesanan.edit', compact('id', 'pakets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $rules = [
            'nama_pemesan'  => 'required|string|max:255',
            'no_hp'         => 'required|string|max:20',
            'diskon'        => 'nullable|numeric|min:0|max:100',
            'total_harga'   => 'required|numeric|min:0',
            'tanggal_acara' => 'required|date',
            'jumlah_orang'  => 'required|integer|min:1',
            'status'        => 'nullable|in:pending,batal,selesai',
        ];

        // If not a custom order, require id_paket
        if (!$pesanan->is_custom) {
            $rules['id_paket'] = 'required|exists:pakets,id';
        }

        $request->validate($rules);

        $updateData = $request->only([
            'nama_pemesan',
            'no_hp',
            'diskon',
            'total_harga',
            'jumlah_orang',
            'tanggal_acara',
            'status',
        ]);

        if (!$pesanan->is_custom) {
            $updateData['id_paket'] = $request->id_paket;
        }

        // Handle custom order updates
        if ($pesanan->is_custom) {
            if ($request->has('custom_places')) {
                $request->validate([
                    'custom_places'    => 'required|array|min:1',
                    'custom_places.*'  => 'required|string|max:255',
                ]);
                $updateData['custom_places'] = $request->custom_places;
            }
            if ($request->has('custom_fasilitas') && is_array($request->custom_fasilitas)) {
                $updateData['custom_fasilitas'] = array_values($request->custom_fasilitas);
            }
        }

        $pesanan->update($updateData);

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
