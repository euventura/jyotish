<?
namespace App\Helpers\MapDraw;

class MapDraw
{

    protected $jyotishData;

    public function __construct(array $jyotishData)
    {
        $this->jyotishData = $jyotishData;
    }

    public function draw(int $width = 340)
    {
        return IMG_JPEG;
    }

}
