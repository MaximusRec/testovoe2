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
		
		$data2 = "Задача: Для заданного списка товаров ('Продукт1', 'Продукт2', 'Продукт22') получить названия всех категорий, в которых представлены товары; (без вложенности):<hr>";
		foreach ( $data as $value ) {
			$data2 .= " | " . $i++ . " | " . $value['name_category'] . "<br>";
		}
			
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
			
			$data2 = "Задача: Для заданной категории получить список предложений всех товаров из этой категории и ее дочерних категорий:<hr>";
		foreach ( $data as $value ) {
			$data2 .=  " | " . $value['category_id'] . " | " . $value['product_name'] . "|<br>";
		}
			
		return $data2; 

    }



	//  получаем хлебные крошки.
    public function viewBreadCrumb ()
    {					
		$sql = 'SELECT breadcrumb(8);';
            try {
                $queryes = $this->pdo->prepare($sql);
                $queryes->execute();
                $data = $queryes->fetch();

            } catch (PDOException $e) {	$data = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                die();
            }		
			
		
		return $data = print_r ($data, true); 
    }
	
	
	
	
	public function get_category()
	{
		$Category = $this->viewAllList( 't_category' );

	return $this->viewCategoryTree( $Category );
	}

	
	//  получаем всей таблицы.
    public function viewAllList ( $table )
    {	include $_SERVER['DOCUMENT_ROOT'] . "/db/" . "pdoconnect.php";	
		if ( !empty($table)) {
				
		$sql = 'SELECT * FROM `' . $table . '`;';
            try {
                $queryes = $pdo->prepare($sql);
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
	
	
	//  получаем массив древовидной структуры.
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
		
	



	

}
