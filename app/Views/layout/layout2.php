

<!doctype html>
<html lang="en" dir="ltr">

<?= $this->include('partials/head') ?> 


<body class="geex-dashboard">

	<?= $this->include('partials/header') ?> 


	<main class="geex-main-content">

		<?= $this->include('partials/sidebar') ?> 

		<?= $this->include('partials/customizer') ?> 

		<div class="geex-content">
			<?= $this->renderSection('content') ?> <!-- Main content from the page -->
		</div>
	</main>

	<!-- JAVASCRIPTS START -->
	<script src="<?= base_url('assets/vendor/js/jquery/jquery-3.5.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/js/jquery/jquery-ui.js') ?>"></script>
	<script src="<?= base_url('assets/vendor/js/bootstrap/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/main.js') ?>"></script>
	<!-- JAVASCRIPTS END -->
	
	        <!-- Chatbot removed from admin layout -->
</body>

</html>