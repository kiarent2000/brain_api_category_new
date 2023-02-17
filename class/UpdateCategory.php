<?php
class UpdateCategory
{
    public $dbh;
    
    public function __construct()
    {
        $this->dbh=DB::getInstance()->connect();
    }
    
    
    
    public function show($category)
    {
        $category_id = $category['category_id'];
        $name = $category['name'];
        $has_children = $category['has_children'];
        $children = $category['children'];
        $level = $category['level'];
        $path_array = $category['path_array'];
        
        $defis='-';

        for($level; $level>0; $level--)
        {
            $defis=$defis .'-';
        }

        echo $defis.' | id категории: '.$category_id.' название: '.$name.' level: '.$level.'  has_children: '.$has_children.'<br>';

        foreach($path_array as $path)
        {                
            echo 'id категории:'.$path['category_id'].' path_id: '.$path['path_id'].' level:'.$path['level'].'<br>';
        } 
    }

    public function check($category)
    {
        $category_id = $category['category_id'];
        $name = $category['name'];

        //echo 'id категории: '.$category_id.' название: '.$name.'<br>';

        $sql = 'SELECT a.category_id, a.brain_id FROM '. DB_PREFIX.'_category a,  '. DB_PREFIX.'_category_description b WHERE a.category_id = b.category_id AND b.language_id=1 AND b.name="'.$name.'"';
        $sth = $this->dbh->query($sql);
        $result = $sth->fetch();
        if($result)
        {
           // echo 'Категория '.$category_id.' - '.$name.' есть в базе сайта. Код категории на сайте: '.$result['category_id'].' код Брейн:'.$result['brain_id'].'<br>'; 

          /*  $sql = 'UPDATE `'. DB_PREFIX.'_category` SET `brain_id`='.$category_id.' WHERE `category_id`='.$result['category_id'];
		
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            if($sth->errorInfo()[2]){
                print_r($sth->errorInfo());
            }*/

        } else {
            $this->addNewCategory($category);
        }
    }

    public function addNewCategory($category)
    {
        $category_id = $category['category_id'];
        $name = $category['name'];
        $parent = $category['parent'];
        $level = $category['level'];

        $new_category=array(
            'brain_id'=> $category_id,
            'name'=> $name,
            'level'=> $level,
            'parent'=> $this->getRealPass($parent),
        );
        
        echo '<b>Необходимо добавить новую категорию '.$category_id.' - '.$name.' | родитель: '.$parent.'</b><br>';
        $path_array = $category['path_array'];

        

        foreach($path_array as $path)
        {                
            echo 'id категории:'.$path['category_id'].' path_id: '.$path['path_id'].' level:'.$path['level'].'<br>';
        } 

        echo "Подготовленный путь:<br>";
        
        unset($path_array[$level]);

        $prepared_path=array();

        foreach($path_array as $path)
        {                
            echo 'id категории:'.$this->getRealPass($path['category_id']).' path_id: '.$this->getRealPass($path['path_id']).' level:'.$path['level'].'<br>';

            $prepared_path[]=array(
                'path_id'=> $this->getRealPass($path['path_id']),
                'level'=> $path['level'],
            );
        } 

        $new_category['prepared_path']=$prepared_path;



        (new addCategory())->add($new_category);
    }

    public function getRealPass($brain_id)
    {
        $sql = 'SELECT `category_id` FROM '. DB_PREFIX.'_category WHERE `brain_id`='.$brain_id;
        $sth = $this->dbh->query($sql);
        $result = $sth->fetch();
        if($result)
        {
            return $result['category_id'];
        }
    }    
}