<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUser;
use App\Imports\ImportMainproducts;
use App\Models\BusinessMappingTree;
use App\Models\BusinessProfile;
use App\Models\Manufacture\Product as ManufactureProduct;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Support\Str;

use App\Models\Blog;
use App\Models\MetaInformation;

class ImportController extends Controller
{
    public function importView()
    {
        return view('import.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ]);
        $file = $request->file('import_file');

        $import = new ImportUser;
        $import->import($file);

        // $import=Excel::import(new ImportUser, $request->file('import_file') );


        // if ($import->failures()->isNotEmpty()) {
        //     return back()->withFailures($import->failures());
        // }
        return back()->withStatus('Import successfull.');


        // try{

        //     $import=Excel::import(new ImportUser, $request->file('import_file') );
        //     return $import;
        //     return redirect()->back()->with('success', 'file inserted successfully');

        // }catch(\Exception $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
    }

    public function importMainproductsView()
    {
        return view('import.mainproductsindex');
    }

    public function importMainproducts(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ]);
        $file = $request->file('import_file');

        $import = new ImportMainproducts;
        $import->import($file);

        // $import=Excel::import(new ImportUser, $request->file('import_file') );


        // if ($import->failures()->isNotEmpty()) {
        //     return back()->withFailures($import->failures());
        // }
        return back()->withStatus('Import successfull.');


        // try{

        //     $import=Excel::import(new ImportUser, $request->file('import_file') );
        //     return $import;
        //     return redirect()->back()->with('success', 'file inserted successfully');

        // }catch(\Exception $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
    }

    public function generateAlias()
    {
        $profile=BusinessProfile::get();
        //$profile=BusinessProfile::where('alias', NULL)->get();
        foreach($profile as $p){
           $alias= $this->createAlias($p->business_name);
           $p->update(['alias' => $alias]);
        }
        return 'done!';
    }

    public function blogMetaInfoUpdate()
    {
        $blogs = Blog::with('metaInformation')->get();
        foreach($blogs as $blog)
        {
            $blog->update(['meta_title' => $blog->metaInformation['meta_title']]);
            $blog->update(['meta_description' => $blog->metaInformation['meta_description']]);
            $blog->update(['meta_image' => $blog->metaInformation['meta_image']]);
            $blog->update(['meta_type' => $blog->metaInformation['meta_type']]);
            //echo $blog->metaInformation->meta_title;
        }
        return 'Done!';
    }

    public function createAlias($name)
    {
        $lowercase=strtolower($name);
        $pattern= '/[^A-Za-z0-9\-]/';
        $preg_replace= preg_replace($pattern, '-', $lowercase);
        $single_hypen= preg_replace('/-+/', '-', $preg_replace);
        $alias= $single_hypen;
        return $this->checkExistsAlias($alias);
    }

    public function checkExistsAlias($alias)
    {
        $check_exists=BusinessProfile::where('alias', $alias)->first();
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


    public function productTagSet(){

        $shop_product=Product::with('category')->get();
        foreach($shop_product as $p){
            if(isset($p->product_category_id) && !isset($p->product_tag)){
                $product_tag=ProductTag::where('name',strtolower($p->category->name))->first();
                if(!$product_tag){
                    $product_tag=ProductTag::create(['name' => strtolower($p->category->name)]);
                }
                $new_product_tag=[$product_tag->name];
                $p->update(['product_tag' => $new_product_tag ]);
            }
        }

        //manufacturer product
        $mb_product=ManufactureProduct::with('category')->get();
        foreach($mb_product as $p){
            if(isset($p->product_category) && !isset($p->product_tag)){
                $product_tag=ProductTag::where('name',strtolower($p->category->name))->first();
                if(!$product_tag){
                    $product_tag=ProductTag::create(['name' => strtolower($p->category->name)]);
                }
                $new_product_tag=[$product_tag->name];
                $p->update(['product_tag' => $new_product_tag ]);
            }
        }


        return 'done';
    }

    public function productTagMappingWithBusinessMappingTree()
    {

        $BusinessMappingTree=['Jacket','Knit','Lingerie','Others','Suits','Sweater','Woven','Towel','Bed Sheets','Trims','Accessories','Washing','Embroidery','Cut & Sew Knit','Warp Knit','Lining','Leather/Fur','Natural Fibers','Yarn Blends','Speciality Yarns and Textural Effects','Unusual Yarn'];

        $product_tag=['jacket'   => ['Anoraks','Capes','Cloaks','Fur Coats','Jackets','Wind Jackets'],
                      'knit'     =>['Blouses','Caps','Cardigans','Corporate Uniform','Denim','Dress Pant','Flannel Pants','Flannel Shirt','Fleece Jackets','Hooded Sweat Shirt','Jackets','Jeans','Jerseys','Long Pant','Petticoats','Polo Shirts','Pullovers','Pyjamas','Scarfs ','Shirt-Blouses','Shirts','Shorts','Singlets','Skirts Dresses','Sports Wear','Suits','Sweat Shirts','Sweater','Tank Tops','Tops','Track-Suits','Trousers','T-Shirts','Underwear','Vests','Work Wear'],
                      'lingerie' => ['Brassisres','Briefs','Corselettes','Corsets','Garters','Girdles','Inner Wear','Negligee Dressing Gowns','Night Dresses','Night Gowns','Night Pajamas','Night Shirt','Panties','Panty-Girdles','Pantyhose','Slips','Stockings','Swimwear','Tights','Underpants'],
                    //   'others'   => ['Brace','Gloves','Scarves','Veils'],
                      'suits'    => ['Blazers','Bow Ties','Cravats','Over Coats','Suits','Suspenders','Ties','Vests','Waistcoats'],
                      'sweater'  => ['Cardigan','Denim Pant','Mittens And Mitts','Mufflers','Pullover','Scarfs','Shawls','Ski Suits','Sock','Sweater','Vest','Wool Blazers','Wool Jackets','Woolen Caps'],
                      'woven'    =>['Basic 5 Pocket Trouser','Blouses','Bottom','Breeches','Cargo Pant','Cargo Shorts','Divided Skirts','Dresses','Dressing Gowns','Ensembles','Fleece Pullover','Frock','Handkerchiefs','Hoodie','Inner Wear','Jerseys','Laggings','Mantillas','Musk','Overall','Palazzo','Petticoats','Polo Shirts','Pyjamas','Shirts','Shorts','Skirts','Sleepwear','Top ','Track-Suits','Trousers'],
                      'towel'    =>['Wash Cloth','Fingertip Towel','Hand Towel','Bath Towel','Bath Sheets','Face Towel','Kitchen Towel','Spa Towel','Gym Towel','Beach Towel','Pet Towel','Foot Towel','Paper Towel','Tea Towel'],
                      'bed sheets' =>['Cotton Bed Sheets','Synthetic Flannel Bed Sheets','Tencel Bed Sheets','Silk Bed Sheets','Bamboo Bed Sheets','Microfiber Bed Sheets','Linen Bed Sheets'],
                      'trims'     =>['Sewing Thread','Button','Rivet','Lining','Interlining','Stopper','Lace','Braid','Elastic','Label','Zipper','Motif','Shoulder Pad','Hook & Loop','Twill Tape','Velcro Tape','Pon Pom','Wadding','Ribbon'],
                      'accessories' =>['Hanger','Hangtag','Tissu Paper','Backboard','Neck Board','Paper Band','Pin/Clip','Tag Pin','Poly Bag','Elastic Bag','Mini Poly Bag','Collar Stand','Gum Tape','Scotch Tape','P.P Band','Inner Carton','Outer Carton','Iron Seal','Trapaulin Paper','Carton Sticker','Safety Sticker','Arrow Sticker','Butterfly','Both Side Tape','Plastic Staple','Barcode'],
                    //   'washing' =>['Normal Wash','Pigment Wash','Bleach Wash','Stone Wash','Acid Wash','Enzyme Wash','Sand Blasting','Super White Wash','Caustic Wash'],
                    //   'embroidery' => ['Whitework embroidery','Candlewick embroidery','Cross stitch embroidery','Pulled thread embroidery','Hedebo embroidery','Drawn thread embroidery','Hardanger embroidery','Crewel embroidery','Surface embroidery','Goldwork embroidery','Redwork embroidery','Blackwork embroidery','Bluework embroidery','Sashiko embroider'],
                      'cut & sew knit' => ['Crepe Jersey','Dobby/Jacquard','Double Knit/Interlock','Fleece','French Terry','Jersey','Loop Terry','Neoprene/Scuba','Pique','Pointelle','Polar Fleece','Ponte','Rib','Sherpa','Velour','Waffle'],
                      'warp knit' => ['Lace','Mesh/Tulle','Raschel','Tricot','Velvet'],
                      'lining' => ['Chiffon Lining','Satin Lining','Stretch Lining','Taffeta Lining','Interlining'],
                      'Leather/Fur' => ['Artificial Fur','Artificial Leather','Fur','Leather'],
                      'Natural Fibers' => ['Wool','Merino Wool','Mohair','Alpaca','Cashmere','Angora','Soya or Milk Protein','Matt Cotton','Mercerized Cotton','Bamboo','Silk','Linen','Hemp','Ramie','Microfibre','Metallics','Acrylic','Nylon'],
                      'Yarn Blends' => ['Wool and Cotton Mixes','Natural and Synthetic Mixes','Synthetic-Only Mixes'],
                      'Speciality Yarns and Textural Effects' => ['Chenille','Plied Yarn','Eyelash Yarn','Slubby Yarn','Braided Yarn','Loose-Spun Yarn','Tape Yarn','Ribbon Yarn','Boucle Yarn','Tweed Yarn'],
                      'Unusual Yarn' => ['Plastic Bags','Wire','Fabric','String','Rubber Yarn'],
                    //   'textile_others' => ['PVC','Sequin','Tyvek','Vegan Fur','Vegan Leather','Vegan Suede'],

    ];
    foreach($product_tag as $key => $tag){
        $businessMappingTree=BusinessMappingTree::with('parent.parent')->where('name',$key)->first();
        if($businessMappingTree->parent->parent->name == 'manufacturer'){
            $tag_id=[];
            foreach($tag as $tag2){
                $product_tag=ProductTag::where('name',$tag2)->first();
                array_push($tag_id,$product_tag->id);
            }
            $businessMappingTree->tagMapping()->sync($tag_id);
        };
    }
    return 'done';
        $jacket=['Anoraks','Capes','Cloaks','Fur Coats','Jackets','Wind Jackets'];
        $knit=['Blouses','Caps','Cardigans','Corporate Uniform','Denim','Dress Pant','Flannel Pants','Flannel Shirt','Fleece Jackets','Hooded Sweat Shirt','Jackets','Jeans','Jerseys','Long Pant','Petticoats','Polo Shirts','Pullovers','Pyjamas','Scarfs ','Shirt-Blouses','Shirts','Shorts','Singlets','Skirts Dresses','Sports Wear','Suits','Sweat Shirts','Sweater','Tank Tops','Tops','Track-Suits','Trousers','T-Shirts','Underwear','Vests','Work Wear',];
        $lingerie=['Brassisres','Briefs','Corselettes','Corsets','Garters','Girdles','Inner Wear','Negligee Dressing Gowns','Night Dresses','Night Gowns','Night Pajamas','Night Shirt','Panties','Panty-Girdles','Pantyhose','Slips','Stockings','Swimwear','Tights','Underpants'];
        $others=['Brace','Gloves','Scarves','Veils'];
        $suits=['Blazers','Bow Ties','Cravats','Over Coats','Suits','Suspenders','Ties','Vests','Waistcoats'];
        $sweater=['Cardigan','Denim Pant','Mittens And Mitts','Mufflers','Pullover','Scarfs','Shawls','Ski Suits','Sock','Sweater','Vest','Wool Blazers','Wool Jackets','Woolen Caps'];
        $woven=['Basic 5 Pocket Trouser','Blouses','Bottom','Breeches','Cargo Pant','Cargo Shorts','Divided Skirts','Dresses','Dressing Gowns','Ensembles','Fleece Pullover','Frock','Handkerchiefs','Hoodie','Inner Wear','Jerseys','Laggings','Mantillas','Musk','Overall','Palazzo','Petticoats','Polo Shirts','Pyjamas','Shirts','Shorts','Skirts','Sleepwear','Top ','Track-Suits','Trousers'];
        $towel=['Wash Cloth','Fingertip Towel','Hand Towel','Bath Towel','Bath Sheets','Face Towel','Kitchen Towel','Spa Towel','Gym Towel','Beach Towel','Pet Towel','Foot Towel','Paper Towel','Tea Towel'];
        $bed_sheets=['Cotton Bed Sheets','Synthetic Flannel Bed Sheets','Tencel Bed Sheets','Silk Bed Sheets','Bamboo Bed Sheets','Microfiber Bed Sheets','Linen Bed Sheets'];
        $trims=['Sewing Thread','Button','Rivet','Lining','Interlining','Stopper','Lace','Braid','Elastic','Label','Zipper','Motif','Shoulder Pad','Hook & Loop','Twill Tape','Velcro Tape','Pon Pom','Wadding','Ribbon'];
        $accessories=['Hanger','Hangtag','Tissu Paper','Backboard','Neck Board','Paper Band','Pin/Clip','Tag Pin','Poly Bag','Elastic Bag','Mini Poly Bag','Collar Stand','Gum Tape','Scotch Tape','P.P Band','Inner Carton','Outer Carton','Iron Seal','Trapaulin Paper','Carton Sticker','Safety Sticker','Arrow Sticker','Butterfly','Both Side Tape','Plastic Staple','Barcode'];
        $washing=['Normal Wash','Pigment Wash','Bleach Wash','Stone Wash','Acid Wash','Enzyme Wash','Sand Blasting','Super White Wash','Caustic Wash'];
        $embroidery=[
            'Whitework embroidery',
            'Candlewick embroidery',
            'Cross stitch embroidery',
            'Pulled thread embroidery',
            'Hedebo embroidery',
            'Drawn thread embroidery',
            'Hardanger embroidery',
            'Crewel embroidery',
            'Surface embroidery',
            'Goldwork embroidery',
            'Redwork embroidery',
            'Blackwork embroidery',
            'Bluework embroidery',
            'Sashiko embroider'];
            $woven=[ 'Boucle',
            'Canvas',
            'Challis',
            'Chambray/Oxford',
            'Chiffon',
            'Clip Jacquard',
            'Corduroy',
            'Crepe/CDC',
            'Denim',
            'Dewspo',
            'Dobby',
            'Double Weave',
            'Eyelet',
            'Flannel',
            'Gauze/Double Gauze',
            'Georgette',
            'Jacquard/Brocade',
            'Melton/Boiled',
            'Memory',
            'Organza',
            'Plaid',
            'Plain',
            'Poplin',
            'Ripstop',
            'Satin',
            'Seersucker',
            'TRS',
            'Taffeta',
            'Tweed',
            'Twill',
            'Voile'];
            $cut_sew_knit=['Crepe Jersey',
            'Dobby/Jacquard',
            'Double Knit/Interlock',
            'Fleece',
            'French Terry',
            'Jersey',
            'Loop Terry',
            'Neoprene/Scuba',
            'Pique',
            'Pointelle',
            'Polar Fleece',
            'Ponte',
            'Rib',
            'Sherpa',
            'Velour',
            'Waffle'];
            $warp_knit=[ 'Lace',
            'Mesh/Tulle',
            'Raschel',
            'Tricot',
            'Velvet'];
            $lining=['Chiffon Lining',
            'Satin Lining',
            'Stretch Lining',
            'Taffeta Lining',
            'Interlining'];
            $textile_others=[ 'PVC',
            'Sequin',
            'Tyvek',
            'Vegan Fur',
            'Vegan Leather',
            'Vegan Suede'];
            $leather_fur=['Artificial Fur','Artificial Leather','Fur','Leather'];
            $natural_fibers=['Wool',
            'Merino Wool',
            'Mohair',
            'Alpaca',
            'Cashmere',
            'Angora',
            'Soya or Milk Protein',
            'Matt Cotton',
            'Mercerized Cotton',
            'Bamboo',
            'Silk',
            'Linen',
            'Hemp',
            'Ramie',
            'Microfibre',
            'Metallics',
            'Acrylic',
            'Nylon'];
            $yarn_blends=['Wool and Cotton Mixes','Natural and Synthetic Mixes','Synthetic-Only Mixes'];
            $speciality_yarns_and_textural_effects=['Chenille','Plied Yarn','Eyelash Yarn','Slubby Yarn','Braided Yarn','Loose-Spun Yarn','Tape Yarn','Ribbon Yarn','Bouclé Yarn','Tweed Yarn'];
            $unusual_yarn=['Plastic Bags','Wire','Fabric','String','Rubber Yarn'];

    }


}
