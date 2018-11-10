<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;



class IndexController extends Controller
{
    public $reqSend = [];

    public function showTest()
    {
      return view('test');
    }

    public function savedata(Request $req)
    {
      $regular="/https:\\/\\/github.com\\/([0-9A-zА-я-_]+)\\/([0-9A-zА-я-_]+)/ui";
      if (empty($req->gitRepo) || empty($req->dateStart) ||empty($req->dateEnd) || preg_match($regular, $req->gitRepo)==0){
        return redirect('/test')->with('error', 'Не все данные введены или неверный формат URL');
      }  else{

        preg_match($regular, $req->gitRepo,$arr);
        /*
        $arr[0] - строка
        $arr[1] - username :owner
        $arr[2] - reponame :repo
        */
        $dataStart=$req->dateStart;
        $dataEnd=$req->dateEnd;
       
        /**
         * Получаем список коммитов
         */
        $client = new Client();
         

        try {
          $commits = $client->get("https://api.github.com/repos/${arr[1]}/${arr[2]}/commits?since=${dataStart}&until=${dataEnd}");
        } catch (RequestException $e) {
          return redirect('/error')->with(["error"=>'Ошибка отправки запроса, попробуйте позднее']);
        }

        
        $arrCommits=json_decode($commits->getBody()->getContents(), true);
   
       
          foreach ($arrCommits as $key => $value) {
            $commitClient = new Client();
            $commitres = $commitClient->get("${value['url']}");
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
        
        
        return redirect('/test')->with(["arrFiles"=>$this->reqSend]);
        
      }
  
    }

    public function sorted(){
      dd([asd]);
    }


    /**
     * ----
     */
    public function savedata2(Request $req)
    {
      // return response()->json(["error"=>"Don"]);
      
      $regular="/https:\\/\\/github.com\\/([0-9A-zА-я-_]+)\\/([0-9A-zА-я-_]+)/ui";
      if (empty($req->gitRepo) || empty($req->dateStart) ||empty($req->dateEnd) || preg_match($regular, $req->gitRepo)==0){
        // return redirect('/test')->with('error', 'Не все данные введены или неверный формат URL');
        return response()->json(["error"=>"Dosnt have option"]);
      }  else{

        preg_match($regular, $req->gitRepo,$arr);
        
        $dataStart=$req->dateStart;
        $dataEnd=$req->dateEnd;
       
        
        $client = new Client();
         

        try {
          $commits = $client->get("https://api.github.com/repos/${arr[1]}/${arr[2]}/commits?since=${dataStart}&until=${dataEnd}");
        } catch (RequestException $e) {
          return response()->json(["error"=>"Too many Request"]);
        }

        
        $arrCommits=json_decode($commits->getBody()->getContents(), true);
   
       
          foreach ($arrCommits as $key => $value) {
            $commitClient = new Client();
            $commitres = $commitClient->get("${value['url']}");
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
        
        
        // return redirect('/test')->with(["arrFiles"=>$this->reqSend]);
        return response()->json($this->reqSend);
        
      }
  
    }

     /**
      * ---
      */

}
