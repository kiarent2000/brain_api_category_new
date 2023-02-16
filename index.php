<?php 
declare(strict_types=1);

spl_autoload_register(function ($class) {
    include __DIR__ . '/class/'.$class.'.php';
});

include(__DIR__.'/config.php');
//$dbh = DB::getInstance()->connect();

try
{
  
    $categories[] = Array ( 
    'categoryID' => 1181,
    'parentID' => 1,
    'name' => 'Ноутбуки, планшети' 
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

    $categories[] = Array ( 
        'categoryID' => 1182,
        'parentID' => 1181,
        'name' => 'Планшети' 
    );


    $categories[] = Array ( 
        'categoryID' => 1183,
        'parentID' => 1182,
        'name' => 'Sony' 
    );

    $categories[] = Array ( 
        'categoryID' => 1184,
        'parentID' => 1183,
        'name' => '15 дюймів' 
    );

    $categories[] = Array ( 
        'categoryID' => 1185,
        'parentID' => 1184,
        'name' => 'черный' 
    );
  
  
    // $categories = (new PrepareArray())->getArray(); // получение массива всех категорий

 
    $main_categories = (new getMainCategories())->getMainCategoriesArray($categories, $main_categories_list); // получение массива главных категорий
 
    $level=1;

    $sub_categories_object = new GetSubCategories($categories);
    
    $parent_categories=array();

    foreach($main_categories as $category)
	{     
        echo '<br>#################################################################################
        <h3>id категории: '.$category['categoryID'].' название: '.$category['name'].' level: 0  </h3>';
        
        $parent_categories[]=array(
            'parent_category_id' => $category['categoryID'],
            'level' => 0
        );

        $subcategories=$sub_categories_object->getChildCategoriesByParentCategory($category['categoryID'], $level);

        print_r($subcategories);

       /*
       
       
        foreach($subcategories as $category_s)
        {
            echo '<br><b>- id категории: '.$category_s['categoryID'].' - родительское id:  главная категория id:'.$category['categoryID'].'  название: '.$category_s['name'].' level: '.$category_s['level'].' parent level: 0 |  has_children: '.$category_s['has_children'].' </b><br>';

            if($category_s['has_children'])
            {
                foreach($category_s['children'] as $category_sub)
                {
                    echo ' -- id категории: '.$category_sub['categoryID'].' - родительское id:  главная категория id:'.$category['categoryID'].' название: '.$category_sub['name'].' level: '.$category_sub['level'].' parent level: '.$category_s['level'].' has_children: '.$category_sub['has_children'].'<br>';
                }
            }
        } 
        */
    }
    
    
    /*
    foreach($main_categories as $category)
	{     
        echo '<br>#################################################################################
        <h3>id категории: '.$category['categoryID'].' название: '.$category['name'].' level: 0  </h3>';
        
        $subcategories=$sub_categories_object->getGetSubCategoriesArray($categories, $category['categoryID'], 1, 0, $category['categoryID']);

        foreach($subcategories as $category_s)
        {
            echo '<br><b>- id категории: '.$category_s['categoryID'].' - родительское id: '.$category_s['parentID'].' главная категория id:'.$category['categoryID'].'  название: '.$category_s['name'].' level: '.$category_s['level'].' parent level: 0 |  has_children: '.$category_s['has_children'].' </b><br>';

            if($category_s['has_children'])
            {
                foreach($category_s['children'] as $category_sub)
                {
                    echo ' -- id категории: '.$category_sub['categoryID'].' - родительское id: '.$category_sub['parentID'].'  главная категория id:'.$category['categoryID'].' название: '.$category_sub['name'].' level: '.$category_sub['level'].' parent level: '.$category_s['level'].' has_children: '.$category_sub['has_children'].'<br>';
                }
            }
        }  
    } 
    */


} 
    catch (Exception $ex) {
    echo $ex->getMessage();
}


?>