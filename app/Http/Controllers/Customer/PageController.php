<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Gallery;
use App\Models\Paket;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        try {
            $pakets = Paket::with(['fasilitas', 'destinasis.galleries', 'fotos'])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            $fotos = Gallery::whereNull('id_destinasi')
                ->whereNull('id_fasilitas')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        } catch (QueryException) {
            $pakets = collect();
            $fotos = collect();
        }

        return view('customer.index', compact('pakets', 'fotos'));
    }

    /**
     * Display all packages page.
     */
    public function packages(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        try {
            $pakets = Paket::with(['fasilitas', 'destinasis.galleries', 'fotos'])
                ->when($query !== '', function ($builder) use ($query) {
                    $builder->where('nama_paket', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12)
                ->withQueryString();
        } catch (QueryException) {
            $pakets = new LengthAwarePaginator([], 0, 12);
            $pakets->withPath(route('packages'));
        }

        return view('customer.packages', compact('pakets', 'query'));
    }

    /**
     * Display a specific package detail.
     */
    public function packageDetail($id)
    {
        $paket = Paket::with(['rundowns', 'fasilitas', 'destinasis.galleries', 'fotos'])
            ->findOrFail($id);

        return view('customer.package-detail', compact('paket'));
    }

    /**
     * Display all photos/gallery page.
     */
    public function photos()
    {
        try {
            $fotos = Gallery::whereNull('id_destinasi')
                ->whereNull('id_fasilitas')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } catch (QueryException) {
            $fotos = new LengthAwarePaginator([], 0, 12);
            $fotos->withPath(route('photos'));
        }

        return view('customer.photos', compact('fotos'));
    }

    /**
     * Search packages.
     */
    public function search(Request $request)
    {
        return redirect()->route('packages', ['q' => $request->input('q')]);
    }
}
