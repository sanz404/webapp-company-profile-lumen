<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Faker\Factory as Faker;

class AppController extends BaseController
{

    public function __construct() {
        if(!is_dir($this->getPublicPath("uploads"))){
            @mkdir($this->getPublicPath("uploads"));
        }
    }

    protected function getUUID(){
        $faker = Faker::create();
        return $faker->uuid();
    }

    protected function toSlug($text){
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return $text;
    }

    public function getPublicPath($path = '')
    {
        return env('PUBLIC_PATH', base_path('public')) . ($path ? '/' . $path : $path);
    }

    public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash="" ) {
        $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
        if(isset($splited[0]) && isset($splited[1])){
            $mime=$splited[0];
            $data=$splited[1];
            $mime_split_without_base64=explode(';', $mime,2);
            $mime_split=explode('/', $mime_split_without_base64[0],2);
            if(count($mime_split)==2)
            {
                $extension=$mime_split[1];
                if($extension=='jpeg')$extension='jpg';
                $output_file_with_extension=$output_file_without_extension.'.'.$extension;
            }
            file_put_contents( $path_with_end_slash . $output_file_with_extension, base64_decode($data) );
            return $output_file_with_extension;

        }
        return null;
    }

    public function getRandomColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function first_sentence($content) {
        $pos = strpos($content, '.');
        return substr($content, 0, $pos+1);
    }
}
