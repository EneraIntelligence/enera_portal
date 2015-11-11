<?php
/**
 * Created by PhpStorm.
 * User: asdrubal
 * Date: 10/15/15
 * Time: 4:21 PM
 */

namespace Portal\Libraries;


use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

class FileCloud
{
    protected $adapter;
    protected $filesysteam;
    protected $file;

    public function __construct()
    {
        $this->adapter = new SftpAdapter([
            'host' => '192.241.236.240',
            'port' => 22,
            'username' => 'forge',
            'password' => '9X0I9k3EFgYIejMRT0T8',
            'privateKey' => '/Users/usuario/.ssh/id_rsa',
            'root' => '/home/forge/prueba',
            'timeout' => 10,
            'directoryPerm' => 0755
        ]);

        $this->filesystem = new Filesystem($this->adapter);
    }

    public function subir($filename, $uploadedfile)
    {
        $this->filesystem->put($filename, $uploadedfile);
    }

    public function write($filename, $uploadedfile)
    {
        $this->filesystem->write($filename, $uploadedfile,['visibility' => 'public']);
    }

    public function getFile($fileName)
    {
        $contents = $this->filesystem->read($fileName);
    }

    public function getImagen($fileName)
    {
        $imagen = $this->filesystem->read($fileName);
        $img = "data:image/png;base64,".base64_encode($imagen);
        return $img;
    }

    public function getStreamFile($fileName)
    {
        $stream = $this->filesystem->readStream($fileName);
        /*$contents = stream_get_contents($stream);
        fclose($stream);*/
        return $this->filesystem->stream(function() use($stream) {
            fpassthru($stream);
        }, 200, [
            "Content-Type" => $this->filesysteam->getMimetype($fileName),
            "Content-Length" => $this->filesysteam->getSize($fileName),
            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
        ]);
//        return$contents;
    }

    public function checkExist($fileName){
        $exists = $this->filesystem->has($fileName);
        return $exists;
    }

    public function visibilidad()
    {
        if ($this->filesystem->getVisibility('secret.txt') === 'private') {
            $this->filesystem->setVisibility('secret.txt', 'public');
        }
    }

    public function getmetadata()
    {
        $info = $this->filesystem->getMetadata('image.png', ['timestamp', 'mimetype']);
        return $info;
    }

}