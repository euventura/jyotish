<?php

namespace App\Http\Services;

use App\Exceptions\JyotirException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DateTime;
use DateTimeZone;
use Jyotish\Base\Data;
use Jyotish\Base\Locality;
use Jyotish\Base\Analysis;
use Jyotish\Ganita\Method\Swetest;
use Jyotish\Dasha\Dasha;


class JyotirService extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Locality Obj
     *
     * @var Locality
     */
    protected $locality;

    /**
     * Base date to calc
     *
     * @var DateTime
     */
    protected $baseDate;

    /**
     * Ayanansha data
     *
     * @var Ganita
     */
    protected $ganita;


    /**
     * Jyotish Data Obj
     *
     * @var Data
     */
    protected $jyotishData;

    /**
     *
     */
    public function __construct(DateTime $datetime = null, Locality $locality = null)
    {
        $this->ganita = new Swetest(["swetest" => "/usr/bin"]);

        if (!is_null($datetime))
        {
            $this->setDate($datetime);
        }

        if (!is_null($locality))
        {
            $this->setVarLocality($locality);
        }

    }

    /**
     * set Transform and set Latitude and Longitude to a Locality Obj
     *
     * @param float $lat
     * @param float $long
     * @param integer $altitude
     * @return void
     */
    public function setLocality(float $lat, float $long, $altitude = 0)
    {
        $locality = $this->locality = new Locality([
            'longitude' => $lat,
            'latitude' => $long,
            'altitude' => $altitude,
            ]);

            $this->setVarLocality($locality);
    }

    /**
     * Set locality obj in class
     */
    private function setVarLocality(Locality $locality)
    {
        $this->locality = $locality;
    }

    /**
     *  Set Date
     */
    public function setDate($date)
    {
        $this->baseDate = $date;
    }

    /**
     * validate and make final calculation
     *
     * @param array $data
     * @return void
     */
    public function calc(Array $data = [])
    {

        if ($data) {
            $this->setDate($data['data']);

            if(!isset($data['altitude'])){
                $data['altitude'] = null;
            }

            $this->setLocality($data['latitude'], $data['longitude'], $data['altitude']);
        }

        $this->validate();
        $this->jyotishData = new Data($this->baseDate, $this->Locality, $this->ganita);
        return $this->jyotishData->calcParams();

    }

    /**
     * Validate data to calc properly
     */
    private function validate()
    {
        if (! $this->locality instanceof Locality) {
            throw new JyotirException('Invalid Locality');
        }

        if (! $this->baseDate instanceof DateTime) {
            throw new JyotirException('Invalid Date');
        }

        return true;
    }

}
