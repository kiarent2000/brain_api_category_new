<?php
class PrepareArray
{
    public function getArray() : array
    {
        try
        {
            $sid = (new GetId(LOGIN, PASSWORD, URL_AUTH))->sid(); 
            if(empty($sid)){throw new Exception('Пустой идентификатор сессии!');}
        
            $url='http://api.brain.com.ua/categories/'.$sid.'?lang=ua';

            $result = file_get_contents($url);
            
            if(!$result){throw new Exception('Не удалось подключить файл!');}
            
            $array = json_decode($result,true);

            return $array['result'];
        } 
            catch (Exception $ex) {
            return $ex->getMessage();
        }

    }



}