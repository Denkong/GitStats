<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;



class IndexController extends Controller
{
  /**
   * Массив отправляемых данныъ
   */
    public $reqSend = [];
  /**
   * /test
   */
    public function showTest()
    {
      return view('test');
    }

    /**
     * Котролеер API POST api/getFiles
     */
    public function savedata2(Request $req)
    {
      
      
      $regular="/https:\\/\\/github.com\\/([0-9A-zА-я-_]+)\\/([0-9A-zА-я-_]+)/ui";
      if (empty($req->gitRepo) || empty($req->dateStart) ||empty($req->dateEnd) || preg_match($regular, $req->gitRepo)==0){
        return response()->json(["error"=>"Не все данные введены или не правильный формат url"]);
      }  else{
        preg_match($regular, $req->gitRepo,$arr);
        $dataStart=$req->dateStart;
        $dataEnd=$req->dateEnd;
        //Отправляем запрос к API GITHUB на получение списка коммитов за данный период
        $client = new Client();
        try {
          $commits = $client->get("https://api.github.com/repos/${arr[1]}/${arr[2]}/commits?since=${dataStart}&until=${dataEnd}");
        } catch (RequestException $e) {
          return response()->json(["error"=>"Исчерпан лимит запросов, попробуйте позднее"]);
        }
        $arrCommits=json_decode($commits->getBody()->getContents(), true);
   
       
          foreach ($arrCommits as $key => $value) {
            try {
              $commitres = $client->get("${value['url']}");
            } catch (RequestException $e) {
              return response()->json(["error"=>"Исчерпан лимит запросов, попробуйте позднее"]);
            }
            $arrCommitFiles=json_decode($commitres->getBody()->getContents(), true);
            $author=$arrCommitFiles['commit']['author']['name'];
                
      
              foreach($arrCommitFiles['files'] as $key => $value){
        
                if(empty($this->reqSend[$value['filename']]['totalCommitChange'])){
                  $this->reqSend[$value['filename']]['totalCommitChange'] = 1;
                } else {
                  $this->reqSend[$value['filename']]['totalCommitChange']++;
                };
    
                if(empty($this->reqSend[$value['filename']]['authors'])){
                  $this->reqSend[$value['filename']]['authors'][]=[
                    'name'=>$author,
                    'changes'=>1
                  ];
                } else {
                  foreach ($this->reqSend[$value['filename']]['authors'] as $k => $v) {
                    if ($author === $this->reqSend[$value['filename']]['authors'][$k]['name']) {
                      $this->reqSend[$value['filename']]['authors'][$k]['changes']++;
                    }else{
                      $this->reqSend[$value['filename']]['authors'][]=[
                        'name'=>$author,
                        'changes'=>1
                      ];
                    }
                  }
                }
    
              }

          }; 
        
        return response()->json($this->reqSend);
        
      }

    }

}
