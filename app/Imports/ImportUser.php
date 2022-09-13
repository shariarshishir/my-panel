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

class ImportUser implements
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
        foreach ($rows as $row)
        {

            $user_id = IdGenerator::generate(['table' => 'users', 'field' => 'user_id','reset_on_prefix_change' =>true,'length' => 18, 'prefix' => date('ymd').time()]);
            $user= User::create([
                'user_id' => $user_id,
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password'],
                'phone'   => $row['phone'],
                'user_type' => 'buyer',
                'company_name' => $row['company_name'] ?? $row['name'],
                'is_email_verified' => 1,
                'sso_reference_id'  => $row['sso_reference_id'],
            ]);
            //create business profile
            $business_profile=BusinessProfile::create([
                'user_id' => $user->id,
                'business_name' => $row['business_name'] ?? $user->name,
                'location'   => $row['location'],
                'business_type' => 1,
                'has_representative' => 1,
                'industry_type' => $row['industry_type'],
                'business_category_id' => $row['business_category_id'],
            ]);
            //create company overview
            $name=['annual_revenue','number_of_worker','number_of_female_worker','trade_license_number','year_of_establishment','opertaing_hours','shift_details','main_products'];
            $value=[null,null,null,$row['trade_license'],$row['year_of_establishment'],null,null,$row['main_products']];
            $data=[];
            foreach($name as $key => $value2){
                array_push($data,['name' => $value2, 'value' => $value[$key], 'status' => 0]);
            }
            CompanyOverview::create([
                'business_profile_id' => $business_profile->id,
                'data'        => json_encode($data),
            ]);

            //link business profile id with products
                $productList=Product::where('created_by', $row['created_by'])->get();
                if(count($productList) > 0){
                    foreach($productList as $product){
                        $product->update(['business_profile_id' =>  $business_profile->id]);
                    }
                }

        }
    }

    public function rules(): array
    {
        return[
            '*.email' => ['email', 'unique:users,email']
        ];
    }

    // public function onFailure(Failure ...$failures)
    // {
    //     // Handle the failures how you'd like.
    // }




}
