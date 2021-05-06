<?php

namespace App\Imports;

use App\MasterDocument;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class DocumentImport implements ToModel, WithHeadingRow, WithStartRow
{
    public $vendorId;

    public function __construct($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        HeadingRowFormatter::default('slug');
       
    }
    // public function headingRow(): int
    // {
    //     return 1;
    // }
      /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

}
