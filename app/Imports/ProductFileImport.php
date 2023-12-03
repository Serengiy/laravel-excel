<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductFileImport implements ToCollection, WithHeadingRow, WithStartRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            Product::query()->updateOrCreate([
              'article' => $row['artikul']
            ],[
                'article' => $row['artikul'],
                'name' => $row['nomenklatura'],
                'unit' => $row['ed_izm'],
                'quantity' => $row['kol'],
                'price' => $row['cena_za_st'],
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

}
