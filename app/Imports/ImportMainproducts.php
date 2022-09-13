<?php

namespace App\Imports;

use App\Models\BusinessProfile;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\CompanyOverview;
use App\Models\Manufacture\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
// use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ImportMainproducts implements
ToCollection,
WithHeadingRow,
WithValidation


{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        // $businessProfilesIdFromCsv = [];
        // foreach ($rows as $row)
        // {
        //     array_push($businessProfilesIdFromCsv, $row['id']);
        //     $company_overview = CompanyOverview::whereIn('business_profile_id',$businessProfilesIdFromCsv)->get()->toArray();
        // }

        // return response()->json(['companyOverview' => $company_overview], 200);

        foreach ($rows as $row)
        {
            BusinessProfile::where('id', $row['id'])->update(['factory_type' => $row['factory_type']]);
        }

    }

    public function rules(): array
    {
        return[
            //'*.email' => ['email', 'unique:users,email']
        ];
    }

    // public function onFailure(Failure ...$failures)
    // {
    //     // Handle the failures how you'd like.
    // }




}
