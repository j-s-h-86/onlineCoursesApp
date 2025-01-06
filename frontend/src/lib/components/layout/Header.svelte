<script>
	import Navigation from '$lib/components/layout/Navigation.svelte';
</script>

<header>
	<h2>Johans asgrymma onlinekurser</h2>
	<Navigation />
</header>

<style>
	header {
		width: 100%;
		height: 75px;
		background-color: #3a424a;
		display: flex;
		justify-content: space-evenly;
		align-items: center;
		border-bottom: 1px solid #ffb764;
	}

	h2 {
		color: #ffb764;
	}
</style>
