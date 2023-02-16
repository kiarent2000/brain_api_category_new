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
                
                $parents[]=array(
                    'parent_category_id' => $child_category['categoryID'],
                    'level' => $i
                );
                
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
                $parents[]=array(
                    'parent_category_id' => $child_category['categoryID'],
                    'level' => $i
                );    

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
            
            if($category['parentID']===$category_id)
            {		
               return true;
            }
            

        } 
       
        return false;
    }
}