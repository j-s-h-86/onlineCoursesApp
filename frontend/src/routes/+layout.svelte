<script>
	import Header from '$lib/layout/Header.svelte';
	import Footer from '$lib/layout/Footer.svelte';

	console.log('Loading __layout.svelte');
</script>

<Header />
<main>
	<slot />
</main>
<Footer />
