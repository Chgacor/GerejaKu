<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qna;
use Illuminate\Http\Request;

class QnaController extends Controller
{
    public function index()
    {
        // with('answerer') akan mencari fungsi answerer() di model Qna
        // with('user') akan mencari fungsi user() di model Qna (info penanya)
        $qnas = Qna::with(['answerer', 'user'])->latest()->paginate(15);

        return view('admin.qna.index', compact('qnas'));
    }

    public function edit(Qna $qna)
    {
        return view('admin.qna.edit', compact('qna'));
    }

    public function update(Request $request, Qna $qna)
    {
        $validatedData = $request->validate([
            'answer' => 'required|string',
            'is_published' => 'nullable', // ubah boolean jadi nullable agar tidak error saat checkbox kosong
        ]);

        $qna->answer = $validatedData['answer'];
        // Checkbox: jika dicentang kirim 'on'/'1', jika tidak tidak terkirim.
        // Gunakan $request->has() atau boolean()
        $qna->is_published = $request->has('is_published') || $request->input('is_published') == '1';

        // Simpan waktu dan ID admin yang menjawab
        $qna->answered_at = now();
        $qna->answered_by = auth()->id(); // Ini ID User (Admin)

        $qna->save();

        return redirect()->route('admin.qna.index')->with('success', 'Pertanyaan berhasil dijawab.');
    }

    public function destroy(Qna $qna)
    {
        $qna->delete();
        return redirect()->route('admin.qna.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
