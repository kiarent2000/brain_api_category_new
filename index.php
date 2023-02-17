<?php 
declare(strict_types=1);

spl_autoload_register(function ($class) {
    include __DIR__ . '/class/'.$class.'.php';
});

include(__DIR__.'/config.php');
//$dbh = DB::getInstance()->connect();

try
{
  
  /*
    $categories[] = Array ( 
    'categoryID' => 1181,
    'parentID' => 1,
    'name' => 'Ноутбуки, планшети' 
    );

  
    
  
        
        

    $categories[] = Array ( 
        'categoryID' => 1182,
        'parentID' => 1181,
        'name' => 'Планшети' 
    );

    $categories[] = Array ( 
        'categoryID' => 1187,
        'parentID' => 1181,
        'name' => 'Акссесуары для ноутбуков' 
    );


    $categories[] = Array ( 
        'categoryID' => 1183,
        'parentID' => 1182,
        'name' => 'Sony' 
    );

    $categories[] = Array ( 
        'categoryID' => 1185,
        'parentID' => 1184,
        'name' => 'черный' 
    );


    $categories[] = Array ( 
        'categoryID' => 1184,
        'parentID' => 1183,
        'name' => '15 дюймів' 
    );

    $categories[] = Array ( 
        'categoryID' => 1513,
        'parentID' => 1,
        'name' => 'Телефони' 
        );

    $categories[] = Array ( 
            'categoryID' => 1514,
            'parentID' => 1513,
            'name' => 'Нокія' 
    ); 


    $categories[] = Array ( 
        'categoryID' => 1515,
        'parentID' => 1514,
        'name' => 'модель 8810' 
    ); 
*/

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