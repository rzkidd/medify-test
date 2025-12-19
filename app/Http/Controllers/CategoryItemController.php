<?php

namespace App\Http\Controllers;

use App\Models\CategoryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CategoryItemController extends Controller
{
    public function index()
    {
        return view('category_items.index.index');
    }

    public function search(Request $request)
    {
        $kode     = $request->kode;
        $nama     = $request->nama;

        $data_search = CategoryItem::query();

        if (!empty($kode))
            $data_search = $data_search->where('kode', $kode);
        if (!empty($nama))
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('kode', 'nama')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = CategoryItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('category_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = CategoryItem::where('kode', $kode)->first();
        return view('category_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new CategoryItem();
            $kode = CategoryItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = CategoryItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->kode = $kode;

        $data_item->save();

        return redirect('category-items');
    }

    public function delete($id)
    {
        $item = CategoryItem::find($id);
        $item->delete();
        return redirect('category-items');
    }

    public function print($id)
    {
        $data = CategoryItem::find($id);

        $pdf = Pdf::loadView('category_items.print.index', compact('data'))
                  ->setPaper('A4', 'portrait');

        // preview di browser
        return $pdf->stream('category-items.pdf');
    }
}
