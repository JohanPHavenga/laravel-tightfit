<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index($type = null, $product = null)
    {

        switch ($type) {
            case "garagedoors":
                $data['heading'] = "Garage Doors";
                break;
            case "doorautomation":
                $data['heading'] = "Garage Door Automation";
                break;
            case "gateautomation":
                $data['heading'] = "Gate Automation";
                break;
            default:
                return redirect()->route("home")->with('failure', 'No gallery found');
                break;
        }

        
        $dir_to_map = $type;
        if (isset($product)) {
            $data['heading'] = ucfirst($product) . " " . $data['heading'];
            $dir_to_map = $dir_to_map . "/" . $product;

            switch($product) {
                case "nice":
                    $data['supplier_url'] = "https://www.niceforyou.com/za";
                break;
                case "centurion":
                    $data['supplier_url'] = "https://www.centsys.co.za/";
                break;
            }
        }

        $disk_path = public_path('images/gallery/' . $dir_to_map);
        $file_list = [];

        if (is_dir($disk_path)) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            foreach (File::allFiles($disk_path) as $file) {
                if (in_array(strtolower($file->getExtension()), $allowed)) {
                    $file_list[] = 'images/gallery/' . $dir_to_map . '/' . $file->getRelativePathname();
                }
            }
        }

        if (empty($file_list)) {
            return redirect()->route("home")->with('failure', 'No gallery found for that type');
        }

        return view('gallery')->with(
            [
                'data' => $data,
                'files' => $file_list,
            ]
        );
    }
}
