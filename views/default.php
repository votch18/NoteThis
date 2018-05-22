<!DOCTYPE html>
<html>
<head>
    <title><?=Config::get("site_name")?></title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">


	<!-- CSS Dependencies 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	
	<script src="/assets/ckeditor/ckeditor.js"></script>
	<script src="/assets/ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="/assets/ckeditor/samples/css/samples.css">
	<link rel="stylesheet" href="/assets/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	-->
	
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/font-awesome.min.css">
	
	<!--<link rel="stylesheet" href="/assets/css/shards.min.css?version=2.0.1">
	<link rel="stylesheet" href="/assets/css/shards-extras.min.css?version=2.0.1">-->
	<link rel="stylesheet" href="/assets/css/style.css">
	

</head>
<body class="shards-landing-page--1">

    <?php
       
        if (Session::get("id") == null) {
            include "_template/nav.php";
        }
    ?>

     <?php echo $content['content_html']; ?>


	  <!-- JavaScript Dependencies 
      <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	 -->
	 
	  <script src="/assets/js/jquery.min.js"></script>
	  <script src="/assets/js/bootstrap.bundle.min.js"></script>
	  
	  
	  <script src="/assets/js/ajax.js"></script>
	  <script src="/assets/js/input.js"></script>
    <script src="/assets/js/options.js"></script>
	   
	  
	<script>
		initSample();
	</script>


</body>
</html>
