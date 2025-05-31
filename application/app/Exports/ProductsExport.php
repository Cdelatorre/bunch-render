<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select('id', 'title', 'email', 'phone', 'website', 'social_link', 'latitude', 'longitude', 'formatted_address', 'created_at')->where('status', 1)->get();
    }

    /**
     * Define column headings.
     */
    public function headings(): array
    {
        return ['ID', 'Title', 'Email', 'Phone', 'Website', 'Social Link', 'Latitude', 'Longitude', 'Address', 'Created Date'];
    }
}