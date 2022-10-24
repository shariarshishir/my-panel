<?php

namespace Database\Seeders;

use App\Models\BusinessMappingTree;
use Illuminate\Database\Seeder;

class BusinessMappingTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_layer=[
                [
                    'name' => 'Manufacturer',
                    'parent_id' => null,
                ],
                [
                    'name' => 'Wholesaler',
                    'parent_id' => null,
                ],
                [
                    'name' => 'Design Studio',
                    'parent_id' => null,
                ],
        ];

        $second_layer_manufacturer= ['Garments','HomeTex','Trims and Accessories','Washing','Embroidery','Textile','Spinning','Others'];
        $second_layer_wholesaler= ['Garments','Trims and Accessories','Yarn','Fabric','Others'];
        $second_layer_design_studio= ['Garments','Trims and Accessories','Fabric','Others'];

        $garments_layer=['Jacket','Knit','Lingerie','Others','Suits','Sweater','Woven'];
        $trims_and_accessories=['Trims','Accessories','Trims and Accessories'];
        $home_tex=['Towel','Bed Sheets'];
        $washing=['Washing '];
        $embroidery=['Embroidery'];
        $textile=['Woven','Cut & Sew Knit','Warp Knit','Lining','Others','Leather/Fur'];
        $spinning=['Natural Fibers','Yarn Blends','Speciality Yarns and Textural Effects','Unusual Yarn'];
        $others=['Others'];


        foreach($first_layer as $parent){
            BusinessMappingTree::create(['name' =>strtolower($parent['name']), 'alias' => $this->createAlias($parent['name'])]);
        }
        $get_parent=BusinessMappingTree::get();
        foreach($get_parent as $p){
            if($p->name == 'manufacturer'){
                foreach($second_layer_manufacturer as $manufacturer){
                    BusinessMappingTree::create(['name' => strtolower($manufacturer), 'parent_id' => $p->id, 'alias' => $this->createAlias($manufacturer)]);
                }
            }
            if($p->name == 'wholesaler'){
                foreach($second_layer_wholesaler as $wholesaler){
                    BusinessMappingTree::create(['name' =>strtolower($wholesaler), 'parent_id' => $p->id, 'alias' => $this->createAlias($wholesaler)]);
                }
            }
            if($p->name == 'design studio'){
                foreach($second_layer_design_studio as $design_studio){
                    BusinessMappingTree::create(['name' => strtolower($design_studio), 'parent_id' => $p->id , 'alias' => $this->createAlias($design_studio)]);
                }
            }
        }

        $get_parent=BusinessMappingTree::with('children')->where('parent_id', null)->get();
        foreach($get_parent as $parent){
            foreach($parent->children as $child){
                if($child->name == 'garments'){
                    foreach($garments_layer as $garment){
                        BusinessMappingTree::create(['name' =>strtolower($garment), 'parent_id' => $child->id,'alias' => $this->createAlias($garment)]);
                    }
                }
                if($child->name == 'trims and accessories'){
                    foreach($trims_and_accessories as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
                if($child->name == 'others'){
                    foreach($others as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
                if($parent->name == 'manufacturer' && $child->name == 'hometex' ){
                    foreach($home_tex as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
                if($parent->name == 'manufacturer' && $child->name == 'washing' ){
                    foreach($washing as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
                if($parent->name == 'manufacturer' && $child->name == 'embroidery' ){
                    foreach($embroidery as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
                if($parent->name == 'manufacturer' && $child->name == 'textile' ){
                    foreach($textile as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
                if($parent->name == 'manufacturer' && $child->name == 'spinning' ){
                    foreach($spinning as $item){
                        BusinessMappingTree::create(['name' =>strtolower($item), 'parent_id' => $child->id,'alias' => $this->createAlias($item)]);
                    }
                }
            }
        }


    }



    public function createAlias($name)
    {
        $alias=$this->removeSpecialCharacterFromAlais($name);
        return $this->checkExistsAlias($alias);
    }

    public function checkExistsAlias($alias)
    {
        $check_exists=BusinessMappingTree::where('alias', $alias)->first();
        if($check_exists){
            $create_array= explode('-',$alias);
            $last_key=array_slice($create_array,-1,1);
            $last_key_string=implode(' ',$last_key);
            if(is_numeric($last_key_string)){
                $last_key_string++;
                array_pop($create_array);
                array_push($create_array,$last_key_string);
            }else{
                array_push($create_array,1);
            }
            $alias=implode("-",$create_array);
            return $this->checkExistsAlias($alias);

        }

        return $alias;
    }

    public function removeSpecialCharacterFromAlais($alias)
    {
        $lowercase=strtolower($alias);
        $pattern= '/[^A-Za-z0-9\-]/';
        $preg_replace= preg_replace($pattern, '-', $lowercase);
        $single_hypen= preg_replace('/-+/', '-', $preg_replace);
        $alias= $single_hypen;
        return $alias;
    }
}
