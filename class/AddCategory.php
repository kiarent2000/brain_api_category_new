<?php

class addCategory
{
    
    public $dbh;
    
    public function __construct()
    {
        $this->dbh=DB::getInstance()->connect();
    }
    
    
    public function add($category)
    {
        print_r($category);
        $brain_id=$category['brain_id'];
        $name=$category['name'];
        $level=$category['level'];
        $parent=$category['parent'];

        $prepared_path=$category['prepared_path'];

        //[prepared_path] => Array ( [0] => Array ( [path_id] => 292 [level] => 0 ) [1] => Array ( [path_id] => 51 [level] => 1 ) )

        echo '<p style="color:green">Добавление новой категории '.$brain_id.' - '.$name.' | родитель: '.$parent.' level: '.$level.'<p>';
        
        $path_array = $category['prepared_path'];

        $sql = 'INSERT INTO `'. DB_PREFIX.'_category` SET `brain_id`='.$brain_id.', `parent_id` = '.$parent.', `column` = 1, `status` = 1, `date_added`=NOW(), `date_modified`=NOW(), `top`=1';
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
		
        $last_category_id = $this->dbh->lastInsertId();
        
        if($last_category_id)
        {
            
        echo $last_category_id;

        $sql = 'INSERT INTO `'. DB_PREFIX.'_category_description` SET `category_id`='.$last_category_id.', `language_id` = 1,  `name` = :name';

        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':name', $name, PDO::PARAM_STR);    
        $sth->execute();  
        
        $sql = 'INSERT INTO `'. DB_PREFIX.'_category_description` SET `category_id`='.$last_category_id.', `language_id` = 2,  `name` = :name';

        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':name', $name, PDO::PARAM_STR);    
        $sth->execute(); 

        $sql = 'INSERT INTO `'. DB_PREFIX.'_category_to_layout` SET `category_id`='.$last_category_id.', `store_id` = 0,  `layout_id` = 0';

        $sth = $this->dbh->prepare($sql);
        $sth->execute();  


        $sql = 'INSERT INTO `'. DB_PREFIX.'_category_to_store` SET `category_id`='.$last_category_id.', `store_id` = 0';

        $sth = $this->dbh->prepare($sql);
        $sth->execute(); 
        
        $seo_path='';
        $l=1;

        foreach($prepared_path as $new_path)
        {
            $sql = 'INSERT INTO `'. DB_PREFIX.'_category_path` SET `category_id`='.$last_category_id.', `path_id` = '.$new_path['path_id'].', `level` = '.$new_path['level'];

            $sth = $this->dbh->prepare($sql);
            $sth->execute(); 

            if($l===1)
            {
                $seo_path=$new_path['path_id'];  
            } else {
                $seo_path=$seo_path.'_'.$new_path['path_id'];
            }

            $l++;
   
        }




        $sql = 'INSERT INTO `'. DB_PREFIX.'_category_path` SET `category_id`='.$last_category_id.', `path_id` = '.$last_category_id.', `level` = '.$level;

        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        $seo_path=$seo_path.'_'.$last_category_id;
        $query='category_id='.$last_category_id;
        $keyword=$this->translit($name);

        $sql = 'INSERT INTO `'. DB_PREFIX.'_seo_url` SET  `store_id` = 0,  `language_id` = 1, `query`="'.$query.'", `keyword`="'.$keyword.'", `seopath`="'.$seo_path.'"';

        $sth = $this->dbh->prepare($sql);
        $sth->execute();  


        $keyword=$this->translit($name).'-ru';

        $sql = 'INSERT INTO `'. DB_PREFIX.'_seo_url` SET  `store_id` = 0,  `language_id` = 2, `query`="'.$query.'", `keyword`="'.$keyword.'", `seopath`="'.$seo_path.'"';

        $sth = $this->dbh->prepare($sql);
        $sth->execute();  


        }    




    }

    public function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'',' '=>'-'));
        return $s; // возвращаем результат
      }
}