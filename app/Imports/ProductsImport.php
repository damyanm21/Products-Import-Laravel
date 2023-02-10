<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Imports\Request;
use Illuminate\Http\Request as HttpRequest;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)

    {
        Validator::make($rows->toArray(), [
            '*.name' => 'required',
             '*.description' => 'required',
             '*.price' => 'required',
             ])->validate();

        $latest = Product::latest()->first();

        foreach ($rows as $row) {
            Product::create([
                'name' => $row['name'],
                'description' => $row['description'],
                'price' => $row['price'],
                'imported' => 0,
                'importid' => ($latest->importid??0)+1,
            ]);
        }
    }
}

