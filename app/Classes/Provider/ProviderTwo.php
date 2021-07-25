<?php


namespace App\Classes\Provider; 

class ProviderTwo implements ProviderInterface
{
    private $endPoint = 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7';
   
    public function fetch() : array
    {
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request("GET", $this->endPoint);
            $responseBody = json_decode($res->getBody(), true); 
            return $this->parseResponse($responseBody);

        }catch (\Throwable $e){
            throw new \Exception('Veriler okunamadı. Hata: ' . $e->getMessage());
        }
    }

    public function parseResponse(array $response) : array { 
      $parsedResponse = []; 
      if(count($response)){ 
          foreach ($response as $res){
            $key = array_key_first($res); 
            $responseItem = [
                'name' => $key,
                'level' => $res[$key]['level'],
                'duration' => $res[$key]['estimated_duration'],
            ];
            array_push($parsedResponse, $responseItem); 
          } 
      }
      return $parsedResponse;
    }
}
