<?php
	declare(strict_types=1);

	function default_meta(string $asd) {
		?>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="/img/favicon.ico">
		<link rel="stylesheet" href="/css/first_theme.css"  id="first_theme"  class="theme_link" disabled>
		<link rel="stylesheet" href="/css/second_theme.css" id="second_theme" class="theme_link" disabled>
		<link rel="stylesheet" href="/css/main.css">
		<link rel="stylesheet" href="/css/bootstrap-theme.css">
		<link rel="stylesheet" href="/css/bootstrap.css">
		<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/<?=$asd?>.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<link href="http://allfont.ru/allfont.css?fonts=open-sans" rel="stylesheet" type="text/css">
		
		<script>
			document.title += " | Mind";
		</script>

		<script src="/js/bootstrap.js"></script>
		<script>
            $(window).on('load', function () {
                $('.container').delay(400).fadeIn();
                $('.loader').delay(100).fadeOut();
            });
        </script>
		<?php
	}

	function menu_button($title, $url) {
		?>
		<li><a href="<?=$url?>" class="menulink">
			<?=$title?>	
		</a></li>
		<?php
	}

	function menu() {
		$curr = get_curr();

		$buttons = [
			// [role, title, url]
			["all", "Мой профиль", "/profile"],
			["student", "Выписка по баллам", "/points"],
			["student", "Передать баллы", "/give"],
			["teacher", "Изменить баллы", "/award"],
			["classruk", "Выписка по классу", "/class"],
			["all", "Расписание", "/calendar"],
			["all", "Выйти", "/out"]
		];

		?>
		<nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
						<?php
							foreach ($buttons as $button) {
								if ($button[0]=="all" || $curr->has_role($button[0])) {
									menu_button($button[1], $button[2]);
								}
							}
						?>
						<!-- <span id="choose_theme">
							<button>Сменить тему</button>
							<span id="choose_theme_vars" hidden>
								<button>Первая</button>
								<button>Вторая</button>
							</span>
						</span> -->
					</ul>
				</div>
			</div>
		</nav>
			<script src="/js/menu.js"></script>
			<?php
	}

	function select_student() {
		?>
		<script>
			var student_list = <?= get_classes_json(); ?>;
		</script>
		<select id="class_select" class="form-control"></select>
		<br>
		<select id="student_select" class="form-control" name="login"></select>
		<br>
		<script src="/js/select_student.js"></script>
		<?php
	}
?>