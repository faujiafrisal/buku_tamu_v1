<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Bidang;
use App\Models\FormQuestion;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class GuestBookController extends Controller
{
    /**
     * Display the visitor attendance form.
     */
    public function index()
    {
        $bidangs = Bidang::orderBy('id', 'asc')->get();
        $questions = FormQuestion::where('status', 'Aktif')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $boxMap = $questions->whereNotNull('system_key')->keyBy('system_key');
        $customQuestions = $questions->whereNull('system_key');

        return view('guestbook.index', compact('bidangs', 'questions', 'boxMap', 'customQuestions'));
    }

    /**
     * Store a new visitor entry in database.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'usia' => 'required|integer|min:10|max:100',
            'jumlah_rombongan' => 'required|string|max:50',
            'keperluan' => 'required|string|max:1000',
            'no_whatsapp' => 'required|string|max:25',
        ];

        // Validasi pertanyaan kustom aktif (hanya pertanyaan kustom non-sistem)
        $activeQuestions = FormQuestion::where('status', 'Aktif')->whereNull('system_key')->get();
        $customAnswers = [];
        $jawabanInput = $request->input('jawaban', []);

        foreach ($activeQuestions as $q) {
            $val = $jawabanInput[$q->id] ?? null;
            if ($q->wajib) {
                $rules["jawaban.{$q->id}"] = 'required';
            }
            if (!is_null($val) && $val !== '') {
                $customAnswers[] = [
                    'question_id' => $q->id,
                    'pertanyaan' => $q->pertanyaan,
                    'tipe_input' => $q->tipe_input,
                    'jawaban' => $val,
                ];
            }
        }

        $validated = $request->validate($rules, [
            'jawaban.*.required' => 'Pertanyaan wajib harus diisi.',
        ]);

        $guest = Guest::create([
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'usia' => $validated['usia'],
            'jumlah_rombongan' => $validated['jumlah_rombongan'],
            'bidang_tujuan' => $request->input('bidang_tujuan', $validated['keperluan']),
            'keperluan' => $validated['keperluan'],
            'no_whatsapp' => $validated['no_whatsapp'],
            'jawaban_tambahan' => !empty($customAnswers) ? $customAnswers : null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data presensi berhasil disimpan secara resmi!',
                'data' => $guest
            ]);
        }

        return redirect()->back()->with('success', 'Data presensi berhasil disimpan secara resmi!');
    }

    /**
     * Display admin guestbook recap dashboard.
     */
    public function admin()
    {
        $todayCount = Guest::whereDate('created_at', Carbon::today())->count();
        $totalCount = Guest::count();
        $maleCount = Guest::where('jenis_kelamin', 'Laki-Laki')->count();
        $femaleCount = Guest::where('jenis_kelamin', 'Perempuan')->count();

        // Group stats by Bidang Tujuan
        $bidangStats = Guest::select('bidang_tujuan', DB::raw('count(*) as total'))
            ->whereNotNull('bidang_tujuan')
            ->groupBy('bidang_tujuan')
            ->orderByDesc('total')
            ->get();

        // Group stats by Keperluan
        $keperluanStats = Guest::select('keperluan', DB::raw('count(*) as total'))
            ->whereNotNull('keperluan')
            ->groupBy('keperluan')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $topBidang = $bidangStats->first() ? $bidangStats->first()->bidang_tujuan : '-';
        $topKeperluan = $keperluanStats->first() ? $keperluanStats->first()->keperluan : '-';

        // 5 Kunjungan Terbaru untuk Widget Dashboard
        $recentGuests = Guest::latest()->take(5)->get();

        return view('guestbook.admin', compact(
            'todayCount',
            'totalCount',
            'maleCount',
            'femaleCount',
            'bidangStats',
            'keperluanStats',
            'topBidang',
            'topKeperluan',
            'recentGuests'
        ));
    }

    /**
     * Display full visit history with search and pagination.
     */
    public function history(Request $request)
    {
        $query = Guest::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%")
                  ->orWhere('bidang_tujuan', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $guests = $query->latest()->paginate(15)->withQueryString();

        $todayCount = Guest::whereDate('created_at', Carbon::today())->count();
        $totalCount = Guest::count();

        return view('guestbook.history', compact('guests', 'todayCount', 'totalCount'));
    }

    /**
     * Delete a visitor entry from database.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data kunjungan berhasil dihapus!'
            ]);
        }

        return redirect()->back()->with('success', 'Data kunjungan berhasil dihapus secara resmi!');
    }

    /**
     * Display dynamic form option management for Bidang.
     */
    public function manageBidang()
    {
        $bidangs = Bidang::orderBy('id', 'asc')->get();
        return view('guestbook.manage_bidang', compact('bidangs'));
    }

    /**
     * Store new Bidang option in database.
     */
    public function storeBidang(Request $request)
    {
        $validated = $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidangs,nama_bidang'
        ], [
            'nama_bidang.required' => 'Nama bidang wajib diisi.',
            'nama_bidang.unique' => 'Opsi bidang ini sudah ada.'
        ]);

        Bidang::create($validated);

        return redirect()->back()->with('success', 'Opsi Bidang baru berhasil ditambahkan!');
    }

    /**
     * Update Bidang option in database.
     */
    public function updateBidang(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:bidangs,nama_bidang,' . $bidang->id
        ], [
            'nama_bidang.required' => 'Nama bidang wajib diisi.',
            'nama_bidang.unique' => 'Opsi bidang ini sudah ada.'
        ]);

        $bidang->update($validated);

        return redirect()->back()->with('success', 'Opsi Bidang berhasil diperbarui!');
    }

    /**
     * Delete Bidang option from database.
     */
    public function destroyBidang(Bidang $bidang)
    {
        $bidang->delete();

        return redirect()->back()->with('success', 'Opsi Bidang berhasil dihapus!');
    }

    /**
     * Display custom form questions management.
     */
    public function manageQuestions()
    {
        $questions = FormQuestion::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return view('guestbook.manage_questions', compact('questions'));
    }

    /**
     * Store new form question in database.
     */
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'tipe_input' => 'required|in:text,textarea,select,number,radio',
            'opsi' => 'nullable|string|max:2000',
            'opsi_items' => 'nullable|array',
            'wajib' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:1|max:99',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'pertanyaan.required' => 'Judul box / teks pertanyaan wajib diisi.',
            'tipe_input.required' => 'Pilih tipe input pertanyaan.',
        ]);

        if ($request->has('opsi_items') && is_array($request->opsi_items)) {
            $filtered = array_values(array_filter(array_map('trim', $request->opsi_items)));
            $validated['opsi'] = implode("\n", $filtered);
        }

        $validated['wajib'] = $request->has('wajib') ? true : false;
        $validated['urutan'] = $validated['urutan'] ?? (FormQuestion::max('urutan') + 1);

        FormQuestion::create($validated);

        return redirect()->back()->with('success', 'Box formulir baru berhasil ditambahkan!');
    }

    /**
     * Update form question in database.
     */
    public function updateQuestion(Request $request, FormQuestion $question)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'tipe_input' => 'required|in:text,textarea,select,number,radio',
            'opsi' => 'nullable|string|max:2000',
            'opsi_items' => 'nullable|array',
            'wajib' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:1|max:99',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'pertanyaan.required' => 'Judul box / teks pertanyaan wajib diisi.',
            'tipe_input.required' => 'Pilih tipe input pertanyaan.',
        ]);

        if ($request->has('opsi_items') && is_array($request->opsi_items)) {
            $filtered = array_values(array_filter(array_map('trim', $request->opsi_items)));
            $validated['opsi'] = implode("\n", $filtered);
        }

        $validated['wajib'] = $request->has('wajib') ? true : false;
        $validated['urutan'] = $validated['urutan'] ?? $question->urutan;

        $question->update($validated);

        return redirect()->back()->with('success', 'Box formulir berhasil diperbarui!');
    }

    /**
     * Delete form question from database.
     */
    public function destroyQuestion(FormQuestion $question)
    {
        if ($question->system_key) {
            return redirect()->back()->with('error', 'Box bawaan sistem tidak dapat dihapus, namun judul dan opsinya dapat Anda edit.');
        }

        $question->delete();

        return redirect()->back()->with('success', 'Box formulir berhasil dihapus!');
    }
}



