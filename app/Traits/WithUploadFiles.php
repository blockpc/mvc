<?php

namespace App\Traits;

trait WithUploadFiles
{
    public function upload_images(array $files, string $directory = "img", string $name = "image"):array
    {
        $directory = str_replace('/', DS, trim($directory, '/'));
        $route_public = 'public' . DS . 'img' . DS .$directory;
        if ( !is_dir( ROOT_APP . DS . $route_public) ) {
            mkdir(ROOT_APP . DS . $route_public,0755,TRUE);
        }
        $count = count($files);
        $file_names = [];
        foreach($files as $key => $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                [ 'basename' => $basename, 'extension' => $extension ] = pathinfo($file["name"]);
                $new_name = "{$name}.{$extension}";
                $uploads_dir = ROOT_APP . DS . $route_public . DS . $new_name;
                $file_names[] = "img/{$new_name}";
                if ( $count > 1 ) {
                    $new_name = $name.$key;
                    $uploads_dir = ROOT_APP . DS . $route_public . DS . "{$new_name}.{$extension}";
                    $file_names[$key] = "img/$new_name}.{$extension}";
                }
                move_uploaded_file($file["tmp_name"], $uploads_dir);
            }
        }
        return $file_names;
    }
}