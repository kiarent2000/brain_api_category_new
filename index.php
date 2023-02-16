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

 
  
   $categories = (new PrepareArray())->getArray(); // получение массива всех категорий

 
    $main_categories = (new getMainCategories())->getMainCategoriesArray($categories, $main_categories_list); // получение массива главных категорий
 
    $level=0;

    function category_print($category_id, $name, $has_children, $children, $level, $parents)
        {
            
            $level=$level+1;
            
            switch ($level)
            {
                case 0:
                $defis = ' - ';
                break;

                case 1:
                $defis = ' -- ';
                break;

                case 2:
                $defis = ' --- ';
                break;

                case 3:
                $defis = ' ---- ';
                break;

                case 4:
                $defis = ' ----- ';
                break;
            }

            echo $defis.' | id категории: '.$category_id.' название: '.$name.' level: '.$level.'  has_children: '.$has_children.'<br>';


           
            foreach($parents as $key=>$value)
            {                
                echo 'id категории:'.$category_id.' parent_id: '.$value.' level:'.$key.'<br>';
            }


            if($has_children)
            {
                foreach($children as $child)
                {
                    category_print($child['categoryID'], $child['name'], $child['has_children'], $child['children'], $child['level'], $child['parents']); 
                }
            } 
        }

    $sub_categories_object = new GetSubCategories($categories);
    
    

    foreach($main_categories as $category)
	{     
       
        
        echo '<br>#################################################################################
        <h3>id категории: '.$category['categoryID'].' название: '.$category['name'].' level: 0  </h3>';
        
        $parent_categories[]=$category['categoryID'];

        $subcategories=$sub_categories_object->getChildCategoriesByParentCategory($category['categoryID'], $level, $parent_categories);
        

        foreach($subcategories as $category_s)
        {
            category_print($category_s['categoryID'], $category_s['name'], $category_s['has_children'], $category_s['children'], $category_s['level'], $category_s['parents']);

           // $sub_categories_object->convertArrayToOpencartCategoryTreee($category_s['categoryID'], $category_s['name'], $category_s['has_children'], $category_s['children'], $category_s['level'], $category_s['parents']);


            /*$prepared_categories = $sub_categories_object->convertArrayToOpencartCategoryTreee($category_s['categoryID'], $category_s['name'], $category_s['has_children'], $category_s['children'], $category_s['level'], $category_s['parents']);



            
            foreach($prepared_categories as $prepared_category)
            {
                echo '| id категории: '.$prepared_category['category_id'].' название: '.$prepared_category['name'].' level: '.$prepared_category['level'].'  has_children: '.$prepared_category['has_children'].'<br>'; 

                foreach($prepared_category['path_array'] as $path_array)
                {
                //    echo 'id категории:'.$path_array['category_id'].' path_id: '.$path_array['path_id'].' level:'.$path_array['level'].'<br>';
                }

                echo "<br>";

            }     

*/

        }


        /*
        $prepared_categories = $sub_categories_object->convertArrayToOpencartCategoryTreee($category_s['categoryID'], $category_s['name'], $category_s['has_children'], $category_s['children'], $category_s['level'], $category_s['parents']);

            
            foreach($prepared_categories as $prepared_category)
            {
                echo '| id категории: '.$prepared_category['category_id'].' название: '.$prepared_category['name'].' level: '.$prepared_category['level'].'  has_children: '.$prepared_category['has_children'].'<br>'; 

                foreach($prepared_category['path_array'] as $path_array)
                {
                    echo 'id категории:'.$path_array['category_id'].' path_id: '.$path_array['path_id'].' level:'.$path_array['level'].'<br>';
                }

                echo "<br>";

            }         
*/





      //  print_r($subcategories);

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