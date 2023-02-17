<?php
class UpdateCategory
{
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
}