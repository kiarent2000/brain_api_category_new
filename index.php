<?php 
declare(strict_types=1);

spl_autoload_register(function ($class) {
    include __DIR__ . '/class/'.$class.'.php';
});

include(__DIR__.'/config.php');
//$dbh = DB::getInstance()->connect();

try
{
    $categories = (new PrepareArray())->getArray(); // получение массива всех категорий
 
    $main_categories = (new getMainCategories())->getMainCategoriesArray($categories, $main_categories_list); // получение массива главных категорий
 
    $level=0;    

    $sub_categories_object = new GetSubCategories($categories);       

    foreach($main_categories as $category)
	{     
       
        $parent_categories=array();
        echo '<br>#################################################################################
        <h3>id категории: '.$category['categoryID'].' название: '.$category['name'].' level: 0  </h3>';
        
        $parent_categories[]=$category['categoryID'];

        $subcategories=$sub_categories_object->getChildCategoriesByParentCategory($category['categoryID'], $level, $parent_categories);
        

        foreach($subcategories as $category_s)
        {  
            $sub_categories_object->convertCategory($category_s);
        } 
    } 
} 
    catch (Exception $ex) {
    echo $ex->getMessage();
}
?>