<script>
	let isMenuOpen = false;
	const links = [
		{ name: 'Hem', url: '/' },
		{ name: 'Kurser', url: '/courses' },
		{ name: 'Våra lärare', url: '/teachers' },
		{ name: 'Kontakt', url: '/contact' },
		{ name: 'Admin', url: '/login' }
	];

	function closeMenu() {
		isMenuOpen = false;
	}
</script>

<nav>
	<button
		class="hamburger"
		on:click={() => (isMenuOpen = !isMenuOpen)}
		aria-label="Toggle navigation menu"
		aria-expanded={isMenuOpen}
	>
		<span class="bar"></span>
		<span class="bar"></span>
		<span class="bar"></span>
	</button>

	<ul class:open={isMenuOpen}>
		{#each links as link}
			<li><a href={link.url} on:click={closeMenu}>{link.name}</a></li>
		{/each}
	</ul>
</nav>

<style>
	nav {
		position: relative;
		z-index: 10;
	}

	.hamburger {
		display: none;
		flex-direction: column;
		justify-content: space-around;
		width: 30px;
		height: 30px;
		background: none;
		border: none;
		cursor: pointer;
		z-index: 10;
	}

	.bar {
		width: 100%;
		height: 3px;
		background-color: #ffb764;
		border-radius: 5px;
	}

	ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		display: flex;
		justify-content: space-around;
	}

	li {
		margin: 0;
	}

	a {
		text-decoration: none;
		color: #ffb764;
		padding: 10px;
	}

	@media (max-width: 768px) {
		.hamburger {
			display: flex;
		}

		ul {
			display: none;
			position: absolute;
			top: 40px;
			right: 0;
			background-color: #333;
			flex-direction: column;
			width: 200px;
			border-radius: 8px;
		}

		ul.open {
			display: flex;
		}

		li {
			text-align: center;
			padding: 10px;
		}

		a:hover {
			background-color: #555;
		}
	}
</style>
