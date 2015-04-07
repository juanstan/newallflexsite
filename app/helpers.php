<?php
    function getTemperatureColor($temperature, $temperatureSetting)
    {
        if ($temperatureSetting == 'F'):
            $temperature = round($temperature*9/5+32, 1);
        if ($temperature >= 102.2) :
            $tempColor = '#FF2B2B';
        elseif ($temperature < 102.2 && $temperature >= 100.4) :
            $tempColor = '#F1955E';
        else :
            $tempColor = '#40C8C6';
        endif;
            return array('temp' => $temperature, 'tempcol' => $tempColor);
        elseif ($temperatureSetting == 'C'):
            $temperature = round($temperature, 1);
        if ($temperature >= 39.0) :
            $tempColor = '#FF2B2B';
        elseif ($temperature < 39.0 && $temperature >= 38.0) :
            $tempColor = '#F1955E';
        else :
            $tempColor = '#40C8C6';
        endif;
            return array('temp' => $temperature, 'tempcol' => $tempColor);
        endif;
    }

    function tempConvert($temperature, $temperatureSetting)
    {
        if ($temperatureSetting == 'F'):
            return $temperature*9/5+32;
            else:
            return $temperature;
        endif;
    }

    function geocode($address){
        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address={$address}";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address
        if($resp['status']='OK'){

            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];

            // verify if data is complete
            if($lati && $longi && $formatted_address){

                // put the data in the array
                $data_arr = array();

                array_push(
                    $data_arr,
                    $lati,
                    $longi,
                    $formatted_address
                );

                return $data_arr;

            }else{
                return false;
            }

        }else{
            return false;
        }
    }
?>