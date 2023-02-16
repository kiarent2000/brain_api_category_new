<?php
class GetSubCategories
{
    public $all_categories;
    
    public function __construct($all_categories)
    {
        $this->all_categories=$all_categories;
    }
    
    
    public function getChildCategoriesByParentCategory($parent_category_id, $level)
    {
        $categories=array();
         
        $i=$level;
        ++$i;

        foreach($this->all_categories as $child_category)
        {
         $child_categories=array();
         
         if($child_category['parentID']===$parent_category_id)
         {		
            
            $has_children=$this->check_child($child_category['categoryID']);
            
            if($has_children)
            {
                
                $child_categories=$this->getChildCategoriesByParentCategory($child_category['categoryID'], $i);
                
                $categories[]=array(
                'categoryID'=>$child_category['categoryID'],
                'name'=>$child_category['name'],
                'has_children' => $has_children,
                'children' => $child_categories,
                'level' => $level
                );
            } else {
                $categories[]=array(
                    'categoryID'=>$child_category['categoryID'],
                    'name'=>$child_category['name'],
                    'has_children' => $has_children,
                    'level' => $level
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
            
            if($category['parentID']===$category_id)
            {		
               return true;
            }
            

        } 
       
        return false;
    }
}