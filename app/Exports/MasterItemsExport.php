<?php 
namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $no = 0;

    public function collection()
    {
        return MasterItem::with('categories')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Item',
            'Nama Supplier',
            'Harga',
            'Laba (%)',
            'Harga Jual'
        ];
    }

    public function map($item): array
    {
        return [
            ++$this->no,
            $item->categories->pluck('nama')->join(', '),
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            $item->harga_beli * (100 + $item->laba) / 100,
        ];
    }
}
