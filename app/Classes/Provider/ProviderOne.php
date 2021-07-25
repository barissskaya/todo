<?php


namespace App\Classes\Provider; 

class ProviderOne implements ProviderInterface
{
    private $endPoint = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';
   
    public function fetch() : array
    {
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request("GET", $this->endPoint);
            $responseBody = json_decode($res->getBody());

            return $this->parseResponse($responseBody);

        }catch (\Throwable $e){
            throw new \Exception('Veriler okunamadı. Hata: ' . $e->getMessage());
        }
    }

  public function parseResponse(array $response) : array{ 
    $parsedResponse = []; 
    if(count($response)){ 
        foreach ($response as $res){
            $responseItem = [
                'name' => $res->id,
                'level' => $res->zorluk,
                'duration' => $res->sure,
            ];
            array_push($parsedResponse, $responseItem);
        } 
    }
    return $parsedResponse;
  }
}
