<?php

namespace App\Services;

use App\Exceptions\AppError;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class Captcha
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function path($file = ''){
        return storage_path("app/captcha/" . $file);
    }

    public function generate()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if($this->config['uppercase']){
            $characters = strtoupper($characters);
        }
        $captchaText = '';

        for ($i = 0; $i < $this->config['length']; $i++) {
            $captchaText .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $this->generateImage($captchaText);
    }

    protected function generateImage($captchaText)
    {
        $image = imagecreatetruecolor($this->config['width'], $this->config['height']);
        if($image === false){
            throw new AppError("captcha failed to make image", 500);
        }
        $bgColor = imagecolorallocate($image, 204, 204, 204);
        if($bgColor === false){
            throw new AppError("captcha failed to make generate color for background image", 500);
        }
        if(imagefill($image, 0, 0, $bgColor) === false){
            throw new AppError("captcha failed to make background image", 500);
        }
        $textColor = imagecolorallocate($image, 0, 0, 0);
        if($textColor === false){
            throw new AppError("captcha failed to make text color image", 500);
        }

        $fontPath = public_path('assets/adminlte/fonts/RubikDoodleTriangles.ttf');

        // Menghitung lebar teks
        $textWidth = imagettfbbox($this->config['font_size'], 0, $fontPath, $captchaText);
        if($textWidth === false){
            throw new AppError("captcha failed to make box image", 500);
        }

        // Menempatkan teks di tengah gambar
        $textWidth = $textWidth[2] - $textWidth[0];
        $x = (int) ($this->config['width'] - $textWidth) / 2;
        $y = 30;

        // membuat image text
        $r = imagettftext($image, (float) $this->config['font_size'],(float) 2, $x, $y, $textColor, $fontPath, $captchaText);
        if($r === false){
            throw new AppError("captcha failed to write text to image", 500);
        }
        // membuat noise pada image
        if($this->config['noice']){
            $noiseLevel = 10;
            for ($i = 0; $i < $noiseLevel; $i++) {
                $noiseColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
                if($noiseColor === false){
                    throw new AppError("captcha failed to make color for noice image", 500);
                }
                $ellipseWidth = 25; // Lebar ellips
                $ellipseHeight = 25; // Tinggi ellips
                $r = imageellipse($image, rand(0, $this->config['width']), rand(0, $this->config['height']), $ellipseWidth, $ellipseHeight, $noiseColor);
                if($r === false){
                    throw new AppError("captcha failed to make noice image", 500);
                }
            }
        }

        // Output gambar
        ob_start();
        if(imagepng($image) === false){
            throw new AppError("captcha failed to generate image png", 500);
        }
        $imageData = ob_get_clean();

        if($imageData === false){
            throw new AppError("captcha failed to get buffer image", 500);
        }

        if(imagedestroy($image) === false){
            throw new AppError("captcha failed to destroy image", 500);
        }

        $data = [
            "id" => Carbon::now()->addMinutes($this->config['ttl'])->timestamp,
            "file" => 'data:image/png;base64,' . base64_encode($imageData),
            "expired" => $this->config['ttl'] * 60,
        ];

        $this->save($data['id'], $captchaText);

        return $data;
    }

    private function createDirectoryIfNotExist($dir){
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir);
        }
    }

    public function save($fileId, $captchaText){
        $this->createDirectoryIfNotExist($this->path());

        $filePath = $this->path($fileId .".txt");
        if(file_put_contents($filePath, $captchaText) === false){
            throw new AppError("failed save file to storage", 500);
        }
    }

    public function destroy(){
        $this->createDirectoryIfNotExist($this->path());

        $filenames = File::files($this->path());
        $filenamesOnly = array_map('basename', $filenames);

        foreach($filenamesOnly as $file){
            $expired = (int) preg_replace('/[^0-9]/', '', $file);
            if(Carbon::now()->timestamp > $expired){
                unlink($this->path($file));
            }
        }
    }


    public function check($id, $input)
    {
        $captcha = file_get_contents($this->path($id.".txt"));
        return strtoupper($input) === strtoupper($captcha);
    }
}
