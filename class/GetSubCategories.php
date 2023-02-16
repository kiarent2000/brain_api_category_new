<?php
class GetSubCategories
{
    
    public function getChildCategoriesBy
    
    
    
    
    
    
    
    
    
    public function getGetSubCategoriesArray($array, $parent_category_id, $level, $parents) 
    {
      
           $categories=array();
          
           
           foreach($array as $category)
           {
            $child_categories=array();
            if($category['parentID']===$parent_category_id)
            {		
               
               $has_children=$this->check_child($array, $category['categoryID']);
               
               
               if($has_children)
               {
                    $child_categories=$this->getGetSubCategoriesArray($array, $category['categoryID'], 2, $parents);
               }
               
               
               $categories[]=array(
                  'categoryID'=>$category['categoryID'],
                  'parents'=>$parents,
                  'name'=>$category['name'],
                  'level' => $level,
                  'parent_level_id' => $parent_category_id,
                  'has_children' => $has_children,
                  'children' => $child_categories
               );
            }
            

            } 
            return $categories;
    }

    public function check_child($array, $category_id) : int
    {
                   
        foreach($array as $category)
        {
            
            if($category['parentID']===$category_id)
            {		
               return true;
            }
            

        } 
       
        return false;
    }



}