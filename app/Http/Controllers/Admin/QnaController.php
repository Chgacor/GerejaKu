<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qna;
use Illuminate\Http\Request;

class QnaController extends Controller
{
    public function index()
    {
        $qnas = Qna::with('answerer')->latest()->paginate(15);
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
            'is_published' => 'nullable|boolean',
        ]);

        $qna->answer = $validatedData['answer'];
        $qna->is_published = $request->has('is_published');
        $qna->answered_at = now();
        $qna->answered_by = auth()->id();
        $qna->save();

        return redirect()->route('admin.qna.index')->with('success', 'Pertanyaan berhasil dijawab.');
    }

    public function destroy(Qna $qna)
    {
        $qna->delete();
        return redirect()->route('admin.qna.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
