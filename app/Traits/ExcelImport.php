<?php
namespace App\Traits;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Intervention\Image\Facades\Image;

trait ExcelImport {

    public function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( public_path('upload/images/product/thumb').'/'.$output_file, 'wb' );


        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $base64_string ));

        // clean up the file resource
        fclose( $ifp );
        copy('upload/images/product/thumb/'.$output_file, 'upload/images/product/'.$output_file);

            $image_resize = Image::make('upload/images/product/thumb/'.$output_file);
            $image_resize->resize(200, 200);
            $image_resize->save();

        return $output_file;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function excelExtract(string $path): array
    {
        if (!file_exists($path)){
            $path = public_path($path);
        }
        $fileType = IOFactory::identify($path);
        $reader = IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($path);
        $data = $spreadsheet->getActiveSheet()->toArray();


        $products = [];

        foreach ($data as $key=> $item){

            if (gettype($item[0]) === 'string' && gettype($item[2] != null && gettype($item[3]) !=null)){
               $productName = $item[0];
               $wholeSalePrice = $item[2];
               $retailPrice = $item[3];
               $description = $item[4];
               $brand = $item[6];
               $sku = $item[7];
               $category = $item[8];
               $sub_category = $item[9];
               $stock = $item[10];
               $unit = $item[11];
               $vendor = $item[12];
               $pathImage= '';
               if (isset($spreadsheet->getActiveSheet()->getDrawingCollection()[$key-1])){
                    $drawing = $spreadsheet->getActiveSheet()->getDrawingCollection()[$key-1];
                    $zipReader = fopen($drawing->getPath(), 'r');
                    $imageContents = '';
                    while (!feof($zipReader)) {
                       $imageContents .= fread($zipReader, 1024);
                    }
                    fclose($zipReader);
                    $extension = $drawing->getExtension();
                    $pathImage = $this->base64_to_jpeg(base64_encode($imageContents), uniqid().'.'.$extension);
               }

                $singleProduct = [
                    'name' => $productName,
                    'wholeSalePrice' => $wholeSalePrice,
                    'retailPrice' => $retailPrice,
                    'description' => $description,
                    'imagePath' => $pathImage,
                    'brand' => $brand,
                    'sku' => $sku,
                    'category' => $category,
                    'sub_category' => $sub_category,
                    'stock' => $stock,
                    'unit' => $unit,
                    'vendor' => $vendor
                ];
                $products[] =(object)$singleProduct;
            }
        }
        return $products;
    }
}