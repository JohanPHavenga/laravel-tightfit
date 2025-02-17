<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $file_list = Storage::disk('public')->allFiles($dir_to_map);

        return view('gallery')->with(
            [
                'data' => $data,
                'files' => $file_list,
            ]
        );
    }
}
