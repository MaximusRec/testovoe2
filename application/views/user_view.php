<form name="input" action="/user" method="post">
<h3>Страница пользователя:</h3>
<p style="text-align: center;">
<?= $data ?>
</p>
<p style="text-align: center;">
		<input type="submit" name="quit" value="Выйти">
</p>
<br><hr><br><br>
<p><a href="/user/category">Посмотреть дерево категорий</a></p>
<br><br>
</p>Задание № 3.</p>
<p>3. Написать SQL-запросы для получения следующих данных:
<ul>
	<li><a href="/user/a">a. Для заданного списка товаров получить названия всех категорий, в которых
	представлены товары; (без вложенности)</a></li>

	<li><a href="/user/b">b. Для заданной категории получить список предложений всех товаров из этой категории и
	ее дочерних категорий;</a></li>

	<li><a href="/user/c">c. Для заданного списка категорий получить количество предложений товаров в каждой
	категории;</a></li>

	<li><a href="/user/d">d. Для заданного списка категорий получить общее количество уникальных предложений
	товара;</a></li>

	<li><a href="/user/breadcrumb">e. Для заданной категории получить ее полный путь в дереве (breadcrumb, «хлебные
	крошки»).</a></li>
</ul>
</p>
	</form>
</p>
