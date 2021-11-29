<?
namespace App\helpers\MapDraw;

class BaseImage
{

    private $width, $path, $imagePath;

    public function __construct()
    {
        $this->path = APPstorage_path('map_draw');
        $this->imagePath = $this->pack . APP::
    }

    public function getImage(int $width)
    {
        $this->width = $width;

    }

}
