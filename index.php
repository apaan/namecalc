<?php

$name = '';
$search = 'a';
if (isset($_REQUEST['name'])) {
	$name = $_REQUEST['name'];
}

if (isset($_REQUEST['search'])) {
	$search = $_REQUEST['search'];
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Perhitungan nama berdasarkan abjad arab">
    <meta name="author" content="Ali Akbar">

    <title>Name Calc</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="http://www.arabic-keyboard.org/keyboard/keyboard.css"> 


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  	<div id="wrap">
	    <div class="navbar navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">NameCalc</a>
	        </div>
	      </div>
	    </div>

	    <div class="container">
	    &nbsp;
	    <div class="row">
	        <div id='input' class="col-md-4">
	        	<div class="panel panel-primary">
	        		<div class="panel-heading">
	        			<h3 class="panel-title">Input</h3>
	        		</div>
	        		<div class="panel-body">

						<form><ul>
								<li>
									<label for='name'>
										<span>Masukkan nama:</span>
										<input type='text' name='name' class="form-control keyboardInput" dir="rtl" value="<?php echo $name ?>"/>
									</label>
								</li>
								<li>
									<label for='search'>
										<span>Sumber padanan:</span>
										<select name='search' class="form-control">
											<option value='a'>Asma'ul Husna</option>
											<option value='aj' <?php echo $search=='aj'?'selected':''?>>Asma'ul Husna + Jausyan Kabir</option>
										</select>
									</label>
								</li>
							</ul>
						</form>
	        		</div>
	        	</div>
			</div>
			<div id='output' class="col-md-8">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Nilai</h3>
					</div>
					<div class="panel-body">
						<span id="output-value" dir="rtl"></span>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Padanan</h3>
					</div>
					<div class="panel-body">
						<div id="ans" class="row" dir="rtl"></span>
					</div>
				</div>
			</div>
	     </div>

	    </div><!-- /.container -->
	</div><!-- /#wrap -->
	<div id="footer">
      <div class="container">
        <p class="text-muted credit">Perhitungan nama berdasar pada abjad arab. Coded by <a href="http://apaan.wordpress.com">Ali</a>.</p>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://www.arabic-keyboard.org/keyboard/keyboard.js" charset="UTF-8"></script> 
    <script src='hitung_nama.js?update=2.1'></script>
    <script>
    	(function() {
	    	var refresh = function() {
		    	var name = $('input[name=name]').val();
				var nameval = valDetail(name);

				var output = $("#output-value");
				output.empty();

				$.each(nameval.components, function(i, v) {
					output.append("<b>" + v.char + "</b>")
					      .append(v.value);
					if (i != nameval.components.length - 1)
						output.append(" + ");
				});
				output.append(" = ")
				      .append(nameval.value);

				var ans = $("select[name=search]").val() == 'a' ? findAN(name): findAN_jk(name);
				console.log('Value: ', nameval, ' ANs: ', ans);

				var outputan = $("#ans");
				outputan.empty();

				$.each(ans, function(i,v) {
					outputan.append("<div class='col-md-1'>" +
					        "<b>يا" + v.name + "</b> " + v.value + " </div>");
				});
			};

			var monitor = function(valfunc, dofunc) {
				var cur = valfunc();
				setInterval(function() {
					var cur1 = valfunc();
					if (cur != cur1) {
						dofunc();
						cur = cur1;
					}
				}, 200);
			};

			var nameText = $('input[name=name]');
			monitor(function() {
				return nameText.val();
			}, refresh);

			var selectSearch = $('select[name=search]');
			monitor(function() {
				return selectSearch.val();
			}, refresh);
			
			<?php if ($name != '') { ?>
			$(function() {setInterval(refresh, 200);});
			<?php } ?>

			/*
	    	$(function() {
	    		$("input[name=name], select[name=search]").keyup(function() {
	    			refresh();
	    		}).change(function() {
					refresh();
	    		});
	    	});*/
    	})();
    </script>
  </body>
</html>
