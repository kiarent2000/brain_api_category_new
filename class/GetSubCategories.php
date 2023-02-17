<?php
class GetSubCategories
{
    public $all_categories;
    
    public function __construct($all_categories)
    {
        $this->all_categories=$all_categories;
    }
    
    
    public function getChildCategoriesByParentCategory($parent_category_id, $level, $parents)
    {
        $categories=array();
         
        $level++;
        $i=$level;

        foreach($this->all_categories as $child_category)
        {
         $child_categories=array();
         
         if($child_category['parentID']===$parent_category_id)
         {		
            
            $has_children=$this->check_child($child_category['categoryID']);
            
            $parents[$level]=$child_category['categoryID'];

            if($has_children)
            {
                                
                $child_categories=$this->getChildCategoriesByParentCategory($child_category['categoryID'], $i, $parents);
                
                $categories[]=array(
                'categoryID'=>$child_category['categoryID'],
                'name'=>$child_category['name'],
                'has_children' => $has_children,
                'parents' => $parents,
                'children' => $child_categories,
                'level' => $level
                );
            } else {
                
                $categories[]=array(
                    'categoryID'=>$child_category['categoryID'],
                    'name'=>$child_category['name'],
                    'has_children' => $has_children,
                    'parents' => $parents,
                    'level' => $level,
                    'children' => ''
                    ); 
            }    
         }  
        }         
          
         return $categories;
    }
    
    public function check_child($category_id) : int
    {
                   
        foreach($this->all_categories as $category)
        {
            if($category['parentID']===$category_id) return true;
        }        
        return false;
    }

    public function convertCategory($category)
    {
        $category_id = $category['categoryID'];
        $name = $category['name'];
        $has_children = $category['has_children'];
        $children = $category['children'];
        $level = $category['level'];
        $parents = $category['parents'];

        $defis='-';

        for($level; $level>0; $level--)
        {
            $defis=$defis .'-';
        }
        
        
        $prepared_parents = array();
        
        
        echo $defis.' | id категории: '.$category_id.' название: '.$name.' level: '.$level.'  has_children: '.$has_children.'<br>';
 
        foreach($parents as $key=>$value)
        {                
            echo 'id категории:'.$category_id.' parent_id: '.$value.' level:'.$key.'<br>';

            $prepared_parents[]=array(
                'category_id' => $category_id,
                'path_id' => $value,
                'level' => $key
            );
        }

        $opencart_category = array(
            'category_id' => $category_id,
            'name' => $name,
            'has_children' => $has_children,
            'children' => $children,
            'level' => $level,
            'path_array' => $prepared_parents
        );


        if($has_children)
        {
            foreach($children as $child)
            {
                $this->convertCategory($child); 
            }
        } 
    }    
}