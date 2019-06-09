<?php

include $_SERVER['DOCUMENT_ROOT'] . "/application/" . "usersClass.php";	

	

class Model_User extends Model
{
	var $pdo;
	
	public function __construct()
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/db/" . "pdoconnect.php";	
        $this->pdo= $pdo;

    }
	
	public function get_data()
	{			
		if ( !empty($_POST['login']) AND !empty( $_POST['password']) )
		{
				$obj = NEW Users; 
				$user = $obj->findUser( $_POST['login'], $_POST['password'] );
				
				if (isset ($user) )
				{	
					$_SESSION['access'] = 'yes';
					$_SESSION['login'] = $_POST ['login'];
					$_SESSION['pass'] = $_POST['password'];
					$_SESSION['qnt'] = 1;
					if (!empty($_SESSION['login'])) $_SESSION['lasttime'] = time();
					$_SESSION['error'] = 'ok';
				} else {
					$_SESSION['access'] == 'no';
					$_SESSION['lasttime'] = time() + ( 1 * 60 );
				}			
				return $user;
		} 
		else return NULL;
		
	}


	//  получаем результат запроса 3.а.
    public function get_a ()
    {	
		$i= 0;			
		$sql = "SELECT DISTINCT c.`name_category` FROM `t_product` p 
					INNER JOIN `t_product_category` pc ON pc.`product_id` = p.`product_id`
					INNER JOIN `t_category` c ON c.`category_id` = pc.`category_id`
				WHERE p.`product_name` IN ('Продукт1', 'Продукт2', 'Продукт22') ;";
			
		try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetchAll();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }		
		
		$data2 = "Задача: Для заданного списка товаров ('Продукт1', 'Продукт2', 'Продукт22') получить названия всех категорий, 
						в которых представлены товары; (без вложенности):<br>
						<table style=' width: 50%; '>";
		$data2 .= "<tr><td>№</td><td>Название категории<br></td></tr>";
		
		foreach ( $data as $value ) {
			$data2 .= "<tr><td>" . $i++ . "</td><td>" . $value['name_category'] . "</td></tr>";
		}
		$data2 .= "</table>";
		
		return $data2; 
    }	
	
	
	//  получаем результат запроса 3.b.
    public function get_b ()
    {		
		
		$sql = 'SELECT c.`category_id`, p.`product_name` FROM `t_category` c 
					INNER JOIN `t_product_category` pc ON pc.`category_id` = c.`category_id` 
					INNER JOIN `t_product` p ON p.`product_id` = pc.`product_id` 
				WHERE c.`category_id` IN ( SELECT `child_id` FROM `closure_table` WHERE `parent_id` = 11 )
				ORDER BY c.`category_id` ;';				
		
        try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetchAll();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }
			
			$data2 = "Задача: Для заданной категории получить список предложений всех товаров из этой категории и ее дочерних категорий:<br>
						<table style=' width: 50%; '>";
			$data2 .= "<tr><td>id категории</td><td>Название товара<br></td></tr>";
		foreach ( $data as $value ) {
			$data2 .=  "<tr><td>" . $value['category_id'] . "</td><td>" . $value['product_name'] . "</td></tr>";
		}
			$data2 .= "</table>";
			
		return $data2; 

    }


	
	
	//  получаем результат запроса 3.c.
    public function get_c ()
    {			
		$sql = "SELECT c.`category_id`, c.`name_category`, COUNT(p.`product_id`) as `counts` FROM `t_category` c 
					INNER JOIN `t_product_category` pc ON pc.`category_id` = c.`category_id` 
					INNER JOIN `t_product` p ON p.`product_id` = pc.`product_id` 
				WHERE c.`name_category` IN ('Молочные продукты', 'Торты', 'Вкусняшки') 
				GROUP BY c.`category_id` ;";				
				
        try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetchAll();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }
			
		$data2 = "Задача: Для заданного списка категорий получить количество предложений товаров в каждой категории: <br><br>
					<table style=' width: 70%; '>";
		$data2 .= "<tr><td>id категории</td><td>Название категории<br></td><td>Количество</td></tr>";
		
		foreach ( $data as $value ) {
			$data2 .=  "<tr><td>" . $value['category_id'] . 
						"</td><td>" . $value['name_category'] .
						"</td><td>" . $value['counts'] . "</td></tr>";
		}			
			$data2 .= "</table>";
			
		return $data2; 
    }	
	
	
	
	//  получаем результат запроса 3.d.
    public function get_d ()
    {			
		$sql = "SELECT COUNT(DISTINCT p.`product_id`) as `countProduct` FROM `t_category` c 
					INNER JOIN `t_product_category` pc ON pc.`category_id` = c.`category_id` 
					INNER JOIN `t_product` p ON p.`product_id` = pc.`product_id` 
				WHERE c.`name_category` IN ('Молочные продукты', 'Торты', 'Вкусняшки', 'Сыр') ;";				
				
        try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetchAll();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }

		$data2 = "Задача: Для заданного списка категорий получить общее количество уникальных предложений товара:<strong> {$data[0]['countProduct']}</strong> товаров.";

		return $data2; 

    }



	//  получаем хлебные крошки.
    public function getBreadCrumb ()
    {					
		$sql = 'SELECT breadcrumb(8) as `breadcrumb`;';
            try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetch();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }		
			
			$data = "Для заданной категории получить ее полный путь в дереве (breadcrumb, «хлебные	крошки»): <strong>".$data['breadcrumb']."</strong>";

		return $data; 
    }
	
	
	
	/**
	*	Отдаём HTML структуру категорий с вложенность.
	*
	*/
	public function get_category()
	{
		$Category = $this->viewAllList( 't_category' );
		$Category2 = $this->viewCategoryTree( $Category );

	return $this->getMenuHtml( $Category2, 0 );
	}

	
	//  получаем всех категорий из БД.
    public function viewAllList ( $table )
    {	
		if ( !empty($table)) {
				
		$sql = 'SELECT * FROM `' . $table . '`;';
            try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetchAll();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }		
			
		foreach ( $data as $value ) {
			$data2[$value['category_id']] = $value;
		}
		
		return $data2; 
		} else return NULL;
    }	
	
	
	//  получаем дерево категорий.
    public function viewCategoryTree ( $data )
    {
        $tree=[];

        foreach ($data as $id=>&$node) {
             if (!$node['parent_id'])
                 $tree[$id] = &$node;
              else
                 $data[$node['parent_id']]['childs'][$node['category_id']] = &$node;
        }
    return $tree;
    }
		
	

    /**
     * Формируем список для вывода
     * @param $tree - Массив многомерный древовидный
     * @param $counter - необходим доп параметр для типа маркера  списка
     * @return string HTML
     */
    public function getMenuHtml($tree, $counter ){
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category, $counter);
        }
	return $str="<ul>{$str}</ul>";
    }


    /**
     * Формируем список для вывода, доп ф-я, рекурсивная
     * @param $tree - Массив многомерный древовидный
     * @param $counter - необходим доп параметр для типа маркера  списка
     * @return string HTML
     */
    public function catToTemplate($category, $counter ){
        $str = ''; if (empty ($counter) ) $counter = 0;
        $str .= '<li> ('.$category['category_id'].') ';
        $str .= $category['name_category'] ;
        $str .= '</li>';

        if ( !empty( $category['childs'] ) )
        {   $counter++;
            $str .= '<ul>';
            $str .= $this->getMenuHtml($category['childs'], $counter );
            $str .= '</ul>';
        } else {   $i=0; }
        return $str;
    }	

}
