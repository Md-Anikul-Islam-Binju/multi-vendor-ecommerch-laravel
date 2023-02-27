<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait CreateSlug {

    public function createSlug($table, $slug, $field='')
    {

        $field = ($field) ? $field : 'slug';
        //remove whitspace
        $slug = strTolower(preg_replace('/[\t\n\r\s]+/', '-', trim($slug)));
        //remove unwanted characters
        $slug = preg_replace("/[?#*<>.@,'&\/]+/",'', $slug);
        $slug = preg_replace("/[-]+/", "-", $slug);
        $check_slug = DB::table($table)->select($field)->where($field, 'like', $slug.'%')->get();
        if (count($check_slug)>0){
            //find slug until find not used.
            for ($i = 1; $i <= 9999; $i++) {
                $newSlug = $slug.'-'.$i;
                if (!$check_slug->contains($field, $newSlug)) {
                    return $newSlug;
                }
            }
        }else{ return $slug; }
    }

    public function uniqueOrderId($table, $field, $prefix)
    {
        $prefix = str_replace('K', 'R', $prefix); //if K kanamachi replace R
        $prefixlen = strlen($prefix);
        $numberLen = 10 - $prefixlen;
        $order_id = $prefix. strtoupper(substr(str_shuffle("0123456789"), -$numberLen));
        $check_path = DB::table($table)->select($field)->where($field, 'like', $order_id.'%')->get();
        if (count($check_path)>0){
            //find slug until find not used.
            for ($i = 1; $i <= 99; $i++) {
                $new_order_id = $prefix.strtoupper(substr(str_shuffle("0123456789"), -$numberLen));
                if (!$check_path->contains($field, $new_order_id)) {
                    return $new_order_id;
                }
            }
        }else{ return $order_id; }
    }

    public function uniqueImagePath($table, $field, $imagePath)
    {
        $imagePath = strTolower(preg_replace('/[\t\n\r\s]+/', '-', trim($imagePath)));
        //remove unwanted characters
        $imagePath = (preg_replace("/[?#*<>@,'&\/]+/", "", $imagePath));
        $imagePath = preg_replace("/[-]+/", "-", $imagePath);
        $check_path = DB::table($table)->select($field)->where($field, 'like', '%'.$imagePath)->get();

        if (count($check_path)>0){
            //find slug until find not used.
            for ($i = 1; $i <= 9999; $i++) {
                $newPath = $i.'-'.$imagePath;
                if (!$check_path->contains($field, $newPath)) {
                    return $newPath;
                }
            }
        }else{ return $imagePath; }
    }
}
