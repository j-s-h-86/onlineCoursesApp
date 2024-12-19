<script>
</script>

<nav>
	<ul>
		<li><a href="/" use:link>Hem</a></li>
		<li><a href="/courses" use:link>Kurser</a></li>
		<li><a href="/teachers" use:link>Coacher</a></li>
		<li><a href="/contact" use:link>Kontakt</a></li>
	</ul>
</nav>

<style>
	nav {
		background-color: #333;
		padding: 10px;
		/* position: fixed;
		top: 0;
		left: 0;
		right: 0; */
		z-index: 1000;
	}

	ul {
		list-style-type: none;
		padding: 0;
		margin: 0;
		display: flex;
		justify-content: space-around;
	}

	li {
		display: inline;
	}

	a {
		color: white;
		text-decoration: none;
		font-size: 16px;
		padding: 10px;
	}

	a:hover {
		background-color: #555;
	}
</style>
