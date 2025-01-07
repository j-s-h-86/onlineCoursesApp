<script>
	import Header from '$lib/components/layout/Header.svelte';
	import Footer from '$lib/components/layout/Footer.svelte';

	console.log('Loading __layout.svelte');
</script>

<Header />
<main>
	<slot />
</main>
<Footer />

<style>
	main {
		background-color: #3a424a;
		padding: 10px;
	}
</style>
