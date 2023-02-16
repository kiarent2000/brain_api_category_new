<?php
class GetSubCategories
{
    public $all_categories;
    
    public function __construct($all_categories)
    {
        $this->all_categories=$all_categories;
    }
    
    
    public function getChildCategoriesByParentCategory($parent_category_id)
    {
        $categories=array();
          
           
        foreach($this->all_categories as $child_category)
        {
         $child_categories=array();
         
         if($child_category['parentID']===$parent_category_id)
         {		
            
            $has_children=$this->check_child($child_category['categoryID']);
            
            if($has_children)
            {
                
                $child_categories=$this->getChildCategoriesByParentCategory($child_category['categoryID']);
                
                $categories[]=array(
                'categoryID'=>$child_category['categoryID'],
                'name'=>$child_category['name'],
                'has_children' => $has_children,
                'children' => $child_categories
                );
            } else {
                $categories[]=array(
                    'categoryID'=>$child_category['categoryID'],
                    'name'=>$child_category['name'],
                    'has_children' => $has_children
                    ); 
            }    
         }
         

         } 
         return $categories;
    }
    
    
    
    
    
    
    
    /*
    
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

    */

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