<?php

class Controller_User extends Controller
{
	function __construct()
	{
		$this->model = new Model_User();
		$this->view = new View();
	}
	
	function action_index()
	{	
			if ( isset ($_POST['quit'] ) ) { 
					unset ($_SESSION); session_destroy(); 					
			}  
			
			if ( $this->authorization() == FALSE )	
			{   		$this->redirect( 'enter' );
			} else  {
				$str = "Добрый день, <strong>" . $_SESSION['login'] . "</strong>";
				$this->view->generate('user_view.php', 'template_view.php', $str );
			}
	}
	
		
	function action_category()
	{	$category = "Выводим категории продуктов.";
		$category = $this->model->get_category();
		$this->view->generate('user_category.php', 'template_view.php', $category );
	}	

		
	function action_a()
	{	$data = $this->model->get_a();
		$this->view->generate('user_a.php', 'template_view.php', $data );
	}
		
		
	function action_b()
	{	$data = $this->model->get_b();
		$this->view->generate('user_a.php', 'template_view.php', $data );
	}
		
		
	function action_c()
	{	$data = $this->model->get_c();
		$this->view->generate('user_c.php', 'template_view.php', $data );
	}
		
	function action_d()
	{	$data = $this->model->get_d();
		$this->view->generate('user_d.php', 'template_view.php', $data );
	}
		
	function action_breadcrumb()
	{	$data = $this->model->get_breadcrumb();
		$this->view->generate('user_breadcrumb.php', 'template_view.php', $data );
	}	
	
	
	
	
}
