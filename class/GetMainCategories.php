<?php
class GetMainCategories
{
    public function getMainCategoriesArray($array, $list) : array
    {
        try
        {
            $categories=array();
            
            foreach($array as $category)
            {
            
            if(in_array($category['categoryID'], $list) && $category['parentID']===MAIN_CATEGORY_ID)
            {		
               $categories[]=array(
                  'categoryID'=>$category['categoryID'],
                  'parentID'=>$category['parentID'],
                  'name'=>$category['name']
               );
            }
        }
            return $categories;
        } 
            catch (Exception $ex) {
            return $ex->getMessage();
        }

    }



}