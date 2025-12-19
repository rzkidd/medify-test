<?php

namespace App\Http\Controllers;

use App\Models\CategoryItem;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode     = $request->kode;
        $nama     = $request->nama;
        $hargamin = intval($request->hargamin);
        $hargamax = intval($request->hargamax);
        
        // dd($hargamin, $hargamax);

        $data_search = MasterItem::query();

        if (!empty($kode))
            $data_search = $data_search->where('kode', $kode);
        if (!empty($nama))
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        if (!empty($hargamin))
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        if (!empty($hargamax))
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);

        $data_search = $data_search->leftJoin('category_items', 'category_items.id', '=', 'master_items.category_id')->select('master_items.kode', 'master_items.nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'foto', 'category_items.nama as kategori')->orderBy('master_items.id')->get();


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
            $item = MasterItem::find($id);
        }
        $data['item']       = $item;
        $data['method']     = $method;
        $data['categories'] = CategoryItem::all();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        if ($method == 'edit' && $request->hasFile('foto')) {
            Storage::delete($data_item->foto);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'foto-item/' . $filename;

            $path = $file->storeAs('public', $filePath);
            $data_item->foto = $path;
        }

        $data_item->nama       = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba       = $request->laba;
        $data_item->kode       = $kode;
        $data_item->supplier   = $request->supplier;
        $data_item->jenis      = $request->jenis;
        $data_item->category_id = $request->category;

        $data_item->save();

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::find($id);
        Storage::delete($item->foto);
        $item->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
